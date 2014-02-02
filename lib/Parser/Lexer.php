<?php
/**
 * Parser Lexer
 * The lexer uses a reader object to step through a source of iCalendar data,
 * character by character, breaking it down into atomic pieces (tokens) which
 * are then fed to the parser.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parser;

class Lexer {

    /**
     * Token type constants
     */
    // Alphabetical sequence of characters
    const ALPHA = 1;
    // Numeric sequence of characters
    const NUMERIC = 2;
    // Single colon character
    const COLON = 3;
    // Single semi-colon character
    const SEMICOLON = 4;
    // Single quote character
    const QUOTE = 5;
    // Single apostrophe character
    const APOSTROPHE = 6;
    // Single comma character
    const COMMA = 7;
    // Single dash character
    const DASH = 8;
    // Carriage return, line break, or carriage return AND line break
    const NEWLINE = 9;
    // Sequence of spaces or horizontal tabs
    const WHITESPACE = 10;
    // Any other single character   q`-`1`iu
    const CHAR = 11;
    
    /**
     * @var qCal\Parser\Reader iCalendar data reader
     */
    protected $reader;
    
    /**
     * @var integer Current line number 
     */
    protected $lineNo = 1;
    
    /**
     * @var integer Current character number
     */
    protected $charNo = 0;
    
    /**
     * @var string Current token value
     */
    protected $token;
    
    /**
     * @var integer Current token type (see constants above)
     */
    protected $tokenType = -1;
    
    /**
     * Class constructor
     * Accepts a qCal\Parser\Reader object, which it uses to step through
     * iCalendar data character by character.
     *
     * @todo As of now, the qCal\Parser\Reader object works only with strings.
     *       Once the lexer is fully written and tested, the reader will become
     *       an abstract class and I will need to write concrete implementations
     *       to read from more useful sources such as files. The majority of the
     *       reader class, as it is now, will become qCal\Parser\Reader\String.
     * @todo The lexer only breaks down iCalendar data into tokens. It doesn't
     *       actually DO anything with them. In fact, they are discarded just as
     *       soon as the next token is called into existence. In order to store
     *       tokens for the parser, I'll need to implement a qCal\Parser\Context
     *       class and pass an instance of it as the second argument here.
     */
    public function __construct(Reader $reader/*, Context $context*/) {
    
        $this->reader = $reader;
    
    }
    
    /**
     * Get reader object
     * 
     * @return qCal\Parser\Reader The iCalendar data source object
     */
    public function getReader() {
    
        return $this->reader;
    
    }
    
    /**
     * Generate a snapshot of this lexer instance's current state.
     *
     * @return qCal\Parser\LexerState A snapshot of the lexer's state
     */
    public function getState() {
    
        return new LexerState(
            clone($this->getReader()),
            $this->getLineNo(),
            $this->getCharNo(),
            $this->getToken(),
            $this->getTokenType()
        );
    
    }
    
    /**
     * Revert to a previous state
     *
     * @param qCal\Parser\LexerState Contains state lexer should be reverted to
     * @return qCal\Parser\Lexer Returns $this
     */
    public function revert(LexerState $state) {
    
        $this->reader = $state->getReader();
        $this->lineNo = $state->getLineNo();
        $this->charNo = $state->getCharNo();
        $this->token = $state->getToken();
        $this->tokenType = $state->getTokenType();
        return $this;
    
    }
    
    /**
     * Get line number currently being read from
     *
     * @return int Line number currently being read from=
     */
    public function getLineNo() {
    
        return $this->lineNo;
    
    }
    
    /**
     * Get character number currently being read from
     *
     * @return int Character number currently being read from=
     */
    public function getCharNo() {
    
        return $this->charNo;
    
    }
    
    /**
     * Get the type (see above constants) of the token that is currently loaded
     * into the lexer
     *
     * @return int The token type that's currently loaded into the lexer
     */
    public function getTokenType() {
    
        return $this->tokenType;
    
    }
    
    /**
     * Get the token that's currently loaded into the lexer
     *
     * @return string The token that's currently loaded into the lexer
     */
    public function getToken() {
    
        return $this->token;
    
    }
    
    /**
     * Handle newline
     * The iCalendar format expects/requires that lines be terminated by the
     * internet standard newline (carriage return, line feed). Because of this,
     * the lexer, when it encounters a carriage return, looks for a line feed to
     * be immediately following that. Whether there is a carriage return, a line
     * feed, or both, the lexer treats it as a single newline character.
     * 
     * @todo Make sure that this method properly handles CRLF, CR, and LF. As of
     *       now I'm not entirely certain that it does.
     * @param string Newline character
     * @return string Proper internet standard newline
     */
    protected function handleNewLine($char) {
    
        $next = $this->reader->getChar();
        if (!$this->isNewLine($next)) {
            $this->reader->backUp();
        }
        return "\r\n";
    
    }
    
    /**
     * Read alphabetical character sequence
     * Sequential alphabetical characters in the source data should be combined
     * to make one token. So, when the lexer encounters an alpha character, it
     * uses this method to "eat" the characters that follow until it encounters
     * a non-alpha character, at which point it backs up one char and returns
     * the sequence of alpha chars it "ate".
     *
     * @param string Alphabetical character that begins the alpha token
     * @return string Alphabetical token
     */
    public function eatAlphaChars($char) {
    
        $val = $char;
        while ($this->isAlpha($char=$this->reader->getChar())) {
            $val .= $char;
        }
        $this->reader->backUp();
        return $val;
    
    }
    
    /**
     * Read numeric character sequence
     * Sequential numeric characters in the source data should be combined
     * to make one token. So, when the lexer encounters a numeric character, it
     * uses this method to "eat" the characters that follow until it encounters
     * a non-numeric character, at which point it backs up one char and returns
     * the sequence of numeric chars it "ate".
     *
     * @param string Numeric character that begins the numeric token
     * @return string Numeric token
     */
    public function eatNumericChars($char) {
    
        $val = $char;
        while ($this->isNumeric($char=$this->reader->getChar())) {
            $val .= $char;
        }
        $this->reader->backUp();
        return $val;
    
    }
    
    /**
     * Load next token
     * Using the qCal\Parser\Reader object passed in at instantiation, this
     * method steps through the source data, character by character, finding one
     * token at a time. Every call to this method flushes any token currently in
     * its memory and acquires the next token in the source. This method is
     * basically the workhorse of this entire class.
     *
     * @note I had started writing a prevToken() method, but I decided against
     * it. The lexer isn't meant to read source data backwards at any time, for
     * any reason. I have, however, implemented a LexerState class, which can be
     * used to save the current state of the lexer so that it may be reverted
     * back to that state later on. See qCal\Parser\LexerState
     */
    public function nextToken() {
    
        while (!is_bool($char = $this->reader->getChar())) {
            if ($this->isNewLine($char)) {
                // if newline, swallow CR LF, CR, or LF
                // @todo RFC2445 requires CR LF
                $this->token = $this->handleNewline($char);
                $this->lineNo++;
                $this->charNo = 0;
                return $this->tokenType = self::NEWLINE;
            } else if ($this->isWhiteSpace($char)) {
                $this->token = $char;
                $this->tokenType = self::WHITESPACE;
            } else if ($this->isAlpha($char)) {
                $this->token = $this->eatAlphaChars($char);
                $this->tokenType = self::ALPHA;
            } else if ($this->isNumeric($char)) {
                $this->token = $this->eatNumericChars($char);
                $this->tokenType = self::NUMERIC;
            } else if ($this->isColon($char)) {
                $this->token = $char;
                $this->tokenType = self::COLON;
            } else if ($this->isSemiColon($char)) {
                $this->token = $char;
                $this->tokenType = self::SEMICOLON;
            } else if ($this->isQuote($char)) {
                $this->token = $char;
                $this->tokenType = self::QUOTE;
            } else if ($this->isApostrophe($char)) {
                $this->token = $char;
                $this->tokenType = self::APOSTROPHE;
            } else if ($this->isComma($char)) {
                $this->token = $char;
                $this->tokenType = self::COMMA;
            } else if ($this->isDash($char)) {
                $this->token = $char;
                $this->tokenType = self::DASH;
            } else {
                $this->token = $char;
                $this->tokenType = self::CHAR;
            }
            $this->charNo += strlen($this->getToken());
            return $this->tokenType;
        }
        return false;
    
    }
    
    /**
     * @todo The following classes have no business being public. They were made
     * public for the purpose of testing only. And that is no reason to make
     * them public. Refactor these methods and find a better way to test them.
     */
    
    /**
     * Test for newline character
     * @var string The single character that is to be tested
     */
    protected function isNewLine($char) {
    
        return ($char == "\n" || $char == "\r");
    
    }
    
    /**
     * Test for alpha character
     * @var string The single character that is to be tested
     */
    protected function isAlpha($char) {
    
        return preg_match("/^[a-z]$/i", $char);
    
    }
    
    /**
     * Test for numeric character
     * @var string The single character that is to be tested
     */
    protected function isNumeric($char) {
    
        return preg_match("/^[0-9]$/", $char);
    
    }
    
    /**
     * Test for colon
     * @var string The single character that is to be tested
     */
    protected function isColon($char) {
    
        return ($char == ':');
    
    }
    
    /**
     * Test for semi-colon
     * @var string The single character that is to be tested
     */
    protected function isSemiColon($char) {
    
        return ($char == ';');
    
    }
    
    /**
     * Test for quote
     * @var string The single character that is to be tested
     */
    protected function isQuote($char) {
    
        return ($char == '"');
    
    }
    
    /**
     * Test for apostrophe
     * @var string The single character that is to be tested
     */
    protected function isApostrophe($char) {
    
        return ($char == "'");
    
    }
    
    /**
     * Test for comma
     * @var string The single character that is to be tested
     */
    protected function isComma($char) {
    
        return ($char == ",");
    
    }
    
    /**
     * Test for dash
     * @var string The single character that is to be tested
     */
    protected function isDash($char) {
    
        return ($char == "-");
    
    }
    
    /**
     * Test for space or horizontal tab
     * @var string The single character that is to be tested
     */
    protected function isWhitespace($char) {
    
        return preg_match('/^[ \t]+$/', $char);
    
    }

}