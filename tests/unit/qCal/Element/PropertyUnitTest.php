<?php
/**
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
    
    }

}