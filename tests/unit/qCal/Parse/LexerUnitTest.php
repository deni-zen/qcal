<?php
/**
 * Unit Test Cases for qCal\Parser\Lexer
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Parse;
use \qCal\Parse as Parser;

class LexerUnitTest extends \qCal\UnitTest\TestCase {

    protected $lexer;
    
    /**
     * Set up a reader and parser object with some very basic iCalendar data for
     * testing against
     */
    public function setUp() {
    
        parent::setUp();
        $data = <<<ICALDATA
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:uid1@example.com
DTSTAMP:19970714T170000Z
ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com
DTSTART:19970714T170000Z
DTEND:19970715T035959Z
SUMMARY:Bastille Day Party
END:VEVENT
END:VCALENDAR
ICALDATA;
        $reader = new Parser\Reader\StringReader($data);
        $this->lexer = new Parser\Lexer($reader);
    
    }
    
    public function testGetReader() {
    
        $reader = new Parser\Reader\StringReader("foo");
        $lexer = new Parser\Lexer($reader);
        $this->assertIdentical($reader, $lexer->getReader());
    
    }
    
    public function testGetLineNumber() {
    
        $this->assertEqual($this->lexer->getLineNo(), 1);
    
    }
    
    public function testGetCharNumber() {
    
        $this->assertEqual($this->lexer->getCharNo(), 0);
    
    }
    
    /**
     * Im not sure I like this test
     */
    public function testNextToken() {
    
        $this->assertNull($this->lexer->getToken());
        
        $this->assertTrue($this->lexer->nextToken());
        $this->assertEqual($this->lexer->getToken(), "BEGIN");
        $this->assertEqual($this->lexer->getLineNo(), 1);
        $this->assertEqual($this->lexer->getCharNo(), 5);
        $this->assertEqual($this->lexer->getTokenType(), Parser\Lexer::ALPHA);
        
        $this->assertTrue($this->lexer->nextToken());
        $this->assertEqual($this->lexer->getToken(), ":");
        $this->assertEqual($this->lexer->getLineNo(), 1);
        $this->assertEqual($this->lexer->getCharNo(), 6);
        $this->assertEqual($this->lexer->getTokenType(), Parser\Lexer::COLON);
        
        $this->assertTrue($this->lexer->nextToken());
        $this->assertEqual($this->lexer->getToken(), "VCALENDAR");
        $this->assertEqual($this->lexer->getLineNo(), 1);
        $this->assertEqual($this->lexer->getCharNo(), 15);
        $this->assertEqual($this->lexer->getTokenType(), Parser\Lexer::ALPHA);
        
        $this->assertTrue($this->lexer->nextToken());
        $this->assertEqual($this->lexer->getToken(), "\r\n");
        $this->assertEqual($this->lexer->getLineNo(), 2);
        $this->assertEqual($this->lexer->getCharNo(), 0);
        $this->assertEqual($this->lexer->getTokenType(), Parser\Lexer::NL);
    
    }
    
    /**
     * Let's try testing this bad boy again... @todo come back to this
    public function testNextTokenRevisited() {
    
        // very simple icalendar data with all token types (at least it will have all of them eventually)
        $data  = "BEGIN:VCALENDAR\t\r\n";
        $data .= "VERSION:-2.0\r\n";
        $data .= "PRODID:-//Apple Inc.//iCal 4.0.4//EN\r\n";
        $data .= "CALSCALE:GREGORIAN\t\r\n";
        $data .= "END:VCALENDAR\r\n";
        $reader = new Parser\Reader($data);
        $lexer = new Parser\Lexer($reader);
        
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::ALPHA);
        $this->assertEqual($lexer->getToken(), 'BEGIN');
        
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::COLON);
        $this->assertEqual($lexer->getToken(), ':');
        
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::ALPHA);
        $this->assertEqual($lexer->getToken(), 'VCALENDAR');
        
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::WS);
        $this->assertEqual($lexer->getToken(), "\t");
    
    }
     */
    
    public function testTokenTypes() {
    
        $reader = new Parser\Reader\StringReader("abc5645\r\n\t :'\"\n/\\;-");
        $lexer = new Parser\Lexer($reader);
        
        // test alpha
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::ALPHA);
        $this->assertEqual($lexer->getToken(), 'abc');
        $this->assertEqual($lexer->getLineNo(), 1);
        $this->assertEqual($lexer->getCharNo(), 3);
        
        // test numeric
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::NUM);
        $this->assertEqual($lexer->getToken(), '5645');
        $this->assertEqual($lexer->getLineNo(), 1);
        $this->assertEqual($lexer->getCharNo(), 7);
        
        // test mewline
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::NL);
        $this->assertEqual($lexer->getToken(), "\r\n");
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 0);
        
        // test whitespace
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::WS);
        $this->assertEqual($lexer->getToken(), "\t");
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 1);
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::WS);
        $this->assertEqual($lexer->getToken(), " ");
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 2);
        
        // test colon
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::COLON);
        $this->assertEqual($lexer->getToken(), ":");
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 3);
        
        // test apostrophe
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::APOS);
        $this->assertEqual($lexer->getToken(), "'");
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 4);
        
        // test quote
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::QUOTE);
        $this->assertEqual($lexer->getToken(), '"');
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 5);
        
        // newline again
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::NL);
        $this->assertEqual($lexer->getToken(), "\r\n");
        $this->assertEqual($lexer->getLineNo(), 3);
        $this->assertEqual($lexer->getCharNo(), 0);
        
        // test char(s)
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::CHAR);
        $this->assertEqual($lexer->getToken(), '/');
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::CHAR);
        $this->assertEqual($lexer->getToken(), "\\");
        $this->assertEqual($lexer->getLineNo(), 3);
        $this->assertEqual($lexer->getCharNo(), 2);
        
        // test semi-colon
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::SEMI);
        $this->assertEqual($lexer->getToken(), ';');
        $this->assertEqual($lexer->getLineNo(), 3);
        $this->assertEqual($lexer->getCharNo(), 3);
        
        // test dash
        $this->assertEqual($lexer->nextToken(), Parser\Lexer::DASH);
        $this->assertEqual($lexer->getToken(), '-');
        $this->assertEqual($lexer->getLineNo(), 3);
        $this->assertEqual($lexer->getCharNo(), 4);
        
        // end of file... should return false now
        $this->assertFalse($lexer->nextToken());
    
    }
    
    /**
     * @todo Test various newlines are handled correctly...
     */
    public function testHandleNewline() {
    
        $crlf = new Parser\Reader\StringReader("BEGIN:VCALENDAR\r\nEND:VCALENDAR\r\n");
        $cr = new Parser\Reader\StringReader("BEGIN:VCALENDAR\rEND:VCALENDAR\r\n");
        $lf = new Parser\Reader\StringReader("BEGIN:VCALENDAR\nEND:VCALENDAR\r\n");
        
        $lexer = new Parser\Lexer($crlf);
        $lexer->nextToken();
        $lexer->nextToken();
        $lexer->nextToken();
        $lexer->nextToken();
        $this->assertEqual($lexer->getToken(), "\r\n");
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 0);
        
        /*
        $lexer->getReader()->backUp();
        $lexer->nextToken();
        $this->assertEqual($lexer->getLineNo(), 2);
        $this->assertEqual($lexer->getCharNo(), 0);
        */
    }
    
    /**
     * These have been commented out because all the methods they test are now
     * protected methods. They have no business being exposed to the world.
     * @todo Find another way to test them.
    public function testIsNewLine() {
    
        $this->assertFalse($this->lexer->isNewLine(" "));
        $this->assertFalse($this->lexer->isNewLine(" \r"));
        $this->assertFalse($this->lexer->isNewLine(" \n"));
        $this->assertFalse($this->lexer->isNewLine("\r\n"));
        $this->assertTrue($this->lexer->isNewLine("\n"));
        $this->assertTrue($this->lexer->isNewLine("\r"));
    
    }
    
    public function testIsAlpha() {
    
        $this->assertFalse($this->lexer->isAlpha(" "));
        $this->assertFalse($this->lexer->isAlpha("6"));
        $this->assertTrue($this->lexer->isAlpha("a"));
        $this->assertTrue($this->lexer->isAlpha("Z"));
    
    }
    
    public function testIsNumeric() {
    
        $this->assertFalse($this->lexer->isNumeric(" "));
        $this->assertFalse($this->lexer->isNumeric("a"));
        $this->assertTrue($this->lexer->isNumeric("0"));
        $this->assertTrue($this->lexer->isNumeric("6"));
    
    }
    
    public function testIsColon() {
    
        $this->assertFalse($this->lexer->isColon(";"));
        $this->assertFalse($this->lexer->isColon(" "));
        $this->assertFalse($this->lexer->isColon(": abc"));
        $this->assertTrue($this->lexer->isColon(":"));
    
    }
    
    public function testIsSemiColon() {
    
        $this->assertFalse($this->lexer->isSemiColon(":"));
        $this->assertFalse($this->lexer->isSemiColon(" "));
        $this->assertFalse($this->lexer->isSemiColon("; abc"));
        $this->assertTrue($this->lexer->isSemiColon(";"));
    
    }
    
    public function testIsQuote() {
    
        $this->assertFalse($this->lexer->isQuote("'"));
        $this->assertFalse($this->lexer->isQuote(" "));
        $this->assertFalse($this->lexer->isQuote('": abc'));
        $this->assertTrue($this->lexer->isQuote('"'));
    
    }
    
    public function testIsApostrophe() {
    
        $this->assertFalse($this->lexer->isApostrophe('"'));
        $this->assertFalse($this->lexer->isApostrophe(" "));
        $this->assertFalse($this->lexer->isApostrophe("' abc"));
        $this->assertTrue($this->lexer->isApostrophe("'"));
    
    }
    
    public function testIsComma() {
    
        $this->assertFalse($this->lexer->isComma(';'));
        $this->assertFalse($this->lexer->isComma(" "));
        $this->assertFalse($this->lexer->isComma(", abc"));
        $this->assertTrue($this->lexer->isComma(","));
    
    }
    
    public function testIsWhitespace() {
    
        $this->assertFalse($this->lexer->isWhitespace(';'));
        $this->assertFalse($this->lexer->isWhitespace("asdf"));
        $this->assertFalse($this->lexer->isWhitespace(" abc"));
        $this->assertTrue($this->lexer->isWhitespace(" "));
        $this->assertTrue($this->lexer->isWhitespace("\t"));
        $this->assertTrue($this->lexer->isWhitespace(" \t    \t\t"));
    
    }
    */

}