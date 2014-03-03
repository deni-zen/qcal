<?php
/**
 * Date/Time End Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property can be specified in "VEVENT" or
 * "VFREEBUSY" calendar components.
 *
 * Description:  Within the "VEVENT" calendar component, this property
 *    defines the date and time by which the event ends.  The value type
 *    of this property MUST be the same as the "DTSTART" property, and
 *    its value MUST be later in time than the value of the "DTSTART"
 *    property.  Furthermore, this property MUST be specified as a date
 *    with local time if and only if the "DTSTART" property is also
 *    specified as a date with local time.
 *
 *    Within the "VFREEBUSY" calendar component, this property defines
 *    the end date and time for the free or busy time information.  The
 *    time MUST be specified in the UTC time format.  The value MUST be
 *    later in time than the value of the "DTSTART" property.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        I have included the description portion of the RFC in the notes
 *              above because it contains information that is important to the
 *              conformance-checking of this property. Make sure all the rules
 *              specified there are checked in this class.
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class DtEnd extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VFREEBUSY');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\DtEnd $property) {
    
        if ($property->getParent()->hasProperty('DTSTART')) {
            $dtstart = $property->getParent()->getProperty('DTSTART');
            $starttime = $dtstart->getValue();
            $endtime = $property->getValue();
            if ($starttime->getValue()->getTimestamp() > $endtime->getValue()->getTimestamp()) {
                throw new ConformanceException('Value of DTEND property must be later in time than the value of the DTSTART property.');
            }
        }
        return parent::conform($property);
    
    }

}