<?php
/**
 * iCalendar Element Class
 * iCalendar files consist of many content lines. Content lines consist of
 * element types; components, properties, parameters, value data types, and
 * values. Each of those elements are represented by a class extending this
 * abstract class.
 */
namespace qCal;

abstract class Element {

    /**
     * Parent Component
     * @var qCal\Element\Component A reference to the parent component (if any)
     */
    protected $parent;
    
    /**
     * Set this component's parent
     * @param qCal\Element\Component The parent component
     */
    public function setParent(Element\Component $component) {
    
        $this->parent = $component;
        return $this;
    
    }
    
    /**
     * Get this component's parent
     * @return qCal\Element\Component The parent component
     */
    public function getParent() {
    
        return $this->parent;
    
    }
    
    /**
     * Get root component (core iCalendar object)
     * @return qCal\Element\Component\VCalendar The root VCalendar component
     * #todo   I don't know if I really like the name of this method
     */
    public function getCore() {
    
        if (!$parent = $this->getParent()) {
            return $this;
        }
        while (true) {
            $core = $parent;
            if (!$parent = $parent->getParent()) {
                return $core;
            }
        }
    
    }

}
