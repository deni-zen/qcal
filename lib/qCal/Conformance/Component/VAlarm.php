<?php
/**
 * VALARM Component Conformance
 *
 * RFC 5545 Definition
 *

 * 

 * The "TRIGGER" property specifies when the alarm will be triggered.
 * The "TRIGGER" property specifies a duration prior to the start of an
 * event or a to-do. The "TRIGGER" edge may be explicitly set to be
 * relative to the "START" or "END" of the event or to-do with the
 * "RELATED" parameter of the "TRIGGER" property. The "TRIGGER" property
 * value type can alternatively be set to an absolute calendar date and
 * time of day value.
 * 
 * In an alarm set to trigger on the "START" of an event or to-do, the
 * "DTSTART" property MUST be present in the associated event or to-do.
 * In an alarm in a "VEVENT" calendar component set to trigger on the
 * "END" of the event, either the "DTEND" property MUST be present, or
 * the "DTSTART" and "DURATION" properties MUST both be present. In an
 * alarm in a "VTODO" calendar component set to trigger on the "END" of
 * the to-do, either the "DUE" property MUST be present, or the
 * "DTSTART" and "DURATION" properties MUST both be present.
 * 
 * The alarm can be defined such that it triggers repeatedly. A
 * definition of an alarm with a repeating trigger MUST include both the
 * "DURATION" and "REPEAT" properties. The "DURATION" property specifies
 * the delay period, after which the alarm will repeat. The "REPEAT"
 * property specifies the number of additional repetitions that the
 * alarm will triggered. This repitition count is in addition to the
 * initial triggering of the alarm. Both of these properties MUST be
 * present in order to specify a repeating alarm. If one of these two
 * properties is absent, then the alarm will not repeat beyond the
 * initial trigger.
 * 
 * The "ACTION" property is used within the "VALARM" calendar component
 * to specify the type of action invoked when the alarm is triggered.
 * The "VALARM" properties provide enough information for a specific
 * action to be invoked. It is typically the responsibility of a
 * "Calendar User Agent" (CUA) to deliver the alarm in the specified
 * fashion. An "ACTION" property value of AUDIO specifies an alarm that
 * causes a sound to be played to alert the user; DISPLAY specifies an
 * alarm that causes a text message to be displayed to the user; EMAIL
 * specifies an alarm that causes an electronic email message to be
 * delivered to one or more email addresses; and PROCEDURE specifies an
 * alarm that causes a procedure to be executed. The "ACTION" property
 * MUST specify one and only one of these values.
 * 
 * In an AUDIO alarm, if the optional "ATTACH" property is included, it
 * MUST specify an audio sound resource. The intention is that the sound
 * will be played as the alarm effect. If an "ATTACH" property is
 * specified that does not refer to a sound resource, or if the
 * specified sound resource cannot be rendered (because its format is
 * unsupported, or because it cannot be retrieved), then the CUA or
 * other entity responsible for playing the sound may choose a fallback
 * action, such as playing a built-in default sound, or playing no sound
 * at all.
 * 
 * In a DISPLAY alarm, the intended alarm effect is for the text value
 * of the "DESCRIPTION" property to be displayed to the user.
 * 
 * In an EMAIL alarm, the intended alarm effect is for an email message
 * to be composed and delivered to all the addresses specified by the
 * "ATTENDEE" properties in the "VALARM" calendar component. The
 * "DESCRIPTION" property of the "VALARM" calendar component MUST be
 * used as the body text of the message, and the "SUMMARY" property MUST
 * be used as the subject text. Any "ATTACH" properties in the "VALARM"
 * calendar component SHOULD be sent as attachments to the message.
 * 
 * In a PROCEDURE alarm, the "ATTACH" property in the "VALARM" calendar
 * component MUST specify a procedure or program that is intended to be
 * invoked as the alarm effect. If the procedure or program is in a
 * format that cannot be rendered, then no procedure alarm will be
 * invoked. If the "DESCRIPTION" property is present, its value
 * specifies the argument string to be passed to the procedure or
 * program. "Calendar User Agents" that receive an iCalendar object with
 * this category of alarm, can disable or allow the "Calendar User" to
 * disable, or otherwise ignore this type of alarm. While a very useful
 * alarm capability, the PROCEDURE type of alarm SHOULD be treated by
 * the "Calendar User Agent" as a potential security risk.
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance\Component;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException,
    \qCal\Exception\Conformance\UnexpectedValueException,
    \qCal\Exception\Conformance\RequiredPropertyException,
    \qCal\Exception\Conformance\AllowedParentException;

class VAlarm extends \qCal\Conformance\Component {

    /**
     * @var array Required properties
     * The "VALARM" calendar component MUST include the "ACTION" and
     * "TRIGGER" properties.
     */
    protected $reqProperties = array('ACTION','TRIGGER');
    
    /**
     * @var array A list of allowed parent components
     */
    protected $allowedParents = array('VEVENT', 'VTODO');
    
    /**
     * Check that this component is conformant
     * @param qCal\Element\Component
     * @todo I just wanted to get this working so I hastily threw this together.
     *       Once I have some time to spend on it, refactor and make this neater
     *       Extract as much functionality as possible up into the parent class
     */
    public function conform(Element\Component\VAlarm $cmpnt) {
    
        $required = new RequiredPropertyException($cmpnt);
        if ($cmpnt->hasProperty('ACTION')) {
            $action = $cmpnt->getProperty('ACTION');
            switch((string) $action) {
                case 'AUDIO':
                    break;
                case 'DISPLAY':
                    if (!$cmpnt->hasProperty('DESCRIPTION')) $required->add('DESCRIPTION');
                    break;
                case 'EMAIL':
                    if (!$cmpnt->hasProperty('DESCRIPTION')) $required->add('DESCRIPTION');
                    if (!$cmpnt->hasProperty('SUMMARY')) $required->add('SUMMARY');
                    if (!$cmpnt->hasProperty('ATTENDEE')) $required->add('ATTENDEE');
                    break;
                /* @todo PROCEDURE action has been deprecated. I do want this
                 * library to be capable of supporting it though. So maybe it
                 * should be possible to toggle support for it with a config
                 * setting or something
                case 'PROCEDURE':
                    if (!$cmpnt->hasProperty('ATTACH')) $required->add('ATTACH');
                    break;
                 */
                default:
                    // @todo Throw a more specific exception here
                    throw new UnexpectedValueException('Unsupported value for ACTION property: ' . $action);
                    break;
            }
        } else {
            $required->add('ACTION');
        }
        if (!$cmpnt->hasProperty('TRIGGER')) {
            $required->add('TRIGGER');
        }
        if ($required->hasMissing()) {
            throw $required;
        }
        if ($parent = $cmpnt->getParent()) {
            if (!in_array($parent->getName(), $this->allowedParents)) {
                throw new AllowedParentException($cmpnt->getName() . ' component cannot be nested within ' . $parent->getName() . ' component');
            }
        }
    
    }

}