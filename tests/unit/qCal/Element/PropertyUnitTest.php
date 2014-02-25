<?php
/**
 * qCal\Element\Property unit tests
 */
namespace qCal\UnitTest\Element;
use \qCal\Element\Component,
    \qCal\Element\Property,
    \qCal\Value;

class PropertyUnitTest extends \qCal\UnitTest\TestCase {

    public function testActionProperty() {
    
        $prop = new Property\Action('AUDIO');
        $this->assertIsA($prop->getValue(), 'qCal\Value\Text');
        $this->assertEqual($prop->getValue(), new Value\Text('AUDIO'));
    
    }
    
    public function testSetParent() {
    
        $cal = new Component\VCalendar();
        $v = new Property\Version(2);
        $cal->addProperty($v);
        
        $todo = new Component\VTodo();
        $desc = new Property\Description('Some description or something');
        $todo->addProperty($desc);
        
        $cal->attach($todo);
        
        $this->assertIdentical($desc->getParent(), $todo);
        $this->assertIdentical($v->getParent(), $cal);
    
    }
    
    public function testGetCore() {
    
        $cal = new Component\VCalendar();
        $v = new Property\Version(2);
        $cal->addProperty($v);
        
        $todo = new Component\VTodo();
        $desc = new Property\Description('Some description or something');
        $todo->addProperty($desc);
        
        $cal->attach($todo);
        
        $this->assertIdentical($desc->getCore(), $cal);
        $this->assertIdentical($v->getCore(), $cal);
    
    }

}