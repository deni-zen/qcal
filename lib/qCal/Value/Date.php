<?php
/**
 * Date Property Value
 *
 * RFC 5545 Definition
 * 
 * Value Name: DATE
 * 
 * Purpose: This value type is used to identify values that contain a
 * calendar date.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 *  date	    = date-value
 *  date-value	    = date-fullyear date-month date-mday
 *  date-fullyear   = 4DIGIT
 *  date-month	    = 2DIGIT		;01-12
 *  date-mday	    = 2DIGIT		;01-28, 01-29, 01-30, 01-31
 *				        ;based on month/year
 * 
 * Description: If the property permits, multiple "date" values are
 * specified as a COMMA character (US-ASCII decimal 44) separated list
 * of values. The format for the value type is expressed as the [ISO
 * 8601] complete representation, basic format for a calendar date. The
 * textual format specifies a four-digit year, two-digit month, and
 * two-digit day of the month. There are no separator characters between
 * the year, month and day component text.
 * 
 * No additional content value encoding (i.e., BACKSLASH character
 * encoding) is defined for this value type.
 * 
 * Example: The following represents July 14, 1997:
 * 
 *  19970714
 * 
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Value;
use \qCal\DateTime;

class Date extends \qCal\Value {

    public function toString() {
    
        return $this->value->format('Ymd');

    
    }
    
    protected function cast($value) {
    
        // @todo return qCal\DateTime\Date object
        return new DateTime($value);
    
    }

}
