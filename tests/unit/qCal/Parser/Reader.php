<?php
/**
 * Unit Test Cases for qCal\Parser\Lexer
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Parser;

class Reader extends \qCal\UnitTest\TestCase {

    protected $reader;
    protected $data;
    
    public function setUp() {
    
        parent::setUp();
        $this->data = <<<ICALDATA
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
        $this->reader = new \qCal\Parser\Reader($this->data);
    
    }
    
    public function testGetChar() {
    
        $this->assertEqual($this->reader->getChar(), 'B');
    
    }
    
    public function testGetCharReturnsFalseAtEndOfFile() {
    
        $reader = new \qCal\Parser\Reader('foo');
        $this->assertTrue($reader->getChar());
        $this->assertTrue($reader->getChar());
        $this->assertTrue($reader->getChar());
        $this->assertFalse($reader->getChar());
    
    }
    
    public function testGetCharAdvancesPos() {
    
        $this->assertEqual($this->reader->getPos(), 0);
        $this->reader->getChar();
        $this->assertEqual($this->reader->getPos(), 1);
        $this->reader->getChar();
        $this->reader->getChar();
        $this->reader->getChar();
        $this->assertEqual($this->reader->getPos(), 4);
    
    }
    
    public function testBackUp() {
    
        $this->assertEqual($this->reader->getChar(), 'B');
        $this->assertEqual($this->reader->getPos(), 1);
        $this->assertEqual($this->reader->getChar(), 'E');
        $this->assertEqual($this->reader->getPos(), 2);
        $pos = $this->reader->backUp();
        $this->assertEqual($pos, 2);
        $this->assertEqual($this->reader->getChar(), 'E');
        $this->assertEqual($this->reader->getPos(), 2);
        $this->assertEqual($this->reader->getChar(), 'G');
        $this->assertEqual($this->reader->getPos(), 3);
    
    }

}