<?php
/**
 * Concrete implementation of Lexer for the iCalendar format (RFC2445)
 * For now I'm just putting everything in here because it will be a while until
 * I even try to implement any other lexer/parser.
 *
 * @uses The interpreter pattern and lexer/parser example found in PHP5 Objects,
 *       Patterns, and Practice, Appendix B
 */
namespace qCal\Parse;
 
class Lexer {

    /**
     * Token type constants
     */
    // Alphabetical sequence of characters
    const ALPHA = 1;
    // Numeric sequence of characters
    const NUM = 2;
    // Single colon character
    const COLON = 3;
    // Single semi-colon character
    const SEMI = 4;
    // Single quote character
    const QUOTE = 5;
    // Single apostrophe character
    const APOS = 6;
    // Single comma character
    const COMMA = 7;
    // Single dash character
    const DASH = 8;
    // Carriage return, line break, or carriage return AND line break
    const NL = 9;
    // Sequence of spaces or horizontal tabs
    const WS = 10;
    // Any other single character   q`-`1`iu
    const CHAR = 11;
    // Start of file 
    const SOF = -1;
    // End of file 
    const EOF = 0;
    
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
     */
    public function __construct(Reader $reader) {
    
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
     * Clone this object
     */
    public function __clone() {
    
        $this->reader = clone($this->reader);
    
    }
    
    /**
     * Get a string representation of either the current token type or that
     * represented by the $int argument.
     *
     * @return string A human-readable representation of the token type
     * @todo Throw an exception if $int is not represented in the $resolve array
     */
    public function getTypeString($int = -1) {
    
        if ($int < 0) $int = $this->getTokenType();
        if ($int < 0) return null;
        $resolve = array(
            self::ALPHA => 'ALPHA',
            self::NUM   => 'NUMERIC',
            self::COLON => 'COLON',
            self::SEMI  => 'SEMICOLON',
            self::QUOTE => 'QUOTE',
            self::APOS  => 'APOSTROPHE',
            self::COMMA => 'COMMA',
            self::DASH  => 'DASH',
            self::NL    => 'NEWLINE',
            self::WS    => 'WHITESPACE',
            self::CHAR  => 'CHARACTER',
        );
        return $resolve[$int];
    
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
    protected function manageEOLChars($char) {
    
        $next = $this->getChar();
        if (!$this->isEOL($next)) {
            $this->backUp();
        }
        return "\r\n";
    
    }
    
    /**
     * Read through all whitespace characters
     * @todo I'm not sure why there are two "eat space char" functions.
     */
    public function eatWhitespace() {
    
        $ret = 0;
        if ($this->getTokenType() != self::WS && $this->getTokenType() != self::NL) {
            return $ret;
        }
        while ($this->nextToken() == self::WS || $this->getTokenType() == self::NL) {
            $ret++;
        }
        return $ret;
    
    }
    
    /**
     * Fast forward past space characters and return "eaten" chars
     *
     * @param string 
     * @return string The "eaten" characters
     */
    public function eatSpaceChars($char) {
    
        $val = $char;
        while ($this->isWhitespace($char = $this->getChar())) {
            $val .= $char;
        }
        $this->backUp();
        return $val;
    
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
        while ($this->isAlpha($char=$this->getChar())) {
            $val .= $char;
        }
        $this->backUp();
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
        while ($this->isNumeric($char=$this->getChar())) {
            $val .= $char;
        }
        $this->backUp();
        return $val;
    
    }
    
    /**
     * Move back one character in the source
     *
     * @return $this Returns an instance of itself (for chaining methods)
     * @todo It might be useful to be able to pass a number in to tell it how
     *       many characters to back up. Don't implement unless it is needed tho
     */
    public function backUp() {
    
        $this->reader->backUp();
        return $this;
    
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
     *
     * @todo The long if/else chain is a code smell. Refactor this when you get
     *       a chance. There has to be a more elegant way to do this.
     */
    public function nextToken() {
    
        while (!is_bool($char = $this->getChar())) {
            if ($this->isEOL($char)) {
                // if newline, swallow CR LF, CR, or LF
                // @todo RFC2445 requires CR LF
                $this->token = $this->manageEOLChars($char);
                $this->lineNo++;
                $this->charNo = 0;
                return $this->tokenType = self::NL;
            } else if ($this->isWhiteSpace($char)) {
                $this->token = $char;
                $type = self::WS;
            } else if ($this->isAlpha($char)) {
                $this->token = $this->eatAlphaChars($char);
                $type = self::ALPHA;
            } else if ($this->isNumeric($char)) {
                $this->token = $this->eatNumericChars($char);
                $type = self::NUM;
            } else if ($this->isColon($char)) {
                $this->token = $char;
                $type = self::COLON;
            } else if ($this->isSemiColon($char)) {
                $this->token = $char;
                $type = self::SEMI;
            } else if ($this->isQuote($char)) {
                $this->token = $char;
                $type = self::QUOTE;
            } else if ($this->isApostrophe($char)) {
                $this->token = $char;
                $type = self::APOS;
            } else if ($this->isComma($char)) {
                $this->token = $char;
                $type = self::COMMA;
            } else if ($this->isDash($char)) {
                $this->token = $char;
                $type = self::DASH;
            } else {
                $this->token = $char;
                $type = self::CHAR;
            }
            $this->charNo += strlen($this->getToken());
            return $this->tokenType = $type;
        }
        return ($this->tokenType = self::EOF);
    
    }
    
    /**
     * Get the next character from source
     * @return string The next character in the source
     */
    public function getChar() {
    
        return $this->reader->getChar();
    
    }
    
    /**
     * Take a peek at the next token
     *
     * @return array Token type and content for the next token
     */
    public function peekToken() {
    
        $state = $this->getState();
        $type = $this->nextToken();
        $token = $this->getToken();
        $this->revert($state);
        return array($type, $token);
    
    }
    
    /**
     * Determines whether lexer has approached the end of the source file (or
     * data if it is direct input)
     * @return boolean True if lexer is at the end of the file (or data)
     */
    public function isEOF() {
    
        return ($this->getTokenType() === self::EOF);
    
    }
    
    /**
     * @todo Find a way to test these methods without making them public. 
     */
    
    /**
     * Test for newline character
     * @var string The single character that is to be tested
     */
    protected function isEOL($char) {
    
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