<?php
/**
 * qCal\Element\Component unit tests
 */
namespace qCal\UnitTest\Element;
use \qCal\Element\Component;

class ComponentUnitTest extends \qCal\UnitTest\TestCase {

    public function testCoreICalComponent() {
    
        $cal = new Component\VCalendar();
        $this->assertEqual($cal->getName(), 'VCALENDAR');
    
    }

    public function testAlarmComponent() {
    
        $comp = new Component\VAlarm();
        $this->assertEqual($comp->getName(), 'VALARM');
    
    }

    public function testEventComponent() {
    
        $comp = new Component\VEvent();
        $this->assertEqual($comp->getName(), 'VEVENT');
    
    }

    public function testFreeBusyComponent() {
    
        $comp = new Component\VFreeBusy();
        $this->assertEqual($comp->getName(), 'VFREEBUSY');
    
    }

    public function testJournalComponent() {
    
        $comp = new Component\VJournal();
        $this->assertEqual($comp->getName(), 'VJOURNAL');
    
    }

    public function testTodoComponent() {
    
        $comp = new Component\VTodo();
        $this->assertEqual($comp->getName(), 'VTODO');
    
    }

    public function testTimezoneComponent() {
    
        $comp = new Component\VTimezone();
        $this->assertEqual($comp->getName(), 'VTIMEZONE');
    
    }

    public function testDayLightSubComponent() {
    
        $comp = new Component\DayLight();
        $this->assertEqual($comp->getName(), 'DAYLIGHT');
    
    }

    public function testStandardSubComponent() {
    
        $comp = new Component\Standard();
        $this->assertEqual($comp->getName(), 'STANDARD');
    
    }
    
    public function testAttachComponents() {
    
        $core = new Component\VCalendar();
        
        $alarm = new Component\VAlarm();
        $core->attach($alarm);
        
        $event = new Component\VEvent();
        $core->attach($event);
        
        $freebusy = new Component\VFreeBusy();
        $core->attach($freebusy);
        
        $journal = new Component\VJournal();
        $core->attach($journal);
        
        $todo = new Component\VTodo();
        $core->attach($todo);
        
        $tz = new Component\VTimeZone();
        $daylight = new Component\DayLight();
        $standard = new Component\Standard();
        $tz->attach($daylight)
           ->attach($standard);
        $core->attach($tz);
        
        // Children array should be a multi-dimensional associative array with
        // component names as keys and a list of all of the children of that
        // type as values
        $components = $core->getChildren();
        $this->assertEqual(array_keys($components), array('VALARM', 'VEVENT', 'VFREEBUSY', 'VJOURNAL', 'VTODO', 'VTIMEZONE'));
        $this->assertIsA($components['VALARM'][0], 'qCal\Element\Component\VAlarm');
        $this->assertIsA($components['VEVENT'][0], 'qCal\Element\Component\VEvent');
        $this->assertIsA($components['VFREEBUSY'][0], 'qCal\Element\Component\VFreeBusy');
        $this->assertIsA($components['VJOURNAL'][0], 'qCal\Element\Component\VJournal');
        $this->assertIsA($components['VTODO'][0], 'qCal\Element\Component\VTodo');
        $this->assertIsA($components['VTIMEZONE'][0], 'qCal\Element\Component\VTimeZone');
        
        $subcomponents = $components['VTIMEZONE'][0]->getChildren();
        $this->assertEqual(array_keys($subcomponents), array('DAYLIGHT', 'STANDARD'));
    
    }
    
    public function testGetChildrenAcceptsType() {
    
        $core = new Component\VCalendar();
        
        $journal = new Component\VJournal();
        $core->attach($journal);
        
        $tz = new Component\VTimeZone();
        $daylight = new Component\DayLight();
        $standard = new Component\Standard();
        $tz->attach($daylight)
           ->attach($standard);
        $core->attach($tz);
        
        $components = $core->getChildren();
        $this->assertEqual(array_keys($components), array('VJOURNAL', 'VTIMEZONE'));
        $this->assertIsA($components['VJOURNAL'][0], 'qCal\Element\Component\VJournal');
        
        $journals = $core->getChildren('VJOURNAL');
        $this->assertEqual($journals, array($journal));
        
        $this->assertEqual($tz->getChildren('DAYlight'), array($daylight));
        
        // asking for a component type when there are no children of that type should return an empty array
        $this->assertEqual($tz->getChildren('foo'), array());
    
    }

}