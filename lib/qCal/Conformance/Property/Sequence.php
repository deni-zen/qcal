<?php
/**
 * Sequence Number Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: The property can be specified in "VEVENT", "VTODO" or
 * "VJOURNAL" calendar component.
 *
 * Description: When a calendar component is created, its sequence
 * number is zero (US-ASCII decimal 48). It is monotonically incremented
 * by the "Organizer's" CUA each time the "Organizer" makes a
 * significant revision to the calendar component. When the "Organizer"
 * makes changes to one of the following properties, the sequence number
 * MUST be incremented:
 * 
 *   .  "DTSTART"
 * 
 *   .  "DTEND"
 * 
 *   .  "DUE"
 * 
 *   .  "RDATE"
 * 
 *   .  "RRULE"
 * 
 *   .  "EXDATE"
 * 
 *   .  "EXRULE"
 * 
 *   .  "STATUS"
 * 
 * In addition, changes made by the "Organizer" to other properties can
 * also force the sequence number to be incremented. The "Organizer" CUA
 * MUST increment the sequence number when ever it makes changes to
 * properties in the calendar component that the "Organizer" deems will
 * jeopardize the validity of the participation status of the
 * "Attendees". For example, changing the location of a meeting from one
 * locale to another distant locale could effectively impact the
 * participation status of the "Attendees".
 * 
 * The "Organizer" includes this property in an iCalendar object that it
 * sends to an "Attendee" to specify the current version of the calendar
 * component.
 * 
 * The "Attendee" includes this property in an iCalendar object that it
 * sends to the "Organizer" to specify the version of the calendar
 * component that the "Attendee" is referring to.
 * 
 * A change to the sequence number is not the mechanism that an
 * "Organizer" uses to request a response from the "Attendees". The
 * "RSVP" parameter on the "ATTENDEE" property is used by the
 * "Organizer" to indicate that a response from the "Attendees" is
 * requested.
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        I have included the description in the notes above because I
 *              want to make sure to include all the conformance rules for this
 *              property and the description seems pertinent. 
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class Sequence extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VJOURNAL');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Sequence $property) {
    
        return parent::conform($property);
    
    }

}