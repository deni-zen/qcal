<?php
/**
 * Boolean Property Value
 * 
 * RFC 5545 Definition
 *
 * Value Name: BOOLEAN
 * 
 * Purpose: This value type is used to identify properties that contain
 * either a "TRUE" or "FALSE" Boolean value.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 * 
 *   boolean	= "TRUE" / "FALSE"
 * 
 * Description: These values are case insensitive text. No additional
 * content value encoding (i.e., BACKSLASH character encoding) is
 * defined for this value type.
 * 
 * Example: The following is an example of a hypothetical property that
 * has a BOOLEAN value type:
 * 
 * GIBBERISH:TRUE
 *
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Value;

class Boolean extends \qCal\Value {

    public function toString() {
    
        return ($this->value) ? 'TRUE' : 'FALSE';
    
    }
    
    protected function cast($value) {
    
        if (strtolower($value) == 'true') return true;
        elseif (strtolower($value) == 'false') return false;
        else return (boolean) $value;
    
    }

}