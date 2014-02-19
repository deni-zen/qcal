<?php
/**
 * Date Value
 */
namespace qCal\Value;
use \qCal\DateTime;

class Date extends \qCal\Value {

    public function toString() {
    
        return $this->value->format('Ymd');

    
    }
    
    protected function cast($value) {
    
        // @todo return qCal_Date object
        return new DateTime($value);
    
    }

}
