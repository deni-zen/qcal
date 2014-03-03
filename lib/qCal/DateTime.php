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
    const FORMAT_DATE = 'Ymd';
    
    const FORMAT_DATETIME = 'Ymd\THis';
    
    const FORMAT_TIME = 'His';
    
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
     */
    protected function format($format) {
    
        return $this->dt->format($format);
    
    }
    
    public function getTimestamp() {
    
        return $this->dt->getTimestamp();
    
    }
    
    /**
     * Return date/time as UTC
     * @todo Make sure this is always right no matter the timezone
     */
    public function toUtc() {
    
        return $this->format('Ymd\THis\Z');
    
    }
    
    /**
     * Return date formatted as YYYYMMDD
     */
    public function toDate() {
    
        return $this->format(self::FORMAT_DATE);
    
    }
    
    public function toTime() {
    
        return $this->format(self::FORMAT_TIME);
    
    }
    
    public function toDateTime() {
    
        return $this->format(self::FORMAT_DATETIME);
    
    }

}