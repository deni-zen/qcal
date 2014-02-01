<?php
/**
 * iCalendar Reader
 * The lexer uses this class to read iCalendar data. This class encapsulates
 * various operations needed to step through a chunk of iCalendar data,
 * character by character.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        This class "reads" a chunk of iCalendar-formatted data, passed
 *              to it in the constructor as a string. Eventually I may want the
 *              lexer to be capable of reading from other sources. If/when that
 *              happens, this needs to become an abstract class and the lexer
 *              will use subclasses with concrete implementations of reading
 *              from other sources.
 */
namespace qCal\Parser;

class Reader {

    protected $data;
    
    protected $pos = 0;
    
    public function __construct($data) {
    
        $this->data = (string) $data;
    
    }
    
    public function getChar() {
    
        $char = substr($this->data, $this->pos, 1);
        $this->pos++;
        return $char;
    
    }
    
    public function getPos() {
    
        return $this->pos;
    
    }

}
