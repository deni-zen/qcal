<?php
/**
 * Trigger Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property MUST be specified in the "VALARM" calendar
 * component.
 * 
 * Description: Within the "VALARM" calendar component, this property
 * defines when the alarm will trigger. The default value type is
 * DURATION, specifying a relative time for the trigger of the alarm.
 * The default duration is relative to the start of an event or to-do
 * that the alarm is associated with. The duration can be explicitly set
 * to trigger from either the end or the start of the associated event
 * or to-do with the "RELATED" parameter. A value of START will set the
 * alarm to trigger off the start of the associated event or to-do. A
 * value of END will set the alarm to trigger off the end of the
 * associated event or to-do.
 * 
 * Either a positive or negative duration may be specified for the
 * "TRIGGER" property. An alarm with a positive duration is triggered
 * after the associated start or end of the event or to-do. An alarm
 * with a negative duration is triggered before the associated start or
 * end of the event or to-do.
 * 
 * The "RELATED" property parameter is not valid if the value type of
 * the property is set to DATE-TIME (i.e., for an absolute date and time
 * alarm trigger). If a value type of DATE-TIME is specified, then the
 * property value MUST be specified in the UTC time format. If an
 * absolute trigger is specified on an alarm for a recurring event or
 * to-do, then the alarm will only trigger for the specified absolute
 * date/time, along with any specified repeating instances.
 * 
 * If the trigger is set relative to START, then the "DTSTART" property
 * MUST be present in the associated "VEVENT" or "VTODO" calendar
 * component. If an alarm is specified for an event with the trigger set
 * relative to the END, then the "DTEND" property or the "DSTART" and
 * "DURATION' properties MUST be present in the associated "VEVENT"
 * calendar component. If the alarm is specified for a to-do with a
 * trigger set relative to the END, then either the "DUE" property or
 * the "DSTART" and "DURATION' properties MUST be present in the
 * associated "VTODO" calendar component.
 * 
 * Alarms specified in an event or to-do which is defined in terms of a
 * DATE value type will be triggered relative to 00:00:00 UTC on the
 * specified date. For example, if "DTSTART:19980205, then the duration
 * trigger will be relative to19980205T000000Z.
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        I have included the description of the property in the notes
 *              above because there are conformance rules in the definition.
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class Trigger extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VALARM');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Trigger $property) {
    
        return parent::conform($property);
    
    }

}