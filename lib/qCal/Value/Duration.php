<?php
/**
 * Duration Property Value
 *
 * RFC 5545 Definition                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         * RFC 5545 Definition
 * 
 * Value Name: DURATION
 * 
 * Purpose: This value type is used to identify properties that contain
 * a duration of time.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 *  dur-value  = (["+"] / "-") "P" (dur-date / dur-time / dur-week)
 * 
 *  dur-date   = dur-day [dur-time]
 *  dur-time   = "T" (dur-hour / dur-minute / dur-second)
 *  dur-week   = 1*DIGIT "W"
 *  dur-hour   = 1*DIGIT "H" [dur-minute]
 *  dur-minute = 1*DIGIT "M" [dur-second]
 *  dur-second = 1*DIGIT "S"
 *  dur-day	= 1*DIGIT "D"
 * 
 * Description: If the property permits, multiple "duration" values are
 * specified by a COMMA character (US-ASCII decimal 44) separated list
 * of values. The format is expressed as the [ISO 8601] basic format for
 * the duration of time. The format can represent durations in terms of
 * weeks, days, hours, minutes, and seconds.
 * 
 * No additional content value encoding (i.e., BACKSLASH character
 * encoding) are defined for this value type.
 * 
 * Example: A duration of 15 days, 5 hours and 20 seconds would be:
 * 
 *  P15DT5H0M20S
 * 
 * A duration of 7 weeks would be:
 * 
 *  P7W
 * 
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */ 
namespace qCal\Value;
use \qCal\DateTime\Duration as Dur;

class Duration extends \qCal\Value {

    public function toString() {
    
        return $this->value->toICal();
    
    }
    
    protected function cast($value) {
    
        return new Dur($value);
    
    }

}
