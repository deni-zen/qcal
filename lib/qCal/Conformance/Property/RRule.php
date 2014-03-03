<?php
/**
 * Recurrence Rule Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property can be specified one or more times in
 * recurring "VEVENT", "VTODO" and "VJOURNAL" calendar components. It
 * can also be specified once in each STANDARD or DAYLIGHT sub-component
 * of the "VTIMEZONE" calendar component.
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

class RRule extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VJOURNAL','DAYLIGHT','STANDARD');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\RRule $property) {
    
        if (in_array($property->getParent()->getName(), array('VEVENT','VTODO','VJOURNAL'))) {
            $this->allowMultiple = true;
        }
        return parent::conform($property);
    
    }

}