<?php
/**
 * Text Value
 */
namespace qCal\Value;

class Boolean extends \qCal\Value {

    public function toString() {
    
        return ($this->value) ? 'TRUE' : 'FALSE';
    
    }
    
    protected function cast($value) {
    
        return (boolean) $value;
    
    }

}
