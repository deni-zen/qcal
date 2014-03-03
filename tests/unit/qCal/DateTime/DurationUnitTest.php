<?php
/**
 * Unit Test Cases for DateTime\Duration class
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\DateTime;
use qCal\DateTime as DT;

class DurationUnitTest extends \qCal\UnitTest\TestCase {

    public function setUp() {
    
        
    
    }
    
    public function testDurationFormat() {
    
        $d = new DT\Duration('P15DT5H0M20S');
        $this->assertEqual($d->toICal(), 'P2W1DT5H20S');
    
    }
    
    public function testConvertToSeconds() {
    
        $d = new DT\Duration('P15DT5H0M20S');
        $this->assertEqual($d->toSeconds(), 1314020);
    
    }
    
    public function testDurationArrayInput() {
    
        $inputArray = array(
            'D' => 15,
            'H' => 5,
            'S' => 20,
        );
        $d = new DT\Duration($inputArray);
        $this->assertEqual($d->toSeconds(), 1314020);
    
    }
    
    public function testInvalidInputString() {
    
        $inputstring = 'invalid523string';
        $this->expectException(new \qCal\Exception\DateTime\DurationException("Invalid input string: \"$inputstring\""));
        $d = new DT\Duration($inputstring);
    
    }
    
    public function testInvalidIntervalInInputString() {
    
        $inputstring = 'P6Y';
        $this->expectException(new \qCal\Exception\DateTime\DurationException("Invalid input string: \"$inputstring\""));
        $d = new DT\Duration($inputstring);
    
    }
    
    public function testInvalidIntervalInInputArray() {
    
        $inputarray = array('Y' => 3, 'W' => 5, 'H' => 5, 'S' => 25);
        $this->expectException(new \qCal\Exception\DateTime\DurationException("Invalid input array"));
        $d = new DT\Duration($inputarray);
    
    }
    
    public function testNegativeDuration() {
    
        $sixhrs = new DT\Duration('-PT6H');
        $tenwks = new DT\Duration('-P10W');
        $twodys = new DT\Duration('-P2D');
        
        $this->assertEqual($sixhrs->toSeconds(), -21600);
        $this->assertEqual($tenwks->toSeconds(), -6048000);
        $this->assertEqual($twodys->toSeconds(), -172800);
    
    }

}