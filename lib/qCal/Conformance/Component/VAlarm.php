<?php
/**
 * VALARM Component Conformance
 *
 * RFC 5545 Definition
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
    \qCal\Exception\Conformance\AllowedParentException,
    \qCal\Exception\Conformance\PropertyConformanceException;

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
    
        if ($parent = $cmpnt->getParent()) {
            if (!in_array($parent->getName(), $this->allowedParents)) {
                throw new AllowedParentException($cmpnt->getName() . ' component cannot be nested within ' . $parent->getName() . ' component');
            }
        }
        /**
         * @todo The exception here should probably point out that the ACTION property changes which properties are required
         */
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
        /**
         * Trigger relational alarm - Alarms can be triggered in relation to the
         * start/end of its parent component. When trigger is set to relate to
         * start/end, the parent component must have start/end properties set
         */
        if (!$cmpnt->hasProperty('TRIGGER')) {
            $required->add('TRIGGER');
        } else {
            $trigger = $cmpnt->getProperty('TRIGGER');
            if ($trigger->hasParam('RELATED')) {
                $parent = $cmpnt->getParent();
                switch ($trigger->getParam('RELATED')->getValue()) {
                    case 'START':
                        if (!$parent->hasProperty('DTSTART')) throw new PropertyConformanceException('VALARM parent component must have DTSTART property if VALARM is set to trigger in relation to parent\'s start');
                        break;
                    case 'END':
                        if (!$parent->hasProperty('DTEND') && (!$parent->hasProperty('DTSTART') || !$parent->hasProperty('DURATION'))) {
                            throw new PropertyConformanceException('VALARM parent component must have DTEND or DTSTART/DURATION property if VALARM is set to trigger in relation to parent\'s end');
                        }
                        break;
                    default:
                        // @todo Should this throw an exception? I think it's more of a parameter conformance issue
                }
            }
        }
        /**
         * Repeating alarms require repeat and duration to be set
         */
        if ($cmpnt->hasProperty('REPEAT')) {
            $repeat = $cmpnt->getProperty('REPEAT')->getValue();
            // @todo If I'm reading the RFC correctly, only repeating alarms with a repeat value of more than one need a duration but I'm not sure
            if ($repeat->getValue() > 1) {
                if (!$parent->hasProperty('DURATION')) throw new PropertyConformanceException('Repeating VALARM requires both REPEAT and DURATION properties');
            }
        }
        
        if ($required->hasMissing()) {
            throw $required;
        }
    
    }

}