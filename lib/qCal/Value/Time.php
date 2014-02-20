<?php
/**
 * Time Value
 */
namespace qCal\Value;
use \qCal\DateTime;

class Date extends \qCal\Value {

    public function toString() {
    
        return $this->value->format('His');

    
    }
    
    protected function cast($value) {
    
        // @todo return qCal\DateTime\Time object
        return new DateTime($value);
    
    }

}
