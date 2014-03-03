<?php
/**
 * Conformance Visitor
 * RFC 5545 conformance is checked via a visitor that is injected into each of
 * the qCal\Element classes that need to be conformance-checked. This is the
 * visitor class which is injected into the elements.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance;
use \qCal\Element,
    \qCal\Loader,
    \qCal\Exception\FileNotFound;

class Visitor {

    /**
     * Visit element and perform conformance
     * This method delegates to a conformance visitor class, if one is available
     * @param qCal\Element The element to be conformance-checked
     * @return $this
     */
    public function visit(Element $elem) {
    
        list($qcal, $element, $type, $name) = explode('\\', get_class($elem));
        try {
            $conf = $this->loadConformanceVisitor($type, $name);
        } catch (FileNotFound $e) {
            // If file isn't found, it simply means a conformance visitor
            // doesn't exist for this element type. This isn't necessarily an
            // error, it just means there is no conformance rule for this
            // element type.
            return $this;
        }
        $conf->conform($elem);
    
    }
    
    /**
     * Load conformance visitor class
     * @param string The type of element visitor to be loaded
     * @name string The name of the element visitor to be loaded
     */
    protected function loadConformanceVisitor($type, $name) {
    
        $class = 'qCal\\Conformance\\' . $type . '\\' . $name;
        Loader::loadClass($class);
        return new $class();
    
    }

}