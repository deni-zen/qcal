<?php
/**
 * Component element
 * There are several component types specified in the RFC. Each of these
 * component types will have their own concrete class that extends this abstract
 * class.
 * 
 * RFC 2445 Definition
 * 
 * The body of the iCalendar object consists of a sequence of calendar
 * properties and one or more calendar components. The calendar
 * properties are attributes that apply to the calendar as a whole. The
 * calendar components are collections of properties that express a
 * particular calendar semantic. For example, the calendar component can
 * specify an event, a to-do, a journal entry, time zone information, or
 * free/busy time information, or an alarm.
 * 
 * The body of the iCalendar object is defined by the following
 * notation:
 * 
 *  icalbody   = calprops component
 * 
 *  calprops   = 2*(
 * 
 *			 ; 'prodid' and 'version' are both REQUIRED,
 *			 ; but MUST NOT occur more than once
 * 
 *			 prodid /version /
 * 
 *			 ; 'calscale' and 'method' are optional,
 *			 ; but MUST NOT occur more than once
 * 
 *			 calscale		/
 *			 method		  /
 * 
 *			 x-prop
 * 
 *			 )
 * 
 *  component  = 1*(eventc / todoc / journalc / freebusyc /
 *			 / timezonec / iana-comp / x-comp)
 * 
 *  iana-comp  = "BEGIN" ":" iana-token CRLF
 * 
 *			   1*contentline
 * 
 *			   "END" ":" iana-token CRLF
 * 
 *  x-comp	 = "BEGIN" ":" x-name CRLF
 * 
 *			   1*contentline
 * 
 *			   "END" ":" x-name CRLF
 * 
 * An iCalendar object MUST include the "PRODID" and "VERSION" calendar
 * properties. In addition, it MUST include at least one calendar
 * component. Special forms of iCalendar objects are possible to publish
 * just busy time (i.e., only a "VFREEBUSY" calendar component) or time
 * zone (i.e., only a "VTIMEZONE" calendar component) information. In
 * addition, a complex iCalendar object is possible that is used to
 * capture a complete snapshot of the contents of a calendar (e.g.,
 * composite of many different calendar components). More commonly, an
 * iCalendar object will consist of just a single "VEVENT", "VTODO" or
 * "VJOURNAL" calendar component.
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
 * 
 * @package     qCal
 * @subpackage  qCal\Element\Component
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
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
     * Get the component's child components
     * @param string The type of child components to return 
     * @return array A list of this components child components
     * @todo Maybe allow $type to be an array of types to return 
     */
    public function getChildren($type = null) {
    
        if (!is_null($type)) {
            $type = strtoupper($type);
            if (array_key_exists($type, $this->children)) {
                return $this->children[$type];
            }
            return array();
        }
        return $this->children;
    
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
    public function getParent() {
    
        return $this->parent;
    
    }
    
    /**
     * Get root component (core iCalendar object)
     * @return qCal\Element\Component\VCalendar The root VCalendar component
     * #todo   I don't know if I really like the name of this method
     */
    public function getCore() {
    
        if (!$parent = $this->getParent()) {
            return $this;
        }
        while (true) {
            $core = $parent;
            if (!$parent = $parent->getParent()) {
                return $core;
            }
        }
    
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
     * Add a property
     * If property already exists, this method will add another without
     * overwriting the existing property
     * @param qCal\Element\Property The property to be added
     */
    public function addProperty(Property $property) {
    
        $this->properties[$property->getName()][] = $property;
        return $this;
    
    }
    
    /**
     * Set a property
     * If property already exists, this method will overwrite the existing
     * property with the new value.
     */
    public function setProperty(Property $property) {
    
        $this->properties[$property->getName()][] = $property;
    
    }

}