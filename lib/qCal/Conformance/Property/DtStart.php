<?php
/**
 * Date/Time Start Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance:  This property can be specified once in the "VEVENT",
 *    "VTODO", or "VFREEBUSY" calendar components as well as in the
 *    "STANDARD" and "DAYLIGHT" sub-components.  This property is
 *    REQUIRED in all types of recurring calendar components that
 *    specify the "RRULE" property.  This property is also REQUIRED in
 *    "VEVENT" calendar components contained in iCalendar objects that
 *    don't specify the "METHOD" property.
 * 
 * Description:  Within the "VEVENT" calendar component, this property
 *    defines the start date and time for the event.
 * 
 *    Within the "VFREEBUSY" calendar component, this property defines
 *    the start date and time for the free or busy time information.
 *    The time MUST be specified in UTC time.
 * 
 *    Within the "STANDARD" and "DAYLIGHT" sub-components, this property
 *    defines the effective start date and time for a time zone
 *    specification.  This property is REQUIRED within each "STANDARD"
 *    and "DAYLIGHT" sub-components included in "VTIMEZONE" calendar
 *    components and MUST be specified as a date with local time without
 *    the "TZID" property parameter.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        I have included the description portion of the RFC in the notes
 *              above because it contains information that is important to the
 *              conformance-checking of this property. Make sure all the rules
 *              specified there are checked in this class. Some of these rules
 *              would be better suited for the components rather than the
 *              property conformance classes.
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class DtStart extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VFREEBUSY','STANDARD','DAYLIGHT');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\DtStart $property) {
    
        return parent::conform($property);
    
    }

}