<?php
/**
 * Attendee Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: This property MUST be specified in an iCalendar object
 * that specifies a group scheduled calendar entity. This property MUST
 * NOT be specified in an iCalendar object when publishing the calendar
 * information (e.g., NOT in an iCalendar object that specifies the
 * publication of a calendar user's busy time, event, to-do or journal).
 * This property is not specified in an iCalendar object that specifies
 * only a time zone definition or that defines calendar entities that
 * are not group scheduled entities, but are entities only on a single
 * user's calendar.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        The conformance definition for this property is very poorly
 *              defined. It is never made clear which components are allowed to
 *              specify the attendee property, nor is it all that clear about
 *              what other conditions must be met in order for the property to
 *              be allowed to be defined. There is actually more useful info
 *              about conformance in the "description" and other areas of the
 *              property definition than in the conformance section. Because of
 *              this poor definition, I have had to just kind of guess at which
 *              components allow this property. I'll have to try to find out
 *              whether it is correct some other time.
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class Attendee extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VEVENT','VTODO','VJOURNAL','VALARM','VFREEBUSY');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\Attendee $property) {
    
        return parent::conform($property);
    
    }

}