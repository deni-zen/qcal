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

}