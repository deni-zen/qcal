<?php
/**
 * Property Element
 */
namespace qCal\Element;

abstract class Property extends \qCal\Element {

    protected $name;
    
    protected $value;
    
    protected $default;
    
    protected $type;
    
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