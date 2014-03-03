<?php
/**
 * Date-Time Completed Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: The property can be specified in a "VTODO" calendar
 * component. The value MUST be specified as a date with UTC time.
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

class Completed extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VTODO');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     * @todo Can this check that the value is set in UTC time?
     */
    public function conform(Element\Property\Completed $property) {
    
        return parent::conform($property);
    
    }

}