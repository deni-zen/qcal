<?php
/**
 * Float Property Value
 * 
 * RFC 5545 Definition
 *
 * Value Name: FLOAT
 * 
 * Purpose: This value type is used to identify properties that contain
 * a real number value.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 *  float	  = (["+"] / "-") 1*DIGIT ["." 1*DIGIT]
 * 
 * Description: If the property permits, multiple "float" values are
 * specified by a COMMA character (US-ASCII decimal 44) separated list
 * of values.
 * 
 * No additional content value encoding (i.e., BACKSLASH character
 * encoding) is defined for this value type.
 * 
 * Example:
 * 
 *  1000000.0000001
 *  1.333
 *  -3.14
 *
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Value;

class Float extends \qCal\Value {

    protected function cast($value) {
    
        return (float) $value;
    
    }

}
