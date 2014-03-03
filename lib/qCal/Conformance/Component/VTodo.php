<?php
/**
 * VTODO Component Conformance
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
 */
namespace qCal\Conformance\Component;
use \qCal\Element,
    \qCal\Exception\Conformance\RequiredChildException,
    \qCal\Exception\Conformance\RequiredPropertyException,
    \qCal\Exception\Conformance\PropertyConformanceException;

class VTodo extends \qCal\Conformance\Component {

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
    public function conform(Element\Component\VTodo $cmpnt) {
    
        // DUE or DURATION can be defined but not both
        if ($cmpnt->hasProperty('DUE') && $cmpnt->hasProperty('DURATION')) {
            throw new PropertyConformanceException('VTODO may define DUE or DURATION property but not both');
        }
        return parent::conform($cmpnt);
    
    }

}