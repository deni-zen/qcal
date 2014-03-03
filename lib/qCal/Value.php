<?php
/**
 * Property Value
 * 
 * Base property value class. Every property value has a specific data type. 
 * Some of them are very simple; boolean or text, for instance. Others can be
 * very complex. Recur, for instance.
 * 
 * RFC 5545 Definition
 * 
 * The properties in an iCalendar object are strongly typed. The
 * definition of each property restricts the value to be one of the
 * value data types, or simply value types, defined in this section. The
 * value type for a property will either be specified implicitly as the
 * default value type or will be explicitly specified with the "VALUE"
 * parameter. If the value type of a property is one of the alternate
 * valid types, then it MUST be explicitly specified with the "VALUE"
 * parameter.
 * 
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal;

abstract class Value {

    /**
     * Raw value
     * @var mixed The raw value in its native type
     */
    protected $value;
    
    /**
     * Class Constructor
     * @param mixed A property's value
     */
    public function __construct($value) {
    
        $this->setValue($value);
    
    }
    
    /**
     * Generate a value object of a certain type
     */
    static public function generate($type, $value = null) {
    
        $uctype = implode('', array_map('ucfirst', explode("-", ucfirst(strtolower($type)))));
        $typeClass = 'qCal\\Value\\' . $uctype;
        try {
            Loader::loadClass($typeClass);
        } catch (Exception\FileNotFound $e) {
            throw new Exception\Value\UnknownTypeException('Cannot generate value of unknown type, "' . $type . '"');
        }
        return new $typeClass($value);
    
    }
    
    /**
     * Set raw value
     * @param mixed The value to be set
     * @return qCal\Value $this
     */
    public function setValue($value) {
    
        $this->value = $this->cast($value);
        return $this;
    
    }
    
    /**
     * String Conversion
     * Each specific type class should extend this method so that its native
     * value can be converted to a string for output to an iCalendar file.
     * @return string The value of this object, converted to a string
     */
    public function toString() {
    
        return (string) $this->value;
    
    }
    
    /**
     * String conversion magic method
     * @return string The string value of this object
     */
    public function __toString() {
    
        return $this->toString();
    
    }
    
    /**
     * Get raw value
     * @return mixed The raw value stored in this object
     */
    public function getValue() {
    
        return $this->value;
    
    }
    
    /**
     * Cast from string to native type
     * All type classes must extend this method so that a string representation
     * of their value may be converted to their type's native value type.
     * @param string The value to be cast
     * @return mixed The value cast to native type
     */
    abstract protected function cast($value);

}
