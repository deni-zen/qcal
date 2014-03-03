<?php
/**
 * Unit Test Cases for TimeZone class
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\DateTime;
use \qCal\DateTime as DT;

class TimeZoneUnitTest extends \qCal\UnitTest\TestCase {

    public function setUp() {
    
        
    
    }
    
    public function testTimeZoneAltersLocalTime() {
    
        $dtz = new DT\TimeZone('America/Paradise_CA');
        $this->assertEqual($dtz->getId(), 'America/Paradise_CA');
    
    }

}