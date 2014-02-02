<?php
/**
 * Unit Test Cases for qCal\Parser\Lexer
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Parser;
use \qCal\Parser;

class LexerState extends \qCal\UnitTest\TestCase {

    protected $reader;
    
    public function setUp() {
    
        parent::setUp();
        $this->reader = new Parser\Reader("BEGIN:VCALENDAR\r\nPRODID:-//ABC Corp//Something//EN\r\nVERSION:2.0\r\nEND:VCALENDAR\r\n");
    
    }
    
    public function testGetState() {
    
        $lexer = new Parser\Lexer($this->reader);
        $lexer->nextToken();
        $this->assertEqual($lexer->getToken(), 'BEGIN');
        $state = $lexer->getState();
        $this->assertIsA($state, 'qCal\Parser\LexerState');
        $this->assertIdentical($state->getReader(), $lexer->getReader());
        $this->assertEqual($state->getLineNo(), $lexer->getLineNo());
        $this->assertEqual($state->getCharNo(), $lexer->getCharNo());
        $this->assertEqual($state->getToken(), $lexer->getToken());
        $this->assertEqual($state->getTokenType(), $lexer->getTokenType());
    
    }
    
    public function testRevertState() {
    
        // first test state is as expected
        $lexer = new Parser\Lexer($this->reader);
        $lexer->nextToken();
        $this->assertEqual($lexer->getToken(), 'BEGIN');
        
        // now advance lexer forward and check to see if is as expected
        $lexer->nextToken();
        $lexer->nextToken();
        $this->assertEqual($lexer->getToken(), 'VCALENDAR');
        
        // get state
        $state = $lexer->getState();
        
        // move forward to the newline and check it
        $lexer->nextToken();
        $this->assertEqual($lexer->getToken(), "\r\n");
        
        // revert to VCALENDAR state and test it
        $lexer->revert($state);
        $this->assertIdentical($state->getReader(), $lexer->getReader());
        $this->assertEqual($state->getLineNo(), $lexer->getLineNo());
        $this->assertEqual($state->getCharNo(), $lexer->getCharNo());
        $this->assertEqual($state->getToken(), $lexer->getToken());
        $this->assertEqual($state->getTokenType(), $lexer->getTokenType());

    
    }

}