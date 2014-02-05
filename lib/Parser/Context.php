<?php
/**
 * Parser Context
 * A simple stack object for parsers to work with.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parser;

class Context {

    protected $stack = array();
    
    public function __construct() {
    
        
    
    }
    
    public function pushResult($data) {
    
        array_push($this->stack, $data);
        return $this;
    
    }
    
    public function popResult() {
    
        return array_pop($this->stack);
    
    }

}