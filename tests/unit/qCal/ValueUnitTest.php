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
    
    }
    
    public function testDirectBinary() {
    
        $binary = file_get_contents('./files/logo.png');
        $value = new Value\Binary($binary);
        $this->assertEqual($value->__toString(), base64_encode($binary));
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
    
        
    
    }
    
    public function testCalAddressValue() {
    
        
    
    }
    
    public function testDateValue() {
    
        $date = new Value\Date('2014-04-23');
        $this->assertEqual($date->toString(), '20140423');
    
    }
    
    public function testDateTimeValue() {
    
        $date = new Value\DateTime('2014-04-23 01:00:00');
        $this->assertEqual($date->toString(), '20140423T010000');
    
    }

}