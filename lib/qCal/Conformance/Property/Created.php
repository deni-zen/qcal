<?php
/**
 * Contact Info Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: The property can be specified once in "VEVENT", "VTODO"
 * or "VJOURNAL" calendar components. The value MUST be specified as a date with
 * UTC time.
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

class Created extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VJOURNAL');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     * @todo  Test that the value is in UTC time
     */
    public function conform(Element\Property\Created $property) {
    
        return parent::conform($property);
    
    }

}