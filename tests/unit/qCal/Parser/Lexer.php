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
        $this->assertTrue($this->lexer->isNewLine("\n"));
        $this->assertTrue($this->lexer->isNewLine("\r"));
    
    }

}