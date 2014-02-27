<?php
/**
 * Time Zone Name Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property can be specified in a "VTIMEZONE" calendar
 * component.
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class TZName extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     * @todo I'm not sure if this list is correct
     */
    protected $allowedComponents = array('VTIMEZONE','DAYLIGHT','STANDARD');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\TZName $property) {
    
        return parent::conform($property);
    
    }

}