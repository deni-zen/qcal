<?php
/**
 * Duration Value
 */
namespace qCal\Value;
use \qCal\DateTime\Duration as Dur;

class Duration extends \qCal\Value {

    public function toString() {
    
        return $this->value->toICal();
    
    }
    
    protected function cast($value) {
    
        return new Dur($value);
    
    }

}
