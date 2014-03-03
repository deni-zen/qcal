<?php
/**
 * Conformance (Refactor) Unit Tests
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Seperate this into component, property and parameter conformance
 *              unit tests.
 */
namespace qCal\UnitTest\Conformance;
use \qCal\Conformance as Conf,
    \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException,
    \qCal\Exception\Conformance\RequiredPropertyException,
    \qCal\Exception\Conformance\AllowedParentException,
    \qCal\Exception\Conformance\PropertyConformanceException,
    \qCal\Exception\Conformance\RequiredChildException;

class ConformanceRefactorUnitTest extends \qCal\UnitTest\TestCase {

    /**
     * An array of pre-built components for use in the tests
     */
    protected $cmpnts = array();
    
    public function setUp() {
    
        $alarm = new Element\Component\VAlarm(array('ACTION' => 'AUDIO', 'TRIGGER' => 'PT15M'));
        $calendar = new Element\Component\VCalendar(array('PRODID' => '-//Luke Visinoni//qCal v0.1//EN', 'VERSION' => '2.0'));
        $event = new Element\Component\VEvent(array(
            'UID' => '20130901T120000Z-luke@qcalphp.com',
            'DTSTAMP' => '20140228T1300Z',
            'DTSTART' => '20141020',
            'SUMMARY' => 'Snoop Diggity Dogg\'s Birthday',
            'CLASS' => 'PUBLIC',
            'CATEGORIES' => 'BIRTHDAY,PERSONAL,SPECIAL OCCASION',
            'RRULE' => 'FREQ=YEARLY',
        ));
        $freebusy = new Element\Component\VFreeBusy(array(
            'ORGANIZER' => 'MAILTO:luke.visinoni@gmail.com',
            'ATTENDEE' => 'MAILTO:luke.visinoni@gmail.com',
            'DTSTART' => '20140101T000000Z',
            'DTEND' => '20140228T000000Z',
            'DTSTAMP' => '20140228T000000Z',
        ));
        $journal = new Element\Component\VJournal(array(
            'UID' => '20130901T130000Z-luke@qcalphp.com',
            'DTSTAMP' => '20140228T1500Z',
            'DTSTART' => '20140101T000000Z',
            'SUMMARY' => 'A journal entry',
            'DESCRIPTION' => 'This is a journal entry. It is useless. Nobody even uses journal components in iCalendar.',
        ));
        $timezone = new Element\Component\VTimeZone(array(
            'TZID' => 'US-Eastern',
            'LAST-MODIFIED' => '19870101T000000Z',
        ), array(
            new Element\Component\Standard(array(
                'DTSTART' => '19971026T020000',
                'RDATE' => '19971026T020000',
                'TZOFFSETFROM' => '-0400',
                'TZOFFSETTO' => '-0500',
                'TZNAME' => 'EST'
            )),
            new Element\Component\DayLight(array(
                'DTSTART' => '19971026T020000',
                'RDATE' => '19970406T020000',
                'TZOFFSETFROM' => '-0500',
                'TZOFFSETTO' => '-0400',
                'TZNAME' => 'EDT'
            ))
        ));
        $todo = new Element\Component\VTodo(array(
            'UID' => '19970901T130000Z-123404@host.com',
            'DTSTAMP' => '19970901T1300Z',
            'DTSTART' => '19970415T133000Z',
            'DUE' => '19970416T045959Z',
            'SUMMARY' => '1996 Income Tax Preparation',
            'CLASS' => 'CONFIDENTIAL',
            'CATEGORIES' => 'FAMILY,FINANCE',
            'PRIORITY' => '1',
            'STATUS' => 'NEEDS-ACTION'
        ));
        $this->cmpnts = array(
            'VCALENDAR' => clone $calendar,
            'VALARM' => clone $alarm,
            'VEVENT' => clone $event,
            'VFREEBUSY' => clone $freebusy,
            'VJOURNAL' => clone $journal,
            'VTIMEZONE' => clone $timezone,
            'VTODO' => clone $todo
        );
        $event->attach($alarm);
        $calendar->attach($event);
        $calendar->attach($freebusy);
        $calendar->attach($journal);
        $calendar->attach($timezone);
        $calendar->attach($todo);
        $this->cmpnts['qCal'] = $calendar;
    
    }
    
    // so long as no exception is thrown this test passes
    public function testComponentConformance() {
    
        $visitor = new Conf\Visitor();
        $this->cmpnts['qCal']->accept($visitor);
        $this->assertTrue(true);
    
    }
    
    public function testVAlarmCannotBeTopLevel() {
    
        $this->expectException(new AllowedParentException('VALARM component cannot be nested within VCALENDAR component'));
        $alarm = clone $this->cmpnts['VALARM'];
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $calendar->attach($alarm);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVAlarmTriggerRelatedStart() {
    
        $this->expectException(new PropertyConformanceException('VALARM parent component must have DTSTART property if VALARM is set to trigger in relation to parent\'s start'));
        $alarm = new Element\Component\VAlarm(array('ACTION' => 'AUDIO', 'TRIGGER' => new Element\Property\Trigger('PT15M', array('RELATED' => 'START'))));
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $calendar->addProperty(new Element\Property\Method('REQUEST'));
        $event = clone $this->cmpnts['VEVENT'];
        $event->removeProperty('DTSTART');
        $event->attach($alarm);
        $calendar->attach($event);
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVAlarmTriggerRelatedDtEnd() {
    
        $this->expectException(new PropertyConformanceException('VALARM parent component must have DTEND or DTSTART/DURATION property if VALARM is set to trigger in relation to parent\'s end'));
        $alarm = new Element\Component\VAlarm(array('ACTION' => 'AUDIO', 'TRIGGER' => new Element\Property\Trigger('PT15M', array('RELATED' => 'END'))));
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $event = clone $this->cmpnts['VEVENT'];
        $event->attach($alarm);
        $calendar->attach($event);
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVAlarmTriggerRelatedDtStartAndDuration() {
    
        $this->expectException(new PropertyConformanceException('VALARM parent component must have DTEND or DTSTART/DURATION property if VALARM is set to trigger in relation to parent\'s end'));
        $alarm = new Element\Component\VAlarm(array('ACTION' => 'AUDIO', 'TRIGGER' => new Element\Property\Trigger('PT15M', array('RELATED' => 'END'))));
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $calendar->addProperty(new Element\Property\Method('REQUEST'));
        $event = clone $this->cmpnts['VEVENT'];
        $event->removeProperty('DTSTART');
        $event->addProperty(new Element\Property\Duration('-PT5M'));
        $event->attach($alarm);
        $calendar->attach($event);
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVAlarmRepeatRequiresDuration() {
    
        $this->expectException(new PropertyConformanceException('Repeating VALARM requires both REPEAT and DURATION properties'));
        $alarm = new Element\Component\VAlarm(array('ACTION' => 'AUDIO', 'TRIGGER' => new Element\Property\Trigger('PT15M', array('RELATED' => 'START')), 'REPEAT' => 4));
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $event = clone $this->cmpnts['VEVENT'];
        $event->attach($alarm);
        $calendar->attach($event);
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVTimeZoneMustHaveSubComponent() {
    
        $this->expectException(new RequiredChildException('VTIMEZONE must have at least one STANDARD or DAYLIGHT sub-component'));
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $timezone = new Element\Component\VTimeZone(array(
            'TZID' => 'US-Eastern',
            'LAST-MODIFIED' => '19870101T000000Z',
        ));
        $calendar->attach($timezone);
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testTimeZoneStandardRequiredProperties() {
    
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $tz = clone $this->cmpnts['VTIMEZONE'];
        $std = within($tz->getChildren(array('STANDARD', 'DAYLIGHT')), 0);
        $std->removeProperty('DTSTART')
            ->removeProperty('TZOFFSETTO')
            ->removeProperty('TZOFFSETFROM');
        $calendar->attach($tz);
        
        $this->assertEqual($std->getName(), 'STANDARD');
        $this->expectException(new RequiredPropertyException($std, array('DTSTART','TZOFFSETTO','TZOFFSETFROM')));
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testTimeZoneDayLightRequiredProperties() {
    
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $tz = clone $this->cmpnts['VTIMEZONE'];
        $day = within($tz->getChildren(array('STANDARD', 'DAYLIGHT')), 1);
        $day->removeProperty('DTSTART')
            ->removeProperty('TZOFFSETTO')
            ->removeProperty('TZOFFSETFROM');
        $calendar->attach($tz);
        
        $this->assertEqual($dayaqqqqa   zZazZA->getName(), 'DAYLIGHT');
        $this->expectException(new RequiredPropertyException($day, array('DTSTART','TZOFFSETTO','TZOFFSETFROM')));
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVTodoRequiredUID() {
    
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $vtodo = clone $this->cmpnts['VTODO'];
        $vtodo->removeProperty('UID');
        $calendar->attach($vtodo);
        
        $this->expectException(new RequiredPropertyException($vtodo, array('UID')));
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVTodoRequiredDtStamp() {
    
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $vtodo = clone $this->cmpnts['VTODO'];
        $vtodo->removeProperty('DTSTAMP');
        $calendar->attach($vtodo);
        
        $this->expectException(new RequiredPropertyException($vtodo, array('DTSTAMP')));
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVTodoNotDueAndDuration() {
    
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $vtodo = clone $this->cmpnts['VTODO'];
        $vtodo->addProperty(new Element\Property\Duration('P1D'));
        $calendar->attach($vtodo);
        
        $this->expectException(new PropertyConformanceException('VTODO may define DUE or DURATION property but not both'));
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVEventDtStartRequiredIfCoreDoesntSpecifyMethod() {
    
        $this->expectException(new PropertyConformanceException('DTSTART property is required for VEVENT component that appears in VCALENDAR that does not specify a METHOD property'));
        $event = clone $this->cmpnts['VEVENT'];
        $event->removeProperty('DTSTART');
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $calendar->attach($event);
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVEventNotDtEndAndDuration() {
    
        $calendar = clone $this->cmpnts['VCALENDAR'];
        $event = clone $this->cmpnts['VEVENT'];
        $event->addProperty(new Element\Property\Duration('P1D'));
        $event->addProperty(new Element\Property\DtEnd('20141020'));
        $calendar->attach($event);
        
        $this->expectException(new PropertyConformanceException('VEVENT may define DTEND or DURATION property but not both'));
        
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVCalendarRequiredPropertiesException() {
    
        $calendar = new Element\Component\VCalendar();
        $this->expectException(new RequiredPropertyException($calendar, array('PRODID','VERSION')));
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testVCalendarCannotBeNested() {
    
        $calendar = new Element\Component\VCalendar();
        $calendar2 = clone $calendar;
        $calendar2->attach($calendar);
        $this->expectException(new AllowedParentException('VCALENDAR component cannot be nested within another component'));
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }

}