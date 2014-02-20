<?php
/**
 * Unit Test Cases for DateTime\Period class
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\DateTime;
use \qCal\DateTime as DT,
    \qCal\Exception\DateTime\PeriodException;

class PeriodUnitTest extends \qCal\UnitTest\TestCase {

    public function setUp() {
    
        
    
    }
    
    public function testPeriodDurationInSeconds() {
    
        $start = new \qCal\DateTime('1986-04-23');
        $threeWks = new DT\Duration(array('W' => 3));
        $p = new DT\Period($start, $threeWks);
        $this->assertEqual($p->getDiffInSeconds(), $threeWks->toSeconds());
    
    }
    
    public function testPeriodDateTimeInSeconds() {
    
        $start = new \qCal\DateTime('1986-04-23');
        $end = new \qCal\DateTime('1986-05-21');
        $p = new DT\Period($start, $end);
        $this->assertEqual($p->getDuration()->toICal(), 'P4W');
        $this->assertEqual($p->getDiffInSeconds(), 2419200);
    
    }
    
    public function testNegativePeriodThrowsException() {
    
        $start = new \qCal\DateTime('1986-04-23');
        $end = new \qCal\DateTime('1986-03-23');
        $this->expectException(new PeriodException('Cannot create negative time period'));
        $period = new DT\Period($start, $end);
    
    }

}