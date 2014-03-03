<?php
/**
 * iCalendar Element Class
 * iCalendar files consist of many content lines. Content lines consist of
 * element types; components, properties, parameters, value data types, and
 * values. Each of those elements are represented by a class extending this
 * abstract class.
 */
namespace qCal;
use \qCal\Element,
    \qCal\Conformance\Visitor;

abstract class Element {

    /**
     * qCal wrapper object
     * @var qCal The wrapper object 
     */
    protected $qCal;
    
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
    
    /**
     * Get qCal wrapper object
     * @return qCal The qCal wrapper object
     * @todo Test this
     * @todo Make Element set this value
     */
    public function getQCal() {
    
        return $this->qCal;
    
    }
    
    /**
     * Accept  conformance visitor
     * @param  qCal\Conformance\Visitor The visitor which applies conformance
     *         rules to each element in the tree
     * @return $this
     * @todo   This feels a little sloppy. I don't particularly like the
     *         conditionals. It's fine for now, but maybe refactor later.
     */
    public function accept(Visitor $visitor) {
    
        $visitor->visit($this);
        if ($this instanceof Element\Component) {
            foreach ($this->getAllChildren() as $child) {
                $child->accept($visitor);
            }
            foreach ($this->getAllProperties() as $prop) {
                $prop->accept($visitor);
            }
        }
        if ($this instanceof Element\Property) {
            foreach ($this->getParams() as $param) {
                $param->accept($visitor);
            }
        }
    
    }

}
