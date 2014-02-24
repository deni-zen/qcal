<?php
/**
 * Property Element
 *
 * RFC 5545 Definition
 *
 * A property is the definition of an individual attribute describing a
 * calendar or a calendar component. A property takes the form defined
 * by the "contentline" notation defined in section 4.1.1.
 * 
 * The following is an example of a property:
 * 
 *  DTSTART:19960415T133000Z
 * 
 * This memo imposes no ordering of properties within an iCalendar
 * object.
 * 
 * Property names, parameter names and enumerated parameter values are
 * case insensitive. For example, the property name "DUE" is the same as
 * "due" and "Due", DTSTART;TZID=US-Eastern:19980714T120000 is the same
 * as DtStart;TzID=US-Eastern:19980714T120000.
 * 
 * @package     qCal
 * @subpackage  qCal\Element\Component
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element;
use \qCal\Value;

abstract class Property extends \qCal\Element {

    /**
     * Property Name
     * @var string The RFC5545-designated property name
     */
    protected $name;
    
    /**
     * Property Value
     * @var string The property value
     */
    protected $value;
    
    /**
     * Default property value
     * @var string The RFC5545-designated property default value
     */
    protected $default;
    
    /**
     * Property Type
     * @var string The RFC5545-designated property type
     */
    protected $type;
    
    /**
     * Property Params
     * @var array A list of property parameters
     */
    protected $params = array();
    
    /**
     * Class constructor
     * @param string The property value
     * @param array A list of property parameters
     */
    public function __construct($value = null, $params = array()) {
    
        foreach ($params as $pname => $pval) {
            $this->setParam($pname, $pval);
        }
        $this->setValue($value);
    
    }
    
    /**
     * Get the property name
     * @return string The property name 
     */
    public function getName() {
    
        return $this->name;
    
    }
    
    /**
     * Set a property param
     * @param string Parameter name
     * @param string Parameter value
     * @return $this
     */
    public function setParam($name, $value) {
    
        $name = strtoupper($name);
        $this->params[$name] = $value;
        return $this;
    
    }
    
    /**
     * Get a param by name
     * @param string The parameter name to retrieve
     * @return string The parameter
     */
    public function getParam($name) {
    
        $name = strtoupper($name);
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        // @todo Throw exception?
        return null;
    
    }
    
    /**
     * Get all params
     * @return array All property params
     */
    public function getParams() {
    
        return $this->params;
    
    }
    
    /**
     * Set property value
     * @param string The property value
     * @return $this
     */
    public function setValue($value) {
    
        if (is_null($value)) {
            $value = $this->default;
        }
        $this->value = Value::generate($this->type, $value);
        return $this;
    
    }
    
    /**
     * Get this property's value
     * @return qCal\Value The property value
     */
    public function getValue() {
    
        return $this->value;
    
    }
    
    /**
     * Get this property's type
     * @return string Property type
     */
    public function getType() {
    
        return $this->type;
    
    }

}