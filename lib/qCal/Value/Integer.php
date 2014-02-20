<?php
/**
 * Integer Value
 */
namespace qCal\Value;

class Integer extends \qCal\Value {

    protected function cast($value) {
    
        return (integer) $value;
    
    }

}
