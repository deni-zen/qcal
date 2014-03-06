<?php
/**
 * Date/Time Recurrence Weekly Frequency Class
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

class Weekly extends \qCal\DateTime\Recur\Freq {

    public function getNextInterval(\qCal\DateTime $date) {
    
        $year = $date->getYear();
        // @todo this method needs to support WKST but this is fine for now
        $week = $date->getWeekNo();
        // rollover should take care of any change in month or year
        return DT::rollover($year, $date->getMonth(), $date->getMonthDay() + (7 * $this->getInterval()), $date->getHour(), $date->getMinute(), $date->getSecond());
    
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
        
        if (!empty($rules['byDay'])) {
        
            foreach ($rules['byDay'] as $byDay) {
            
                // this just makes sure no invalid BYDAY values are specified
                if (preg_match('/([+-]?[0-9]+)?(MO|TU|WE|TH|FR|SA|SU)?/i', $byDay, $matches)) {
                    list($string, $num, $day) = $matches;
                    if ((int) $num) {
                        // @todo Throw more specific exception once exceptions are re-organized/refactored
                        throw new RecurException('BYDAY rule must not specify an ordinal value for WEEKLY frequency types');
                    }
                }
            
            }
            
            $dates = DT::getWeekdaysInWeek($rules['byDay'], $start->getWeekNo(), $start->getYear());
            foreach ($dates as $date) {
                $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
            }
        
        }
        
        // @todo Throw specific exceptions here
        if (!empty($rules['byWeekNo'])) {
            throw new \Exception('BYWEEKNO cannot be specified for WEEKLY frequency.');
        }
        if (!empty($rules['byYearDay'])) {
            throw new \Exception('BYYEARDAY cannot be specified for WEEKLY frequency.');
        }
        if (!empty($rules['byMonthDay'])) {
            throw new \Exception('BYMONTHDAY cannot be specified for WEEKLY frequency.');
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
