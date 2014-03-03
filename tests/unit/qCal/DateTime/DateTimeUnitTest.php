<?php
/**
 * Unit Test Cases for DateTime class
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\DateTime;
use \qCal\DateTime;

class DateTimeUnitTest extends \qCal\UnitTest\TestCase {

    public function setUp() {
    
        
    
    }
    
    public function testLocalDateTimeGetters() {
    
        $dt = new DateTime('20140423T000000');
        $this->assertEqual($dt->toDateTime(), '20140423T000000');
        $this->assertEqual($dt->toDate(), '20140423');
        $this->assertEqual($dt->toTime(), '000000');
    
    }
    
    public function testUTCDateTimeGetters() {
    
        $dt = new DateTime('20140423T000000');
        $this->assertEqual($dt->toUtcDateTime(), '20140423T000000Z');
        $this->assertEqual($dt->toUtcDate(), '20140423');
        $this->assertEqual($dt->toUtcTime(), '000000Z');
    
    }
    
    public function testGetTimestamp() {
    
        $dt = new DateTime('20140423T000000');
        $this->assertEqual($dt->getTimestamp(), '1398211200');
    
    }

}