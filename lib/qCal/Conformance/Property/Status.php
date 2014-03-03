<?php
/**
 * Sequence Number Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property can be specified in "VEVENT", "VTODO" or
 * "VJOURNAL" calendar components.
 * 
 * Description: In a group scheduled calendar component, the property is
 * used by the "Organizer" to provide a confirmation of the event to the
 * "Attendees". For example in a "VEVENT" calendar component, the
 * "Organizer" can indicate that a meeting is tentative, confirmed or
 * cancelled. In a "VTODO" calendar component, the "Organizer" can
 * indicate that an action item needs action, is completed, is in
 * process or being worked on, or has been cancelled. In a "VJOURNAL"
 * calendar component, the "Organizer" can indicate that a journal entry
 * is draft, final or has been cancelled or removed.
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

class Status extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VJOURNAL');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Status $property) {
    
        return parent::conform($property);
    
    }

}