<?php
/**
 * Base Component Conformance Visitor
 * Component conformance visitors must extend this class in order to 
 * conformance-check their respective components.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

abstract class Component {

    /**
     * @var array A list of required properties
     */
    protected $reqProperties = array();
    
    /**
     * Conformance check
     * Performs conformance-checking on the component 
     */
    public function conform(Element\Component $cmpnt) {
    
        $missing = array();
        foreach ($this->reqProperties as $req) {
            if (!$cmpnt->hasProperty($req)) {
                $missing[] = $req;
            }
        }
        if (!empty($missing)) {
            $this->raiseRequiredPropertiesException($cmpnt, $missing);
        }
    
    }
    
    /**
     * Call after conformance-checking if required properties are missing.
     * @param array A list of undefined required properties
     * @throws qCal\Exception\Conformance\Exception
     * @todo Create and implement a more specific exception for this purpose
     */
    protected function raiseRequiredPropertiesException(Element\Component $cmpnt, $reqs) {
    
        throw new ConformanceException($cmpnt->getName() . ' missing required properties: ' . implode(', ', $reqs));
    
    }

}