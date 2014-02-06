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
    
    public function push($data) {
    
        array_push($this->stack, $data);
        return $this;
    
    }
    
    public function pop() {
    
        return array_pop($this->stack);
    
    }
    
    public function count() {
    
        return count($this->stack);
    
    }
    
    public function peek() {
    
        if (empty($this->stack)) {
            throw new \Exception('Empty context stack');
        }
        return $this->stack[$this->count() - 1];
    
    }

}