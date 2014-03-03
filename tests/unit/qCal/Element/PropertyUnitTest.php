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
    
    /**
     * @todo Value array is supposed to be returned in a specific order -- see RFC FREEBUSY property
     * @todo I cannot do __toString() test correctly here because Period doesn't preserve durations. It
     *       converts to set start/end. I intend to fix this eventually.
     */
    public function testMultiValuePropertyFreeBusy() {
    
        $prop = new Property\FreeBusy('19970208T200000Z/PT1H');
        $prop->addValue('19970308T230000Z/19970309T000000Z')
             ->addValue('19970408T200000Z/PT1H')
             ->addValue('19970308T160000Z/PT3H');
        $this->assertEqual($prop->getValue(), array(new Value\Period('19970208T200000Z/PT1H'),new Value\Period('19970308T230000Z/19970309T000000Z'),new Value\Period('19970408T200000Z/PT1H'),new Value\Period('19970308T160000Z/PT3H')));
        // @todo This is the incorrect behavior for many reasons
        $this->assertEqual($prop->__toString(), '19970208T200000Z/19970208T210000Z,19970308T230000Z/19970309T000000Z,19970408T200000Z/19970408T210000Z,19970308T160000Z/19970308T190000Z');
    
    }

}