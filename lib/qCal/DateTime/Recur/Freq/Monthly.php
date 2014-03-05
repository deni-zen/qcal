<?php
/**
 * Date/Time Recurrence Monthly Frequency Class
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

class Monthly extends \qCal\DateTime\Recur\Freq {

    public function getNextInterval(\qCal\DateTime $date) {
    
        $year = $date->getYear();
        $month = $date->getMonth() + $this->getInterval();
        if ($month > 12) {
            $year++;
            $month = $month - 12;
        }
        return DT::rollover($year, $month, $date->getMonthDay(), $date->getHour(), $date->getMinute(), $date->getSecond());
        
    }
    
    /**
     * As the recurrence loops over recurrence intervals, it needs to grab an
     * array of the recurrences for this interval
     */
    public function getRecurrences($start) {
    
        $rules = $this->getRulesArray();
        
        $daterecs = array();
        $recurrences = array();
        
        if (!empty($rules['byMonth'])) {
            $months = array();
            $byMonth = $rules['byMonth'];
            foreach ($byMonth as $month) {
                if ($month < 0) {
                    $month = 12 + $month;
                }
                $months[] = $month;
            }
            // if this month is not in the list of allowed months, return no recurrences
            if (!in_array($start->getMonth(), $months)) return array();
        }
        
        if (!empty($rules['byMonthDay'])) {
            foreach ($rules['byMonthDay'] as $monthDay) {
            
                if ($monthDay < 0) {
                    $monthDay = $start->getDaysInMonth() + $monthDay;
                }
                $daterecs[] = array('year' => $start->getYear(), 'month' => $start->getMonth(), 'day' => $monthDay);
            
            }
        }
        
        if (!empty($rules['byDay'])) {
            foreach ($rules['byDay'] as $byDay) {
            
                if (preg_match('/([+-]?[0-9]+)?(MO|TU|WE|TH|FR|SA|SU)?/i', $byDay, $matches)) {
                    list($string, $num, $day) = $matches;
                    if ((int) $num) {
                        // there was a number specified, so get that particular weekday of the month (ie: 3rd Sunday in November)
                        $date = DT::getXthWeekdayOfMonth($num, $day, $start->getMonth(), $start->getYear());
                        $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                    } else {
                        // no number specified so get all the weekdays in the month (every Tuesday in November)
                        $dates = DT::getAllWeekdaysInMonth($day, $start->getMonth(), $start->getYear());
                        foreach ($dates as $date) {
                            $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                        }
                    }
                }
            
            }
        }
        
        if (!empty($rules['byWeekNo'])) {
            throw new \Exception('BYWEEKNO cannot be specified for MONTHLY frequency.');
        }
        if (!empty($rules['byYearDay'])) {
            throw new \Exception('BYYEARDAY cannot be specified for MONTHLY frequency.');
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
