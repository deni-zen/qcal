<?php
/**
 * Lexigraphical Analyzer
 * This class breaks down iCalendar data into tokens which are then fed to the
 * parser for further processing.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parser;

class Lexer {

    /**
     * Token types
     */
    const ALPHA = 1;
    const NUMERIC = 2;
    const COLON = 3;
    const SEMICOLON = 4;
    const QUOTE = 5;
    const APOSTROPHE = 6;
    const COMMA = 7;
    const DASH = 8;
    const NEWLINE = 9;
    const WHITESPACE = 10;
    const CHAR = 11;
    
    protected $data;
    
    protected $lineNo = 1;
    
    protected $charNo = 0;
    
    protected $token;
    
    protected $tokenType = -1;
    
    /**
     * @todo
     * Eventually $string will be replaced by a qCal\Parser\Reader object which
     * will allow different types of readers, but for now it is just a string
     * containing iCalendar-formatted data.
     *
     * The second parameter will be a qCal\Parser\Context object. The context
     * object is where parsers store the results of parsing the data.
     */
    public function __construct($data/*, Context $context*/) {
    
        $this->data = $data;
    
    }
    
    /**
     * Determine if current character is a newline character
     * @todo This shouldn't be public. find a new way to test it
     */
    public function isNewLine($char) {
    
        return ($char == "\n" || $char == "\r");
    
    }
    
    /**
     * Determine if current character is an alpha character
    public function isAlpha($char) {
    
        return preg_match("/[A-Za-z]/", $char);
    
    }
     */
    
    /**
     * Fetch the next character
    public function getChar() {
    
        if ($this->pos >= strlen($this->data)) {
            return false;
        }
        $char = substr($this->data, $this->charNo, 1);
        $this->charNo++;
        return $char;
    
    }
     */
    
    /**
     * Move on to the next token in the data
    public function nextToken() {
    
        $this->token = null;
        while (!is_bool($char = $this->getChar())) {
            if ($this->isNewLine()) {
                $this->token = $char;
                // Uncomment these once Reader object is in use
                // $this->lineNo++;
                // $this->charNo = 0;
                return ($this->tokenType = self::NEWLINE);
            } else if ($this->isAlpha()) {
                
            }
        }
    
    }
     */


}