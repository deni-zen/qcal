<?php
/**
 * Date/Time Recurrence Yearly Frequency Class
 * Recurrence rules affect yearly recurrences in the following ways:
 * 
 *      ByYearDay - Sets the day of the year the recurrence will take place
 *      ByMonthDay - Sets the day of the month recurrence will take place
 *      ByDay - Sets the day of the week recurrence will take place
 *      ByWeekNo - Sets week of the year
 *      ByMonth - Sets the month the recurrence will take place
 *      ByHour - Sets the hour of each recurrence
 *      ByMinute - Sets the minute of each recurrence
 *      BySecond - Sets the second of each recorrence
 *      BySetPos - Determines the recurrences in the set to return
 *
 * This frequency works by looping by year and creating a recurrence for every
 * matching date in that year
 *
 * @package     qCal
 * @subpackage  qCal\DateTime\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\DateTime\Recur\Freq;
use \qCal\DateTime as DT,
    \qCal\DateTime\Recur\Recurrence;

class Yearly extends \qCal\DateTime\Recur\Freq {

    public function getNextInterval(\qCal\DateTime $date) {
    
        return DT::rollover($date->getYear() + $this->getInterval(), $date->getMonth(), $date->getMonthDay(), $date->getHour(), $date->getMinute(), $date->getSecond());
        
    }
    
    /**
     * As the recurrence loops over recurrence intervals, it needs to grab an
     * array of the recurrences for this interval
     */
    public function getRecurrences($start) {
    
        $rules = $this->getRulesArray();
        
        $year = $start->getYear();
        $daterecs = array();
        $recurrences = array();
        if (empty($rules['byMonth'])) {
            // if no byMonth and no byWeekNo and no byYearDay are set, then this means search entire year
            if (empty($rules['byYearDay']) && empty($rules['byWeekNo'])) {
                foreach ($rules['byDay'] as $byDay) {
                    // @todo Move this functionality into the ByDay Rule
                    if (preg_match('/([+-]?[0-9]+)?(MO|TU|WE|TH|FR|SA|SU)?/i', $byDay, $matches)) {
                        list($string, $num, $day) = $matches;
                        if (!$date = DT::getXthWeekdayOfYear($num, $day, $year)) {
                            throw new \Exception('Could not generate ' . $num . 'st ' . $day . ' of ' . $year);
                        }
                        $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                    }
                }
            }
        } else {
            foreach ($rules['byMonth'] as $month) {
                foreach ($rules['byMonthDay'] as $monthDay) {
                    if ($monthDay < 0) {
                        $date = DT::rollover($year, $month, 1);
                        $monthDays = $date->getDaysInMonth($year, $month);
                        $monthDay = $monthDays + $monthDay;
                    }
                    $daterecs[] = array('year' => $year, 'month' => $month, 'day' => $monthDay);
                }
                foreach ($rules['byDay'] as $byDay) {
                    if (preg_match('/([+-]?[0-9]+)?(MO|TU|WE|TH|FR|SA|SU)?/i', $byDay, $matches)) {
                        list($string, $num, $day) = $matches;
                        if ((int) $num) {
                            // there was a number specified, so get that particular weekday of the month (ie: 3rd Sunday in November)
                            $date = DT::getXthWeekdayOfMonth($num, $day, $month, $year);
                            $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                        } else {
                            // no number specified so get all the weekdays in the month (every Tuesday in November)
                            $dates = DT::getAllWeekdaysInMonth($day, $month, $year);
                            // @todo need to add these to $daterecs
                        }

                    }
                }
            }
        }
        
        if (!empty($rules['byWeekNo'])) {
            // get an array of all the weeks in a given year
            $weeks = DT::generateYearWeeks($year);
            foreach ($rules['byWeekNo'] as $wk) {
                if ($wk < 0) {
                    $wk = 52 + $wk;
                }
                $week = $weeks[$wk];
                $fotw = new DT($week);
                if (empty($rules['byDay'])) {
                    $rules['byDay'] = array($this->getRecur()->getStart()->getDay());
                }
                foreach ($rules['byDay'] as $day) {
                    // @todo ByDay accepts a number so 1SU would be 1st sunday, -1SU would be last Sunday
                    // @todo I have no idea if this is the right way to do this
                    // @todo move this preg match into a method
                    if (preg_match('/([+-]?[0-9]+)?(MO|TU|WE|TH|FR|SA|SU)?/i', $day, $matches)) {
                        list($string, $num, $day) = $matches;
                    }
                    for ($i = 0; $i < 7; $i++) {
                        $date = DT::rollover($fotw->getYear(), $fotw->getMonth(), $fotw->getMonthDay() + $i);
                        if ($date->getDay() == $day) $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                    }
                }
            }
        }
        
        foreach ($rules['byYearDay'] as $yd) {
            // use date/time class's rollover method to create a date on the 100th day of january (or whatever byYearDay is)
            $date = \qCal\DateTime::rollover($year, 1, $yd);
            if (!empty($rules['byDay'])) {
                // @todo The RFC says that when ByDay and ByYearDay are both set, it is supposed to further limit recurrences, but I don't understand how it's supposed to work
                foreach ($rules['byDay'] as $day) {
                    if ($date->getDay() == $day) $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                }
            } else {
                $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
            }
        }
        
        // once we have all of the dates, create recurrences for all the
        // times as well
        if (empty($rules['byHour'])) $rules['byHour'] = array($this->getRecur()->getStart()->getHour());
        if (empty($rules['byMinute'])) $rules['byMinute'] = array($this->getRecur()->getStart()->getMinute());
        if (empty($rules['bySecond'])) $rules['bySecond'] = array($this->getRecur()->getStart()->getSecond());
        foreach ($daterecs as $daterec) {
            foreach ($rules['byHour'] as $hour) {
                foreach ($rules['byMinute'] as $minute) {
                    foreach ($rules['bySecond'] as $second) {
                        $dt = DT::rollover($daterec['year'], $daterec['month'], $daterec['day'], $hour, $minute, $second);
                        $recurrences[$dt->toUtcDateTime()] = $dt;
                    }
                }
            }
        }
        
        // Sort the recurrences by date
        ksort($recurrences);
        $return = array();
        foreach ($recurrences as $dt) {
            $return[$dt->toUtcDateTime()] = new Recurrence($dt);
        }
        return $return;
    
    }

}
