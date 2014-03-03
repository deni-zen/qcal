<?php
/**
 * VFREEBUSY Component Conformance
 *
 * RFC 5545 Definition
 * 
 * Purpose: Provide a grouping of component properties that defines a
 * time zone.
 * 
 * Formal Definition: A "VTIMEZONE" calendar component is defined by the
 * following notation:
 * 
 *   timezonec  = "BEGIN" ":" "VTIMEZONE" CRLF
 * 
 *				2*(
 * 
 *				; 'tzid' is required, but MUST NOT occur more
 *				; than once
 * 
 *			  tzid /
 * 
 *				; 'last-mod' and 'tzurl' are optional,
 *			  but MUST NOT occur more than once
 * 
 *			  last-mod / tzurl /
 * 
 *				; one of 'standardc' or 'daylightc' MUST occur
 *			  ..; and each MAY occur more than once.
 * 
 *			  standardc / daylightc /
 * 
 *			  ; the following is optional,
 *			  ; and MAY occur more than once
 * 
 *				x-prop
 * 
 *				)
 * 
 *				"END" ":" "VTIMEZONE" CRLF
 * 
 *   standardc  = "BEGIN" ":" "STANDARD" CRLF
 * 
 *				tzprop
 * 
 *				"END" ":" "STANDARD" CRLF
 * 
 *   daylightc  = "BEGIN" ":" "DAYLIGHT" CRLF
 * 
 *				tzprop
 * 
 *				"END" ":" "DAYLIGHT" CRLF
 * 
 *   tzprop	 = 3*(
 * 
 *			  ; the following are each REQUIRED,
 *			  ; but MUST NOT occur more than once
 * 
 *			  dtstart / tzoffsetto / tzoffsetfrom /
 * 
 *			  ; the following are optional,
 *			  ; and MAY occur more than once
 * 
 *			  comment / rdate / rrule / tzname / x-prop
 * 
 *			  )
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance\Component;
use \qCal\Element,
    \qCal\Exception\Conformance\RequiredChildException;

class VTimeZone extends \qCal\Conformance\Component {

    /**
     * @var array Required properties
     */
    protected $reqProperties = array('TZID');
    
    /**
     * @var array A list of allowed parent components
     */
    protected $allowedParents = array('VCALENDAR');
    
    /**
     * Check that this component is conformant
     *
     * The top-level properties in a "VTIMEZONE" calendar component are:
     * 
     * @param qCal\Element\Component
     * @todo I just wanted to get this working so I hastily threw this together.
     *       Once I have some time to spend on it, refactor and make this neater
     *       Extract as much functionality as possible up into the parent class
     */
    public function conform(Element\Component\VTimeZone $cmpnt) {
    
        // TimeZone must have at least one DayLight or Standard sub-component
        $children = $cmpnt->getChildren(array('DAYLIGHT','STANDARD'));
        if (empty($children)) {
            throw new RequiredChildException('VTIMEZONE must have at least one STANDARD or DAYLIGHT sub-component');
        }
        return parent::conform($cmpnt);
    
    }

}