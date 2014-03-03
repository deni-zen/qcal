<?php
/**
 * Date/Time Due Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: The property can be specified once in a "VTODO" calendar
 * component.
 * 
 * Description: The value MUST be a date/time equal to or after the
 * DTSTART value, if specified.
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

class Due extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VTODO');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Due $property) {
    
        if ($property->getParent()->hasProperty('DTSTART')) {
            $dtstart = $property->getParent()->getProperty('DTSTART');
            $starttime = $dtstart->getValue();
            $endtime = $property->getValue();
            if ($starttime->getValue()->getTimestamp() > $endtime->getValue()->getTimestamp()) {
                throw new ConformanceException('Value of DUE property must be equal to or later in time than the value of the DTSTART property.');
            }
        }
        return parent::conform($property);
    
    }

}