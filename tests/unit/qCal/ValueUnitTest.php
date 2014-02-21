<?php
/**
 * Unit Test Cases for qCal\Loader
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest;
use qCal\Value;

class ValueUnitTest extends \qCal\UnitTest\TestCase {

    public function testTextValue() {
    
        $value = new Value\Text('Foo');
        $this->assertEqual($value->toString(), 'Foo');
    
    }
    
    public function testBinaryValue() {
    
        $binary = base64_encode('Foo');
        $value = new Value\Binary('Foo');
        $this->assertEqual($value->toString(), $binary);
        $this->assertEqual($value->getValue(), 'Foo');
    
    }
    
    public function testDirectBinary() {
    
        $binary = file_get_contents('./files/logo.png');
        $value = new Value\Binary($binary);
        $this->assertEqual($value->toString(), base64_encode($binary));
        $this->assertEqual($value->getValue(), $binary);
    
    }
    
    public function testBooleanValue() {
    
        $bool = new Value\Boolean(false);
        $this->assertFalse($bool->getValue());
        $this->assertEqual($bool->toString(), 'FALSE');
        $bool = new Value\Boolean(true);
        $this->assertTrue($bool->getValue());
        $this->assertEqual($bool->toString(), 'TRUE');
    
    }
    
    public function testUriValue() {
    
        $uristring = 'mailto:foo@bar.com';
        $uri = new Value\Uri($uristring);
        $this->assertEqual($uri->getValue(), $uristring);
        $this->assertEqual($uri->toString(), $uristring);
    
    }
    
    public function testCalAddressValue() {
    
        $castring = 'mailto:foo@bar.com';
        $ca = new Value\CalAddress($castring);
        $this->assertEqual($ca->getValue(), $castring);
        $this->assertEqual($ca->toString(), $castring);
    
    }
    
    // @todo Change this to use qCal\DateTime\Date
    public function testDateValue() {
    
        $date = new Value\Date('2014-04-23');
        $this->assertEqual($date->toString(), '20140423');
        $this->assertIsA($date->getValue(), 'qCal\DateTime');
        $this->assertEqual($date->getValue()->format('Ymd'), '20140423');
    
    }
    
    public function testDateTimeValue() {
    
        $dt = new Value\DateTime('2014-04-23 01:00:00');
        $this->assertEqual($dt->toString(), '20140423T010000');
        $this->assertIsA($dt->getValue(), 'qCal\DateTime');
        $this->assertEqual($dt->getValue()->format('Ymd\THis'), '20140423T010000');
    
    }
    
    public function testDurationValue() {
    
        $dur = new Value\Duration('P2W4D');
        $this->assertEqual($dur->toString(), 'P2W4D');
        $this->assertIsA($dur->getValue(), 'qCal\DateTime\Duration');
        $this->assertEqual($dur->getValue()->toICal(), 'P2W4D');
    
    }
    
    public function testFloatValue() {
    
        $flt = new Value\Float(15);
        $this->assertEqual($flt->toString(), '15.0');
        $this->assertIdentical($flt->getValue(), 15.0);
    
    }
    
    public function testIntegerValue() {
    
        $int = new Value\Integer(15);
        $this->assertEqual($int->toString(), '15');
        $this->assertIdentical($int->getValue(), 15);
    
    }
    
    public function testPeriodValue() {
    
        $per = new Value\Period('19970101T180000Z/19970601T180000Z');
        $this->assertEqual($per->toString(), '19970101T180000Z/19970601T180000Z');
        $this->assertIsA($per->getValue(), 'qCal\DateTime\Period');
        $this->assertEqual($per->getValue()->toICal(), '19970101T180000Z/19970601T180000Z');
    
    }
    
    public function testRecurValue() {
    
        // @todo implement this 
    
    }
    
    // @todo Change this to use qCal\DateTime\Time
    public function testTimeValue() {
    
        $time = new Value\Time('120000');
        $this->assertEqual($time->toString(), '120000');
        $this->assertIsA($time->getValue(), 'qCal\DateTime');
        $this->assertEqual($time->getValue()->format('His'), '120000');
    
    }
    
    public function testUtcOffsetValue() {
    
        // @todo Write tests once this value type class is written
    
    }

}