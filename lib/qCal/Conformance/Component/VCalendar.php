<?php
/**
 * VCALENDAR Component Conformance
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
    \qCal\Exception\Conformance\PropertyConformanceException,
    \qCal\Exception\Conformance\AllowedParentException;

class VCalendar extends \qCal\Conformance\Component {

    /**
     * @var array Required properties
     */
    protected $reqProperties = array('PRODID','VERSION');
    
    /**
     * Check that this component is conformant
     * 
     * @param qCal\Element\Component
     * @todo I just wanted to get this working so I hastily threw this together.
     *       Once I have some time to spend on it, refactor and make this neater
     *       Extract as much functionality as possible up into the parent class
     */
    public function conform(Element\Component\VCalendar $cmpnt) {
    
        $required = new RequiredPropertyException($cmpnt);
        foreach ($this->reqProperties as $req) {
            if (!$cmpnt->hasProperty($req)) {
                $required->add($req);
            }
        }
        if ($cmpnt->getParent()) {
            throw new AllowedParentException($cmpnt->getName() . ' component cannot be nested within another component');
        }
        if ($required->hasMissing()) {
            throw $required;
        }
    
    }

}