<?php
/**
<<<<<<< HEAD
 * qCal\Element\Component unit tests
 */
namespace qCal\UnitTest\Element;
use \qCal\Element\Property;

class PropertyUnitTest extends \qCal\UnitTest\TestCase {

    public function testCoreICalComponent() {
    
        $cal = new Component\VCalendar();
        $this->assertEqual($cal->getName(), 'VCALENDAR');
=======
 * qCal\Element\Property unit tests
 */
namespace qCal\UnitTest\Element;
use \qCal\Element\Property,
    \qCal\Value;

class PropertyUnitTest extends \qCal\UnitTest\TestCase {

    public function testActionProperty() {
    
        $prop = new Property\Action('AUDIO');
        $this->assertIsA($prop->getValue(), 'qCal\Value\Text');
        $this->assertEqual($prop->getValue(), new Value\Text('AUDIO'));
>>>>>>> 80060ca0afd8344ce20d3ca0f283c7b15e363172
    
    }

}