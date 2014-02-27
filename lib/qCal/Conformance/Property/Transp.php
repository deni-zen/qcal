<?php
/**
 * Time Transparency Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property can be specified once in a "VEVENT"
 * calendar component.
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Why does this property's conformance definition explicitly state
 *              that it can be specified once? Most other properties can only be
 *              specified once, but they don't state it in their definition.
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class Transp extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Transp $property) {
    
        return parent::conform($property);
    
    }

}