<?php
/**
 * Repeat Count Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property can be specified in a "VALARM" calendar
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

class Repeat extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VALARM');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Repeat $property) {
    
        return parent::conform($property);
    
    }

}