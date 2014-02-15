<?php
/**
 * iCalendar Reader
 * The Lexer reads iCalendar data using readers
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parse;

abstract class Reader {
    
    protected $pos = 0;
    
    abstract public function getChar();
    
    public function getPos() {
    
        return $this->pos;
    
    }
    
    public function backUp() {
    
        return $this->pos--;
    
    }

}
