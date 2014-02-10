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
    
    /**
     * @todo The lexer uses this to back up to the last token. In many cases, it
     * will fail because alpha tokens and newline tokens can be multiple characters
     * and the current implementation of Reader::backUp() just backs up one
     * character. I think the solution is to build a Lexer::backToken() method
     * that uses Reader::backUp() to go back a character, but is smart enough to
     * know when it needs to continue past the last char in search for the
     * beginning of the token.
     */
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
    
    /**
     * @todo move these into their own unit test
     */
    public function testReadFromFile() {
    
        $reader = new \qCal\Parser\Reader\File('data/lukeschedule.ics');
        $this->assertEqual($reader->getChar(), 'B');
        $this->assertEqual($reader->getChar(), 'E');
        $this->assertEqual($reader->getChar(), 'G');
        $this->assertEqual($reader->getChar(), 'I');
        $this->assertEqual($reader->getChar(), 'N');
        $this->assertEqual($reader->getChar(), ':');
        $this->assertEqual($reader->getChar(), 'V');
        $this->assertEqual($reader->getChar(), 'C');
        $this->assertEqual($reader->getChar(), 'A');
        $this->assertEqual($reader->getChar(), 'L');
        $this->assertEqual($reader->getChar(), 'E');
        $this->assertEqual($reader->getChar(), 'N');
        $this->assertEqual($reader->getChar(), 'D');
        $this->assertEqual($reader->getChar(), 'A');
        $this->assertEqual($reader->getChar(), 'R');
        $this->assertEqual($reader->getChar(), "\r");
        $this->assertEqual($reader->getChar(), "\n");
        $this->assertEqual($reader->getChar(), "M");
    
    }
    
    public function testHandleNonExistentFile() {
    
        $filename = 'data/non-existent-file.ics';
        $this->expectException(new \Exception('File does not exist: "' . $filename . '"'));
        $reader = new \qCal\Parser\Reader\File($filename);
    
    }
    
    public function testFileReaderGetCharReturnsFalseAtEndOfFile() {
    
        $reader = new \qCal\Parser\Reader\File('data/bastille-day.ics');
        $i = 0;
        while($i < 280) {
            $reader->getChar();
            $i++;
        }
        $char = $reader->getChar();
        $this->assertTrue($char === false);
    
    }

}