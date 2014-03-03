<?php
/**
 * Base Property Conformance Visitor
 * Property conformance visitors must extend this class in order to conformance-
 * check their respective properties.
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

abstract class Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     *            Often conformance rules are more complex than simply which
     *            components are allowed to define a particular property, but
     *            this allows you to define, at the simplest level, which
     *            components are even possibly allowed to define the property.
     *            If the rules for allowed components are more complex, then its
     *            respective class will handle that in its conform method. This
     *            property is a white list. By default, no components allow any
     *            given property. 
     */
    protected $allowedComponents = array();
    
    /**
     * @var boolean Allow the property to be defined multiple times
     */
    protected $allowMultiple = false;
    
    /**
     * Conformance check
     * Performs conformance-checking on the property 
     */
    public function conform(Element\Property $property) {
    
        $name = $property->getParent()->getName();
        if (!in_array($name, $this->allowedComponents)) {
            throw new ConformanceException($property->getName() . ' property cannot be defined for ' . $name . ' component.');
        }
        $props = $property->getParent()->getProperties($property->getName());
        if (!$this->allowMultiple && count($props) > 1) {
            throw new ConformanceException($property->getName() . ' property may only be defined once for ' . $name . ' component.');
        }
    
    }

}