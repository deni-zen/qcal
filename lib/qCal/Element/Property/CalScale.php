<?php
/**
 * CalScale Property
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Although I have already set "GREGORIAN" to be the default value
 *              if the CalScale property is initialized without a value, I
 *              believe that in this case, the default value actually refers to
 *              what the system as a whole should default to if the property is
 *              not present at all. PHP defaults to a Gregorian calendar anyway,
 *              but make sure that qCal knows to use Gregorian if no CalScale is
 *              specified, just in case somebody has another calendar scale set
 *              as their default in their PHP settings or something.
 */
namespace qCal\Element\Property;

class CalScale extends \qCal\Element\Property {

    protected $name = "CALSCALE";
    
    protected $type = "TEXT";

    protected $default = "GREGORIAN";

}