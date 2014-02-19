<?php
/**
 * Uri Value
 */
namespace qCal\Value;

class Uri extends \qCal\Value {

    public function toString() {
    
        return (string) $this->value;
    
    }
    
    protected function cast($value) {
    
        return $value;
    
    }

}
