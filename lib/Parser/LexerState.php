<?php
/**
 * iCalendar Lexer State
 * This class is used for saving the current state of a lexer object in order to
 * revert back to that state if necessary.
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

class LexerState {

    protected $lineNo;
    protected $charNo;
    protected $token;
    protected $tokenType;
    protected $reader;
    
    public function __construct(Reader $reader, $lineNo, $charNo, $token, $tokenType) {
    
        $this->reader = $reader;
        $this->lineNo = $lineNo;
        $this->charNo = $charNo;
        $this->token = $token;
        $this->tokenType = $tokenType;
    
    }
    
    public function getReader() {
    
        return $this->reader;
    
    }
    
    public function getLineNo() {
    
        return $this->lineNo;
    
    }
    
    public function getCharNo() {
    
        return $this->charNo;
    
    }
    
    public function getToken() {
    
        return $this->token;
    
    }
    
    public function getTokenType() {
    
        return $this->tokenType;
    
    }

}