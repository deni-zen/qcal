<?php
/**
 * Unit Test Cases for qCal\Parser\Lexer
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Parser;

class Lexer extends \qCal\UnitTest\TestCase {

    protected $lexer;
    
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
        $this->lexer = new \qCal\Parser\Lexer($data);
    
    }
    
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
        $this->assertFalse($this->lexer->isAlpha("abc123"));
        $this->assertTrue($this->lexer->isAlpha("a"));
        $this->assertTrue($this->lexer->isAlpha("aaaa"));
        $this->assertTrue($this->lexer->isAlpha("aAAa"));
        $this->assertTrue($this->lexer->isAlpha("A"));
    
    }
    
    public function testIsNumeric() {
    
        $this->assertFalse($this->lexer->isNumeric(" "));
        $this->assertFalse($this->lexer->isNumeric("a"));
        $this->assertTrue($this->lexer->isNumeric("0"));
        $this->assertTrue($this->lexer->isNumeric("5643"));
    
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

}