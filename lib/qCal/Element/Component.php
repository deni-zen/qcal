<?php
/**
 * Component element
 * There are several component types specified in the RFC. Each of these
 * component types will have their own concrete class that extends this abstract
 * class.
 *
 * @todo Implement conformance classes. Each property/component has a list of
 *       conformance specifications that define which properties are allowed for
 *       which components and when. Because these rules can sometimes be
 *       somewhat complex, it makes more sense to implement them within their
 *       own classes rather than try to implement them within this class alone.
 *       Because of this, I have commented out the "allowedProperties",
 *       "requiredProperties", and "allowedParents" properties in this class.
 *       Once I figure out exactly how I want to implement the conformance
 *       aspects of the component/property/parameter elements, I will either
 *       uncomment or remove the above-listed properties.
 */
namespace qCal\Element;

abstract class Component extends \qCal\Element {

    /**
     * Component Name
     * @var string Component name
     */
    protected $name;
    
    /**
     * Contains a list of allowed parent components.
     * @var array Allowed parent components
     */
    // protected $allowedParents = array();
    
    /**
     * Contains this components children components
     * @var array List of children components
     */
    protected $children = array();
    
    /**
     * Component propertiers
     * @var array List of properties set on this component
     */
    protected $properties = array();
    
    /**
     * Parent Component
     * @var qCal\Element\Component A reference to the parent component (if any)
     */
    protected $parent;
    
    /**
     * Required properties
     * @var array A list of required properties
     * @todo Required properties can actually change depending on whether other
     *       properties are specified and what they are specified as. Because of
     *       this, I think that this method of stating required properties isn't
     *       the best way to go. Look at the OOP book and see if you can figure
     *       out a better way to specify this type of rule.
     */
    // protected $requiredProperties = array();
    
    /**
     * Certain properties are allowed on certain components. This contains a
     * list of properties allowed on this component.
     * @var array List of allowed properties
     */
    // protected $allowedProperties = array();
    
    /**
     * Class constructor
     * @param array A list of this component's properties
     * @param array A list of this component's sub-components
     */
    public function __construct($properties = array(), $components = array()) {
    
        foreach ($components as $c) {
            $this->attach($c);
        }
        foreach($properties as $p) {
            $this->addProperty($p);
        }
    
    }
    
    /**
     * Get the component's name
     * @return string The name of the component
     */
    public function getName() {
    
        return $this->name;
    
    }
    
    /**
     * Set this component's parent
     * @param qCal\Element\Component The parent component
     */
    public function setParent(Component $component) {
    
        $this->parent = $component;
        return $this;
    
    }
    
    /**
     * Get this component's parent
     * @return qCal\Element\Component The parent component
     */
    public function getParent(Component $component) {
    
        return $this->parent;
    
    }
    
    /**
     * Attach a sub-component to this component as its child.
     * @param qCal\Element\Component A sub-component to be attached
     * @return qCal\Element\Component $this for chaining method calls
     */
    public function attach(Component $component) {
    
        $component->setParent($this);
        $this->children[$component->getName()][] = $component;
        return $this;
    
    }
    
    /**
     * Add a new property to this component
     * @param qCal\Element\Property The property to be added
     */
    public function addProperty(Property $property) {
    
        $this->properties[$property->getName()][] = $property;
        return $this;
    
    }

}