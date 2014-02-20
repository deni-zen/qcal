<?php
/**
 * Float Value
 */
namespace qCal\Value;

class Float extends \qCal\Value {

    protected function cast($value) {
    
        return (float) $value;
    
    }

}
