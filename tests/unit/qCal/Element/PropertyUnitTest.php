<?php
/**
 * qCal\Element\Component unit tests
 */
namespace qCal\UnitTest\Element;
use \qCal\Element\Property;

class PropertyUnitTest extends \qCal\UnitTest\TestCase {

    public function testCoreICalComponent() {
    
        $cal = new Component\VCalendar();
        $this->assertEqual($cal->getName(), 'VCALENDAR');
    
    }

}