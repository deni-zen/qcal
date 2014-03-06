<?php
/**
 * qCal DateTime Class
 * Since PHP v5.2, the DateTime class allows dates without the limitations that
 * were a problem in the past. This class makes use of the \DateTime class but
 * doesn't extend it because it provides more functionality than needed.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal;
 
class DateTime {

    /**
     * Date format constants
     */
    
    // Floating date/time formats
    const FORMAT_DATETIME = 'Ymd\THis';
    const FORMAT_DATE = 'Ymd';
    const FORMAT_TIME = 'His';
    
    // UTC date/time formats
    const FORMAT_UTC_DATETIME = 'Ymd\THis\Z';
    const FORMAT_UTC_DATE = 'Ymd';
    const FORMAT_UTC_TIME = 'His\Z';
    
    /**
     * Weekdays
     */
    static protected $wDays = array(
        'SU' => 'sunday',
        'MO' => 'monday',
        'TU' => 'tuesday',
        'WE' => 'wednesday',
        'TH' => 'thursday',
        'FR' => 'friday',
        'SA' => 'saturday'
    );
    
    /**
     * Months
     */
    static protected $months = array(
         1 => 'january',
         2 => 'february',
         3 => 'march',
         4 => 'april',
         5 => 'may',
         6 => 'june',
         7 => 'july',
         8 => 'august',
         9 => 'september',
        10 => 'october',
        11 => 'november',
        12 => 'december'
    );
    
    /**
     * Months
     */
    static protected $mAbbr = array(
        'JAN' => 'january',
        'FEB' => 'february',
        'MAR' => 'march',
        'APR' => 'april',
        'MAY' => 'may',
        'JUN' => 'june',
        'JUL' => 'july',
        'AUG' => 'august',
        'SEP' => 'september',
        'OCT' => 'october',
        'NOV' => 'november',
        'DEC' => 'december'
    );
    
    /**
     * @var \DateTime DateTime class
     */
    protected $dt;
    
    /**
     * @var qCal\DateTime\TimeZone A time zone representation
     */
    protected $tz;
    
    /**
     * Class constructor
     * The date/time is saved internally as a UTC date/time object. Only when
     * specifically asked for local time does it apply the time zone offset.
     * 
     * @param string Date/Time input
     * @param qCal\DateTime\TimeZone The time zone for this date/time
     */
    public function __construct($time, $timezone = null) {
    
        $this->dt = new \DateTime($time, new \DateTimeZone('UTC'));
    
    }
    
    /**
     * Create a date/time using rollover
     * Allows you to create a date on the 100th day of january, 2014 and stuff
     */
    static public function rollover($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null) {
    
        $ts = gmmktime($hour, $minute, $second, $month, $day, $year);
        return new DateTime(gmdate('Ymd\THis', $ts));
    
    }
    
    /**
     * Generate weeks for a given year
     * @todo implement week start option
     * @todo Come back to this later
     */
    static public function generateYearWeeks($year, $wkst = null) {
    
        $week = 1;
        $fmt = '%04d%02d%02d';
        $foty = self::rollover($year, 1, 1);
        // @todo find the first Monday of the year and start from there
        for ($day = 1; $week <= 52; $day++) {
            if ($day == 1) {
                $date = self::rollover($year, 1, $day);
                $weeks[$week] = sprintf($fmt, $date->getYear(), $date->getMonth(), $date->getMonthDay());
                $week++;
            }
            if ($day % 7 == 0) {
                $date = self::rollover($year, 1, $day+1);
                $weeks[$week] = sprintf($fmt, $date->getYear(), $date->getMonth(), $date->getMonthDay());
                $week++;
            }
        }
        return $weeks;
    
    }
    
    /**
     * @todo Throw exceptions
     */
    static public function getXthWeekdayOfMonth($xth, $weekday, $month, $year) {
    
        $sign = substr($xth, 0, 1);
        if ($sign != '+' && $sign != '-') $sign = '+';
        $xth = abs((int) $xth);
        $weekdays = array_keys(self::$wDays);
        
        $wds = 0; // num of weekdays passed in loop
        $fotm = self::rollover($year, $month, 1);
        if ($sign == '+') {
        
            $day = 1;
            $wday = $fotm->getDayOfWeek();
            while ($day <= $fotm->getDaysInMonth()) {
                if ($weekday == $weekdays[$wday]) { // found weekday
                    $wds++;
                    if ($wds == $xth) return self::rollover($year, $month, $day);
                }
                if ($wday == 6) $wday = 0;
                else $wday++;
                $day++;
            }
        
        } else {
        
            $lotm = self::rollover($year, $month, $fotm->getDaysInMonth());
            $wday = $lotm->getDayOfWeek();
            $day = $lotm->getDaysInMonth();
            while ($day >= 1) {
                if ($weekday == $weekdays[$wday]) { // found weekday
                    $wds++;
                    if ($wds == $xth) return self::rollover($year, $month, $day);
                }
                if ($wday == 0) $wday = 6;
                else $wday--;
                $day--;
            }
        
        }
    
    }
    
    /**
     * @todo Throw exceptions
     */
    static public function getXthWeekdayOfYear($xth, $weekday, $year) {
    
        $sign = substr($xth, 0, 1);
        if ($sign != '+' && $sign != '-') $sign = '+';
        $xth = abs((int) $xth);
        $weekdays = array_keys(self::$wDays);
        
        $wds = 0; // num of weekdays passed in loop
        if ($sign == '+') {
        
            $day = 1;
            $foty = self::rollover($year, 1, 1);
            $diy = $foty->getDaysInYear();
            $wday = $foty->getDayOfWeek();
            while ($day <= $diy) {
            
                if ($weekday == $weekdays[$wday]) { // found weekday
                    $wds++;
                    if ($wds == $xth) return self::rollover($year, 1, $day);
                }
                if ($wday == 6) $wday = 0;
                else $wday++;
                $day++;
            }
            
            
        } else {
        
            $loty = self::rollover($year, 12, 31);
            $diy = $loty->getDaysInYear();
            $day = $diy;
            $wday = $loty->getDayOfWeek();
            while ($day >= 1) {
                if ($weekday == $weekdays[$wday]) { // found weekday
                    $wds++;
                    if ($wds == $xth) return self::rollover($year, 1, $day);
                }
                if ($wday == 0) $wday = 6;
                else $wday--;
                $day--;
            }
        
        }
    
    }
    
    static public function getAllWeekdaysInMonth($weekDay, $month, $year) {
    
        $dates = array();
        $weekdays = array_keys(self::$wDays);
        $fotm = self::rollover($year, $month, 1);
        $wday = $fotm->getDayOfWeek();
        $day = 1;
        while ($day <= $fotm->getDaysInMonth()) {
            if ($weekDay == $weekdays[$wday]) {
                $dates[] = self::rollover($year, $month, $day);
            }
            if ($wday == 6) $wday = 0;
            else $wday++;
            $day++;
        }
        return $dates;
    
    }
    
    /**
     * Returns date/time objects for specified weekdays ('MO','TU','WE') in
     * specified weekday of the year
     * @todo Allow user to specify WKST (week start day)
     * @todo This method is EXTREMELY inefficient. Fix it.
     */
    static public function getWeekdaysInWeek($weekDays, $weekNo, $year) {
    
        $weekDays = (array) $weekDays;
        if ($weekNo > 53 || $weekNo < -53 || $weekNo == 0) {
            // @todo use the right exception here
            throw new Exception\DateTime\Exception('Invalid week number specified: ' . $weekNo);
        }
        if ($weekNo < 0) {
            $weekNo = 53 + $weekNo;
        }
        $day = 1;
        $date = self::rollover($year, 1, $day, 0, 0, 0);
        while ($date->getWeekNo() != $weekNo) {
            // @todo find a more efficient way to do this
            $date = self::rollover($year, 1, $day, 0, 0, 0);
            $day++;
        }
        // found week number, so now find week days
        $dates = array();
        foreach ($weekDays as $wday) {
            for ($i = 0; $i < 7; $i++) {
                $date = self::rollover($year, 1, $day + $i, 0, 0, 0);
                if ($date->getDay() == $wday) $dates[] = $date;
            }
        }
        return $dates;
    
    }
    
    /**
     * Format date/time
     * Uses subset of PHP's date() class
     * @param string The format string
     * @return string The date/time formatted according to $format
     * @todo Add $local = false param - tells it to format it in local time
     *       according to $this->tz
     */
    protected function format($format) {
    
        return $this->dt->format($format);
    
    }
    
    /**
     * Get timestamp (timestamp is UTC timestamp)
     */
    public function getTimestamp() {
    
        return $this->dt->getTimestamp();
    
    }
    
    /**
     * Recurrence getters
     */
    public function getYear() {
    
        return $this->format('Y');
    
    }
    
    public function getMonthDay() {
    
        return $this->format('j');
    
    }
    
    public function getDay() {
    
        //return within(array_keys(self::$wDays), $this->format('w'));
        return strtoupper(substr($this->format('l'), 0, 2));
    
    }
    
    public function getMonth() {
    
        return $this->format('n');
    
    }
    
    public function getYearDay() {
    
        return $this->format('z') + 1;
    
    }
    
    /**
     * @todo This only works for weeks starting on Monday. If WKST is set to
     * something else, this probably won't be right
     */
    public function getWeekNo() {
    
        return $this->format('W');
    
    }
    
    public function getHour() {
    
        return (int) $this->format('G');
    
    }
    
    public function getMinute() {
    
        return (int) $this->format('i');
    
    }
    
    public function getSecond() {
    
        return (int) $this->format('s');
    
    }
    
    /**
     * End Recurrence getters
     */
    
    /**
     * Return date/time as UTC
     * @todo Make sure this is always right no matter the timezone
     * @todo remove this method, use toUtcDateTime() instead
     */
    public function toUtc() {
    
        return $this->format('Ymd\THis\Z');
    
    }
    
    /**
     * Return date/time formatted as YYYYMMDDTHHMMSS
     * @todo Once TimeZones are implemented, this needs to take offset into account
     */
    public function toDateTime() {
    
        return $this->format(self::FORMAT_DATETIME);
    
    }
    
    /**
     * Return date formatted as YYYYMMDD
     * @todo Once TimeZones are implemented, this needs to take offset into account
     */
    public function toDate() {
    
        return $this->format(self::FORMAT_DATE);
    
    }
    
    /**
     * Return time formatted as HHMMSS
     * @todo Once TimeZones are implemented, this needs to take offset into account
     */
    public function toTime() {
    
        return $this->format(self::FORMAT_TIME);
    
    }
    
    /**
     * Get Date/Time in UTC Format
     */
    public function toUtcDateTime() {
    
        return $this->format(self::FORMAT_UTC_DATETIME);
    
    }
    
    /**
     * Get Time in UTC Format
     */
    public function toUtcTime() {
    
        return $this->format(self::FORMAT_UTC_TIME);
    
    }
    
    /**
     * Get Date in UTC Format
     * In some cases, UTC date will be different than local date
     */
    public function toUtcDate() {
    
        return $this->format(self::FORMAT_UTC_DATE);
    
    }
    
    /**
     * Get number of days in the year
     * Returns either 365 or 366 depending on leap year
     */
    public function getDaysInYear() {
    
        return $this->format('L') ? 366 : 365;
    
    }
    
    public function getDaysInMonth() {
    
        return $this->format('t');
    
    }
    
    /**
     * Get the day of the week as integer
     * 0 for Sunday through 6 for sat
     */
    public function getDayOfWeek() {
    
        return $this->format('w');
    
    }

}