<?php
/**
 * Date Value
 */
namespace qCal\Value;

class DateTime extends \qCal\Value {

    public function toString() {
    
        return $this->value->format('Ymd\THis');

    
    }
    
    protected function cast($value) {
    
        // @todo return qCal_Date object
        return new \qCal\DateTime($value);
    
    }

}
