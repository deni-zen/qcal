<?php
/**
 * Exception Date/Times Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: The property can be specified in "VEVENT", "VTODO",
 * "VJOURNAL" or "VTIMEZONE" calendar components.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Make sure there aren't any rules I missed in the RFC
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class RDate extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VJOURNAL','VTIMEZONE', 'STANDARD', 'DAYLIGHT');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\RDate $property) {
    
        return parent::conform($property);
    
    }

}