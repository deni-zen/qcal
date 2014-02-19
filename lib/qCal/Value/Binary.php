<?php
/**
 * Binary Value
 */
namespace qCal\Value;

class Binary extends \qCal\Value {

    public function toString() {
    
        return base64_encode($this->value);
    
    }
    
    protected function cast($value) {
    
        return $value;
    
    }

}
