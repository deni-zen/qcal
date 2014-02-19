<?php
/**
 * Value Class
 * Every Property has a "type". This class defines the different types avail-
 * able to properties. 
 */
namespace qCal;

abstract class Value {

    protected $value;
    
    public function __construct($value) {
    
        $this->setValue($value);
    
    }
    
    public function setValue($value) {
    
        $this->value = $this->cast($value);
        return $this;
    
    }
    
    public function toString() {
    
        return (string) $this->value;
    
    }
    
    public function __toString() {
    
        return $this->toString();
    
    }
    
    public function getValue() {
    
        return $this->value;
    
    }
    
    abstract protected function cast($value);

}
