<?php
/**
 * Time Value
 */
namespace qCal\Value;
use \qCal\DateTime as DT;

class Time extends \qCal\Value {

    public function toString() {
    
        return $this->value->format('His');

    
    }
    
    protected function cast($value) {
    
        // @todo return qCal\DateTime\Time object
        return new DT($value);
    
    }

}
