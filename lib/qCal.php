<?php
/**
 * Base qCal Class
 * iCalendar Files, although almost always only contain one VCALENDAR component,
 * are allowed to contain multiple VCALENDAR components. In order that users can
 * create multi-calendar iCalendar files, and also so that there is a place to
 * put calendar-wide methods, this wrapper class was created. It does things
 * such as conformance-checking.
 *
 * @package     qCal
 * @subpackage  qCal
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
use qCal\Element;

class qCal {

    protected $calendars;
    
    public function __construct() {
    
        
    
    }
    
    public function addCalendar(Element\Component\VCalendar $calendar) {
    
        $this->calendars[] = $calendar;
    
    }
    
    public function getCalendars() {
    
        return $this->calendars;
    
    }
    
    

}