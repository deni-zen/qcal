<?php
/**
 * Conformance Unit Tests
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Conformance;
use \qCal\Conformance as Conf,
    \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class ConformanceUnitTest extends \qCal\UnitTest\TestCase {

    public function testVisitorDoesntThrowException() {
    
        $cal = new Element\Component\VCalendar();
        $alarm = new Element\Component\VAlarm();
        $tz = new Element\Component\VTimeZone();
        $action = new Element\Property\Action('AUDIO');
        $alarm->addProperty($action);
        // $alarm->addProperty(clone $action);
        $attach = new Element\Property\Attach('http://www.example.com/some/attachment.exe');
        // $tz->addProperty($attach);
        $comment = new Element\Property\Comment('This is a comment');
        $tz->addProperty($comment);
        $cal->attach($alarm);
        $cal->attach($tz);
        $visitor = new Conf\Visitor();
        $cal->accept($visitor);
    
    }
    
    public function testActionPropertyConformance() {
    
        // No exception thrown here means test passes
        $alarm = new Element\Component\VAlarm();
        $action = new Element\Property\Action();
        $alarm->addProperty($action);
        $visitor = new Conf\Visitor();
        $alarm->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('ACTION property cannot be defined for VJOURNAL component.'));
        $journal = new Element\Component\VJournal();
        $action = new Element\Property\Action();
        $journal->addProperty($action);
        $visitor = new Conf\Visitor();
        $journal->accept($visitor);
    
    }
    
    public function testAttachPropertyConformance() {
    
        // No exception thrown here means test passes
        $alarm = new Element\Component\VAlarm();
        $attach = new Element\Property\Attach();
        $alarm->addProperty($attach);
        $visitor = new Conf\Visitor();
        $alarm->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('ATTACH property cannot be defined for VTIMEZONE component.'));
        $timezone = new Element\Component\VTimeZone();
        $attach = new Element\Property\Attach();
        $timezone->addProperty($attach);
        $visitor = new Conf\Visitor();
        $timezone->accept($visitor);
    
    }
    
    /**
     * Attendee property has a really poorly defined conformance description.
     * Need to make sure this is right.
     */
    public function testAttendeePropertyConformance() {
    
        // No exception thrown here means test passes
        $alarm = new Element\Component\VAlarm();
        $attendee = new Element\Property\Attendee();
        $alarm->addProperty($attendee);
        $visitor = new Conf\Visitor();
        $alarm->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('ATTENDEE property cannot be defined for VTIMEZONE component.'));
        $timezone = new Element\Component\VTimeZone();
        $attendee = new Element\Property\Attendee();
        $timezone->addProperty($attendee);
        $visitor = new Conf\Visitor();
        $timezone->accept($visitor);
    
    }
    
    public function testCalScalePropertyConformance() {
    
        // No exception thrown here means test passes
        $calendar = new Element\Component\VCalendar();
        $calscale = new Element\Property\CalScale();
        $calendar->addProperty($calscale);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('CALSCALE property cannot be defined for VTODO component.'));
        $todo = new Element\Component\VTodo();
        $calscale = new Element\Property\CalScale();
        $todo->addProperty($calscale);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
    
    }
    
    public function testCategoriesPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $categories = new Element\Property\Categories();
        $todo->addProperty($categories);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('CATEGORIES property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $categories = new Element\Property\Categories();
        $calendar->addProperty($categories);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testClassPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $class = new Element\Property\Classification();
        $todo->addProperty($class);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('CLASS property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $class = new Element\Property\Classification();
        $calendar->addProperty($class);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testCommentPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $comment = new Element\Property\Comment();
        $todo->addProperty($comment);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('COMMENT property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $comment = new Element\Property\Comment();
        $calendar->addProperty($comment);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    /**
     * COMMENT property can be set multiple times
     * @todo Mock objects would really be helpful in all of these tests. With a
     *       mock object I could test the visitor from inside of properties
     *       rather than simply accepting no exception being thrown as a success
     */
    public function testCommentPropertyAllowMultipleConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $comment1 = new Element\Property\Comment('Foo');
        $comment2 = new Element\Property\Comment('Bar');
        $todo->addProperty($comment1);
        $todo->addProperty($comment2);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        $this->assertEqual(count($todo->getProperties('COMMENT')), 2);
    
    }
    
    public function testContactPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $contact = new Element\Property\Contact();
        $todo->addProperty($contact);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('CONTACT property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $contact = new Element\Property\Contact();
        $calendar->addProperty($contact);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testCreatedPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $created = new Element\Property\Created();
        $todo->addProperty($created);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('CREATED property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $created = new Element\Property\Created();
        $calendar->addProperty($created);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testDescriptionPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $description = new Element\Property\Description();
        $todo->addProperty($description);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('DESCRIPTION property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $description = new Element\Property\Description();
        $calendar->addProperty($description);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    /**
     * DESCRIPTION property can be set multiple times for VJOURNAL
     */
    public function testDescriptionPropertyAllowMultipleConformance() {
    
        // Journal component allows multiple description properties
        $journal = new Element\Component\VJournal();
        $description1 = new Element\Property\Description('Foo');
        $description2 = new Element\Property\Description('Bar');
        $journal->addProperty($description1);
        $journal->addProperty($description2);
        $visitor = new Conf\Visitor();
        $journal->accept($visitor);
        
        $this->assertEqual(count($journal->getProperties('DESCRIPTION')), 2);
        
        // Todo component (and others) do not allow multiple descriptions
        $this->expectException(new ConformanceException('DESCRIPTION property may only be defined once for VTODO component.'));
        $todo = new Element\Component\VTodo();
        $description1 = new Element\Property\Description('Foo');
        $description2 = new Element\Property\Description('Bar');
        $todo->addProperty($description1);
        $todo->addProperty($description2);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
    
    }
    
    public function testDtEndPropertyConformance() {
    
        // No exception thrown here means test passes
        $event = new Element\Component\VEvent();
        $dtend = new Element\Property\DtEnd();
        $event->addProperty($dtend);
        $visitor = new Conf\Visitor();
        $event->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('DTEND property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $dtend = new Element\Property\DtEnd();
        $calendar->addProperty($dtend);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    /**
     * DtStart obviously must come before DtEnd
     * @todo This also needs to check that DtEnd is the same type as DtStart
     */
    public function testDtStartAndDtEndConformance() {
    
        $dtstart = new Element\Property\DtStart('2014-02-26 9:00:00');
        $dtend = new Element\Property\DtEnd('2014-02-25 9:00:00');
        $calendar = new Element\Component\VCalendar();
        $event = new Element\Component\VEvent();
        $event->addProperty($dtstart);
        $event->addProperty($dtend);
        
        $this->expectException(new ConformanceException('Value of DTEND property must be later in time than the value of the DTSTART property.'));
        $visitor = new Conf\Visitor();
        $event->accept($visitor);
    
    }
    
    public function testDtStampPropertyConformance() {
    
        // No exception thrown here means test passes
        $event = new Element\Component\VEvent();
        $dtstamp = new Element\Property\DtStamp();
        $event->addProperty($dtstamp);
        $visitor = new Conf\Visitor();
        $event->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('DTSTAMP property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $dtstamp = new Element\Property\DtStamp();
        $calendar->addProperty($dtstamp);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testDuePropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $due = new Element\Property\Due();
        $todo->addProperty($due);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('DUE property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $due = new Element\Property\Due();
        $calendar->addProperty($due);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testDurationPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $duration = new Element\Property\Duration('P4W');
        $todo->addProperty($duration);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('DURATION property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $duration = new Element\Property\Duration('P16D');
        $calendar->addProperty($duration);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    /**
     * If DtStart property is set, Due must be equal to or after it
     * @todo I believe this also needs to check that Due is the same type as DtStart
     */
    public function testDtStartAndDueConformance() {
    
        $dtstart = new Element\Property\DtStart('2014-02-26 9:00:00');
        $due = new Element\Property\Due('2014-02-25 9:00:00');
        $calendar = new Element\Component\VCalendar();
        $event = new Element\Component\VEvent();
        $event->addProperty($dtstart);
        $event->addProperty($due);
        
        $this->expectException(new ConformanceException('Value of DUE property must be equal to or later in time than the value of the DTSTART property.'));
        $visitor = new Conf\Visitor();
        $event->accept($visitor);
    
    }
    
    public function testExDatePropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $exdate = new Element\Property\ExDate();
        $todo->addProperty($exdate);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('EXDATE property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $exdate = new Element\Property\ExDate();
        $calendar->addProperty($exdate);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testExRulePropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $exrule = new Element\Property\ExRule();
        $todo->addProperty($exrule);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('EXRULE property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $exrule = new Element\Property\ExRule();
        $calendar->addProperty($exrule);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testFreeBusyPropertyConformance() {
    
        // No exception thrown here means test passes
        $vfb = new Element\Component\VFreeBusy();
        $freebusy = new Element\Property\FreeBusy('19970308T230000Z/19970309T000000Z');
        $vfb->addProperty($freebusy);
        $visitor = new Conf\Visitor();
        $vfb->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('FREEBUSY property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $freebusy = new Element\Property\FreeBusy('19970308T230000Z/19970309T000000Z');
        $calendar->addProperty($freebusy);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testGeoPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $geo = new Element\Property\Geo();
        $todo->addProperty($geo);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('GEO property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $geo = new Element\Property\Geo();
        $calendar->addProperty($geo);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testLastModifiedPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $lastmodified = new Element\Property\LastModified();
        $todo->addProperty($lastmodified);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('LAST-MODIFIED property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $lastmodified = new Element\Property\LastModified();
        $calendar->addProperty($lastmodified);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testLocationPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $location = new Element\Property\Location();
        $todo->addProperty($location);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('LOCATION property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $location = new Element\Property\Location();
        $calendar->addProperty($location);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testMethodPropertyConformance() {
    
        // No exception thrown here means test passes
        $calendar = new Element\Component\VCalendar();
        $method = new Element\Property\Method();
        $calendar->addProperty($method);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('METHOD property cannot be defined for VTODO component.'));
        $todo = new Element\Component\VTodo();
        $method = new Element\Property\Method();
        $todo->addProperty($method);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
    
    }
    
    public function testOrganizerPropertyConformance() {
    
        // No exception thrown here means test passes
        $event = new Element\Component\VEvent();
        $organizer = new Element\Property\Organizer();
        $event->addProperty($organizer);
        $visitor = new Conf\Visitor();
        $event->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('ORGANIZER property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $organizer = new Element\Property\Organizer();
        $calendar->addProperty($organizer);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testPercentCompletePropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $percent = new Element\Property\PercentComplete();
        $todo->addProperty($percent);
        $visitor = new Conf\Visitor();
        $percent->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('PERCENT-COMPLETE property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $percent = new Element\Property\PercentComplete();
        $calendar->addProperty($percent);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testPriorityPropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $priority = new Element\Property\Priority();
        $todo->addProperty($priority);
        $visitor = new Conf\Visitor();
        $priority->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('PRIORITY property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $priority = new Element\Property\Priority();
        $calendar->addProperty($priority);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testProdIdPropertyConformance() {
    
        // No exception thrown here means test passes
        $calendar = new Element\Component\VCalendar();
        $prodid = new Element\Property\ProdId();
        $calendar->addProperty($prodid);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('PRODID property cannot be defined for VTODO component.'));
        $todo = new Element\Component\VTodo();
        $prodid = new Element\Property\ProdId();
        $todo->addProperty($prodid);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
    
    }
    
    public function testRDatePropertyConformance() {
    
        // No exception thrown here means test passes
        $todo = new Element\Component\VTodo();
        $prop = new Element\Property\RDate();
        $todo->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('RDATE property cannot be defined for VCALENDAR component.'));
        $calendar = new Element\Component\VCalendar();
        $prop = new Element\Property\RDate();
        $calendar->addProperty($prop);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
    
    }
    
    public function testRRulePropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\RRule();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('RRULE property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\RRule();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testRRuleMultiplePropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\RRule();
        $cmpnt->addProperty($prop);
        $cmpnt->addProperty(clone $prop);
        $cmpnt->addProperty(clone $prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        $this->assertEqual(count($cmpnt->getProperties('RRULE')), 3);
        
        // DAYLIGHT and STANDARD can only have RRule defined once
        $this->expectException(new ConformanceException('RRULE property may only be defined once for DAYLIGHT component.'));
        $cmpnt = new Element\Component\Daylight();
        $prop = new Element\Property\RRule();
        $cmpnt->addProperty($prop);
        $cmpnt->addProperty(clone $prop);
        $cmpnt->addProperty(clone $prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
    
    }
    
    public function testRecurrenceIdPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\RecurrenceId();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('RECURRENCE-ID property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\RecurrenceId();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testRelatedToPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\RelatedTo();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('RELATED-TO property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\RelatedTo();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testRepeatPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VAlarm();
        $prop = new Element\Property\Repeat();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('REPEAT property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Repeat();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testRequestStatusPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\RequestStatus();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('REQUEST-STATUS property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\RequestStatus();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testResourcesPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\Resources();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('RESOURCES property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Resources();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testSequencePropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\Sequence();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('SEQUENCE property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Sequence();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testStatusPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\Status();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('STATUS property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Status();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testSummaryPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTodo();
        $prop = new Element\Property\Summary();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('SUMMARY property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Summary();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTranspPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VEvent();
        $prop = new Element\Property\Transp();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TRANSP property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Transp();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTriggerPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VAlarm();
        $prop = new Element\Property\Trigger('P15D');
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TRIGGER property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\Trigger('P15D');
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTZIDPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTimeZone();
        $prop = new Element\Property\TZID();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TZID property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\TZID();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTZNamePropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTimeZone();
        $prop = new Element\Property\TZName();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TZNAME property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\TZName();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTZOffsetFromPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTimeZone();
        $prop = new Element\Property\TZOffsetFrom();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TZOFFSETFROM property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\TZOffsetFrom();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTZOffsetToPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTimeZone();
        $prop = new Element\Property\TZOffsetTo();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TZOFFSETTO property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\TZOffsetTo();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testTZUrlPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VTimeZone();
        $prop = new Element\Property\TZUrl();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('TZURL property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\TZUrl();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testUIDPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VEvent();
        $prop = new Element\Property\UID();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('UID property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\UID();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testURLPropertyConformance() {
    
        // No exception thrown here means test passes
        $cmpnt = new Element\Component\VEvent();
        $prop = new Element\Property\URL();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $prop->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('URL property cannot be defined for VCALENDAR component.'));
        $cmpnt = new Element\Component\VCalendar();
        $prop = new Element\Property\URL();
        $cmpnt->addProperty($prop);
        $visitor = new Conf\Visitor();
        $cmpnt->accept($visitor);
    
    }
    
    public function testVersionPropertyConformance() {
    
        // No exception thrown here means test passes
        $calendar = new Element\Component\VCalendar();
        $version = new Element\Property\Version();
        $calendar->addProperty($version);
        $visitor = new Conf\Visitor();
        $calendar->accept($visitor);
        
        // Exception should be thrown for this
        $this->expectException(new ConformanceException('VERSION property cannot be defined for VTODO component.'));
        $todo = new Element\Component\VTodo();
        $version = new Element\Property\Version();
        $todo->addProperty($version);
        $visitor = new Conf\Visitor();
        $todo->accept($visitor);
    
    }

}
