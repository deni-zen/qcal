<?php
/**
 * Base Recurrence Rule
 *
 * @package     qCal
 * @subpackage  qCal\DateTime\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\DateTime\Recur;

abstract class Rule {

    /**
     * @var string Recurrence rule value
     */
    protected $val;
    
    /**
     * @var qCal\DateTime\Recur
     */
    protected $recur;
    
    /**
     * Class constructor
     * @param string Recurrence rule value
     */
    public function __construct($val = null, \qCal\DateTime\Recur $recur) {
    
        $this->setValue($val);
        $this->setRecur($recur);
    
    }
    
    /**

     */
    public function setRecur(\qCal\DateTime\Recur $recur) {
    
        $this->recur = $recur;
    
    }
    
    /**
     * Get recur 
     */
    public function getRecur() {
    
        return $this->recur;
    
    }
    
    /**
     * Set recurrence rule value
     * @param string Recurrence rule value
     */
    public function setValue($val) {
    
        $this->val = $val;
    
    }
    
    public function getValue() {
    
        return $this->val;
    
    }
    
    /**
     * Get rule value or the default if no value set in an array for looping
     * in recurrence
     */
    public function getForLoop() {
    
        if (is_null($this->val)) {
            return array(/*$this->getDefault()*/);
        }
        if (!is_array($this->val)) {
            return array($this->val);
        }
        return $this->val;
    
    }
    
    abstract protected function getDefault();

}
