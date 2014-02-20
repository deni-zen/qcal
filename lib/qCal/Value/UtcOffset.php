<?php
/**
 * UTC Offset Value
 */
namespace qCal\Value;

class UtcOffset extends \qCal\Value {

    public function toString() {
    
        return (string) $this->value;
    
    }
    
    protected function cast($value) {
    
        // @todo Implement this
        return $value;
    
    }

}
