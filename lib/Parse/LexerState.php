<?php
/**
 * iCalendar Lexer State
 * This class is used for saving the current state of a lexer object in order to
 * revert back to that state if necessary.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parse;

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