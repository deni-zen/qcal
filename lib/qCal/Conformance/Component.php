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
    \qCal\Exception\Conformance\AllowedParentException,
    \qCal\Exception\Conformance\RequiredPropertyException;

abstract class Component {

    /**
     * @var array A list of required properties
     */
    protected $reqProperties = array();
    
    /**
     * @var array A list of allowed parent components
     */
    protected $allowedParents = array();
    
    /**
     * Conformance check
     * Performs conformance-checking on the component 
     */
    public function conform(Element\Component $cmpnt) {
    
        $required = new RequiredPropertyException($cmpnt);
        foreach ($this->reqProperties as $req) {
            if (!$cmpnt->hasProperty($req)) {
                $required->add($req);
            }
        }
        if ($parent = $cmpnt->getParent()) {
            if (!in_array($parent->getName(), $this->allowedParents)) {
                throw new AllowedParentException($cmpnt->getName() . ' component cannot be nested within ' . $parent->getName() . ' component');
            }
        }
        if ($required->hasMissing()) {
            throw $required;
        }
    
    }

}