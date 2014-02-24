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
    
    public function __construct($value = null, $params = array()) {
    
        foreach ($params as $pname => $pval) {
            $this->setParam($pname, $pval);
        }
        $this->setValue($value);
    
    }
    
    public function getName() {
    
        return $this->name;
    
    }
    
    public function setParam($name, $value) {
    
        $name = strtoupper($name);
        $this->params[$name] = $value;
        return $this;
    
    }
    
    public function getParam($name) {
    
        $name = strtoupper($name);
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        // @todo Throw exception?
        return null;
    
    }
    
    public function getParams() {
    
        return $this->params;
    
    }
    
    public function setValue($value) {
    
        if (is_null($value)) {
            $value = $this->default;
        }
        $this->value = $value;
        return $this;
    
    }
    
    public function getValue() {
    
        return $this->value;
    
    }
    
    public function getType() {
    
        return $this->type;
    
    }

}