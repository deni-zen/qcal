<?php
/**
 * Unit Test Cases for qCal\Loader
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest;
use \qCal\Value,
    \qCal\Exception\Value\UnknownTypeException;

class ValueUnitTest extends \qCal\UnitTest\TestCase {


    public function testGenerate() {
    
        $value = Value::generate('text', 'Foo!');
        $this->assertIsA($value, 'qCal\\Value\\Text');
        $this->assertEqual($value->toString(), 'Foo!');
        $value = Value::generate('tExt');
        $this->assertEqual($value->toString(), '');
    
    }
    
    public function testGenerateThrowsExceptionForUnknownType() {
    
        $type = 'foo';
        $this->expectException(new UnknownTypeException('Cannot generate value of unknown type, "' . $type . '"'));
        $value = Value::generate($type, 'foo');
    
    }

    public function testTextValue() {
    
        $value = new Value\Text('Foo');
        $this->assertEqual($value->toString(), 'Foo');
        $genval = Value::generate('Text', 'Foo');
        $this->assertEqual($value, $genval);
    
    }
    
    public function testBinaryValue() {
    
        $binary = base64_encode('Foo');
        $value = new Value\Binary('Foo');
        $this->assertEqual($value->toString(), $binary);
        $this->assertEqual($value->getValue(), 'Foo');
        $genval = Value::generate('binary', 'Foo');
        $this->assertEqual($value, $genval);
    
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
        $genval = Value::generate('boolean', 'false');
        $this->assertEqual($bool, $genval);
        $bool = new Value\Boolean(true);
        $this->assertTrue($bool->getValue());
        $this->assertEqual($bool->toString(), 'TRUE');
        $genval = Value::generate('boolean', 'true');
        $this->assertEqual($bool, $genval);
    
    }
    
    public function testBooleanValueIsCaseInsensitive() {
    
        $lower = Value::generate('boolean', 'false');
        $upper = Value::generate('boolean', 'FALSE');
        $this->assertEqual($lower, $upper);
    
    }
    
    public function testUriValue() {
    
        $uristring = 'mailto:foo@bar.com';
        $uri = new Value\Uri($uristring);
        $this->assertEqual($uri->getValue(), $uristring);
        $this->assertEqual($uri->toString(), $uristring);
        $genval = Value::generate('uri', $uristring);
        $this->assertEqual($uri, $genval);
    
    }
    
    public function testCalAddressValue() {
    
        $castring = 'mailto:foo@bar.com';
        $ca = new Value\CalAddress($castring);
        $this->assertEqual($ca->getValue(), $castring);
        $this->assertEqual($ca->toString(), $castring);
        $genval = Value::generate('caladdress', $castring);
        $this->assertEqual($ca, $genval);
    
    }
    
    // @todo Change this to use qCal\DateTime\Date
    public function testDateValue() {
    
        $date = new Value\Date('2014-04-23');
        $this->assertEqual($date->toString(), '20140423');
        $this->assertIsA($date->getValue(), 'qCal\\DateTime');
        $this->assertEqual($date->getValue()->format('Ymd'), '20140423');
        $genval = Value::generate('date', '2014-04-23');
        $this->assertEqual($date, $genval);
    
    }
    
    public function testDateTimeValue() {
    
        $dt = new Value\DateTime('2014-04-23 01:00:00');
        $this->assertEqual($dt->toString(), '20140423T010000');
        $this->assertIsA($dt->getValue(), 'qCal\\DateTime');
        $this->assertEqual($dt->getValue()->format('Ymd\THis'), '20140423T010000');
        $genval = Value::generate('datetime', '2014-04-23 01:00:00');
        $this->assertEqual($dt, $genval);
    
    }
    
    public function testDurationValue() {
    
        $dur = new Value\Duration('P2W4D');
        $this->assertEqual($dur->toString(), 'P2W4D');
        $this->assertIsA($dur->getValue(), 'qCal\\DateTime\\Duration');
        $this->assertEqual($dur->getValue()->toICal(), 'P2W4D');
        $genval = Value::generate('duration', 'P2W4D');
        $this->assertEqual($dur, $genval);
    
    }
    
    public function testFloatValue() {
    
        $flt = new Value\Float(15);
        $this->assertEqual($flt->toString(), '15.0');
        $this->assertIdentical($flt->getValue(), 15.0);
        $genval = Value::generate('float', 15);
        $this->assertEqual($flt, $genval);
    
    }
    
    public function testIntegerValue() {
    
        $int = new Value\Integer(15);
        $this->assertEqual($int->toString(), '15');
        $this->assertIdentical($int->getValue(), 15);
        $genval = Value::generate('integer', 15);
        $this->assertEqual($int, $genval);
    
    }
    
    public function testPeriodValue() {
    
        $per = new Value\Period('19970101T180000Z/19970601T180000Z');
        $this->assertEqual($per->toString(), '19970101T180000Z/19970601T180000Z');
        $this->assertIsA($per->getValue(), 'qCal\\DateTime\\Period');
        $this->assertEqual($per->getValue()->toICal(), '19970101T180000Z/19970601T180000Z');
        $genval = Value::generate('period', '19970101T180000Z/19970601T180000Z');
        $this->assertEqual($per, $genval);
    
    }
    
    public function testRecurValue() {
    
        // @todo implement this 
    
    }
    
    // @todo Change this to use qCal\DateTime\Time
    public function testTimeValue() {
    
        $time = new Value\Time('120000');
        $this->assertEqual($time->toString(), '120000');
        $this->assertIsA($time->getValue(), 'qCal\\DateTime');
        $this->assertEqual($time->getValue()->format('His'), '120000');
        $genval = Value::generate('time', '120000');
        $this->assertEqual($time, $genval);
    
    }
    
    public function testUtcOffsetValue() {
    
        // @todo Write tests once this value type class is written
    
    }

}