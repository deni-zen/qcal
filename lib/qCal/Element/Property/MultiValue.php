<?php
/**
 * Multiple Value Property
 * Many properties allow multiple properties, separated by a comma. Properties
 * of this type should extend this class.
 *
 * @package     qCal
 * @subpackage  qCal\Element
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Property;
use \qCal\Value,
    \qCal\Element\Parameter;

class MultiValue extends \qCal\Element\Property {

    protected $value = array();
    
    /**
     * Set property value(s), overwriting any existing property value(s)
     * @param mixed The property value(s)
     * @return $this
     */
    public function setValue($values) {
    
        if (is_null($values)) {
            $values = $this->default;
        }
        if (!is_array($values)) {
            $values = array($values);
        }
        foreach ($values as $value) {
            if (!($value instanceof Value)) {
                $value = Value::generate($this->type, $value);
            }
            $this->value[] = $value;
        }
        return $this;
    
    }
    
    /**
     * Add value to existing values
     * @param mixed The property value(s)
     * @return $this
     * @todo Maybe this should accept arrays too?
     */
    public function addValue($value) {
    
        if (!($value instanceof Value)) {
            $value = Value::generate($this->type, $value);
        }
        $this->value[] = $value;
        return $this;
    
    }
    
    /**
     * Get this property's value(s) as a string
     * @todo A lot of these toString() methods assume iCalendar format
     * @todo This isn't right. Converting this to a string should include the name and params
     */
    public function __toString() {
    
        $ret = array();
        foreach ($this->value as $value) {
            $ret[] = $value->__toString();
        }
        return implode(',', $ret);
    
    }

}
