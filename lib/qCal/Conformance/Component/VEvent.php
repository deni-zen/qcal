<?php
/**
 * VEVENT Component Conformance
 *
 * RFC 5545 Definition
 * 
 * 
 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Write a generateUID() method somewhere
 */
namespace qCal\Conformance\Component;
use \qCal\Element,
    \qCal\Exception\Conformance\RequiredChildException,
    \qCal\Exception\Conformance\RequiredPropertyException,
    \qCal\Exception\Conformance\PropertyConformanceException;

class VEvent extends \qCal\Conformance\Component {

    /**
     * @var array Required properties
     */
    protected $reqProperties = array('DTSTAMP','UID');
    
    /**
     * @var array A list of allowed parent components
     */
    protected $allowedParents = array('VCALENDAR');
    
    /**
     * Check that this component is conformant
     * 
     * @param qCal\Element\Component
     * @todo I just wanted to get this working so I hastily threw this together.
     *       Once I have some time to spend on it, refactor and make this neater
     *       Extract as much functionality as possible up into the parent class
     */
    public function conform(Element\Component\VEvent $cmpnt) {
    
        // DTSTART required if core object doesn't define a method
        if (!$cmpnt->getCore()->hasProperty('METHOD')) {
            if (!$cmpnt->hasProperty('DTSTART')) {
                throw new PropertyConformanceException('DTSTART property is required for ' . $cmpnt->getName() . ' component that appears in VCALENDAR that does not specify a METHOD property');
            }
        }
        
        // DTEND or DURATION can be defined but not both
        if ($cmpnt->hasProperty('DTEND') && $cmpnt->hasProperty('DURATION')) {
            throw new PropertyConformanceException($cmpnt->getName() . ' may define DTEND or DURATION property but not both');
        }
        
        return parent::conform($cmpnt);
    
    }

}