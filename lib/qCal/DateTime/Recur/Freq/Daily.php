<?php
/**
 * Date/Time Recurrence Daily Frequency Class
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
    \qCal\DateTime\Recur\Recurrence,
    \qCal\Exception\DateTime\Recur as RecurException; // @todo use more specific exception

class Daily extends \qCal\DateTime\Recur\Freq {

    public function getNextInterval(\qCal\DateTime $date) {
    
        $year = $date->getYear();
        $month = $date->getMonth();
        $day = $date->getMonthDay() + $this->getInterval();
        return $date = DT::rollover($year, $month, $day, $date->getHour(), $date->getMinute(), $date->getSecond());
        
        // @todo I don't think these are needed
        if ($day > $date->getDaysInMonth()) {
            $date = DT::rollover($year, $month, $day, $date->getHour(), $date->getMinute(), $date->getSecond());
        }
        return DT::rollover($year, $month, $date->getMonthDay(), $date->getHour(), $date->getMinute(), $date->getSecond());
        
    }
    
    /**
     * As the recurrence loops over recurrence intervals, it needs to grab an
     * array of the recurrences for this interval. In this case, there can only
     * be one date returned, but multiple recurrences can be generated if any
     * time-related recurrence rules are specified
     */
    public function getRecurrences($start) {
    
        $rules = $this->getRulesArray();
        
        $datevalid = array();
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
            // if byMonthDay value is set, set this to false because both byMonthDay and byDay have to be true if both are set
            $datevalid['byMonthDay'] = false;
            foreach ($rules['byMonthDay'] as $monthDay) {
            
                if ($monthDay < 0) {
                    $monthDay = $start->getDaysInMonth() + $monthDay;
                }
                if ($monthDay == $start->getMonthDay()) $datevalid['byMonthDay'] = true;
                //$daterecs[] = array('year' => $start->getYear(), 'month' => $start->getMonth(), 'day' => $monthDay);
            
            }
        }
        
        if (!empty($rules['byDay'])) {
            $datevalid['byDay'] = false;
            foreach ($rules['byDay'] as $byDay) {
            
                if (preg_match('/([+-]?[0-9]+)?(MO|TU|WE|TH|FR|SA|SU)?/i', $byDay, $matches)) {
                    list($string, $num, $day) = $matches;
                    if ((int) $num) {
                        // @todo Throw more specific exception once exceptions are re-organized/refactored
                        throw new RecurException('BYDAY rule must not specify an ordinal value for DAILY frequency types');
                        /* @todo ByDay is not allowed to specify a number so throw an exception here
                        // there was a number specified, so get that particular weekday of the month (ie: 3rd Sunday in November)
                        $date = DT::getXthWeekdayOfMonth($num, $day, $start->getMonth(), $start->getYear());
                        $daterecs[] = array('year' => $date->getYear(), 'month' => $date->getMonth(), 'day' => $date->getMonthDay());
                        */
                    } else {
                        // no number specified, so return a date only if it falls on one of the specified days
                        if ($start->getDay() == $byDay) {
                            $datevalid['byDay'] = true;
                            //$daterecs[] = array('year' => $start->getYear(), 'month' => $start->getMonth(), 'day' => $start->getMonthDay());
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
        
        // if this date doesn't meet all the rule requirements, return an empty array because date doesn't match
        foreach ($datevalid as $valid) if (!$valid) return array();
        
        // once we have all of the dates, create recurrences for all the
        // times as well
        if (empty($rules['byHour'])) $rules['byHour'] = array($this->getRecur()->getStart()->getHour());
        if (empty($rules['byMinute'])) $rules['byMinute'] = array($this->getRecur()->getStart()->getMinute());
        if (empty($rules['bySecond'])) $rules['bySecond'] = array($this->getRecur()->getStart()->getSecond());
        foreach ($rules['byHour'] as $hour) {
            foreach ($rules['byMinute'] as $minute) {
                foreach ($rules['bySecond'] as $second) {
                    $dt = DT::rollover($start->getYear(), $start->getMonth(), $start->getMonthDay(), $hour, $minute, $second);
                    $recurrences[$dt->toUtcDateTime()] = $dt;
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
