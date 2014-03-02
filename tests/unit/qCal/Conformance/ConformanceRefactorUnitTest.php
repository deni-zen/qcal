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
    \qCal\Exception\Conformance\AllowedParentException;

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

}