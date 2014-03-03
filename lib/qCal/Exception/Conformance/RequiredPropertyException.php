<?php
/**
 * Missing Required Property Exception
 * Thrown when the conformance visitor encounters a missing required property or
 * properties. 
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        I think all this functionality in this exception isn't worth the
 *              trouble. Probably should just get rid of it.
 */
namespace qCal\Exception\Conformance;
use \qCal\Element\Component;

class RequiredPropertyException extends Exception {

    /**
     * @var array A list of missing required properties
     */
    protected $missing = array();
    
    /**
     * @var qCal\Element\Component The component being conformance-checked
     */
    protected $cmpnt;
    
    /**
     * Exception constructor
     * Modified constructor for setting the conformance component
     */
    public function __construct(Component $cmpnt, array $missing = null, $code = 0, Exception $previous = null) {
    
        $this->setComponent($cmpnt);
        $this->setMissingProperties($missing);
        parent::__construct($this->message, $code, $previous);
    
    }
    
    /**
     * Set Conformance Component
     * @param qCal\Element\Component Conformance component
     * @return $this
     */
    public function setComponent(Component $cmpnt) {
    
        $this->cmpnt = $cmpnt;
        $this->setMessage();
        return $this;
    
    }
    
    /**
     * Set missing required properties
     * @param mixed Either a missing property name or an array of them
     * @return $this
     */
    public function setMissingProperties($missing) {
    
        if (is_null($missing)) return $this;
        if (!is_array($missing)) $missing = array($missing);
        $this->missing = $missing;
        $this->setMessage();
        return $this;
    
    }
    
    /**
     * Add a property to list of missing required properties
     * @param string A name of a missing property
     * @return $this
     */
    public function add($missing) {
    
        $this->missing[] = $missing;
        $this->setMessage();
        return $this;
    
    }
    
    /**
     * Determines if any missing properties have been set
     * @return boolean True if there are any properties set on this exception
     */
    public function hasMissing() {
    
        return !empty($this->missing);
    
    }
    
    /**
     * Get list of missing properties
     * @return array A list of missing required properties
     */
    public function getMissingProperties() {
    
        return $this->missing;
    
    }
    
    /**
     * Set message exception
     * Setting a message on this exception type doesn't have any effect
     */
    protected function setMessage($message = null) {
    
        if (!empty($message))
            $this->message = $message;
        else
            $this->message = $this->cmpnt->getName() . ' missing required properties: ' . implode(', ', $this->missing);
    
    }

}