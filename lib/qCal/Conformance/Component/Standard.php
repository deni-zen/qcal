<?php
/**
 * Standard Time Zone Component Conformance
 *
 * RFC 5545 Definition
 * 

 * 
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance\Component;
use \qCal\Element;

class Standard extends \qCal\Conformance\Component {

    /**
     * @var array Required properties
     */
    protected $reqProperties = array('DTSTART', 'TZOFFSETTO', 'TZOFFSETFROM');
    
    /**
     * @var array A list of allowed parent components
     */
    protected $allowedParents = array('VTIMEZONE');
    
    /**
     * Check that this component is conformant
     * @param qCal\Element\Component
     * @todo I just wanted to get this working so I hastily threw this together.
     *       Once I have some time to spend on it, refactor and make this neater
     *       Extract as much functionality as possible up into the parent class
     */
    public function conform(Element\Component\Standard $cmpnt) {
    
        return parent::conform($cmpnt);
    
    }

}