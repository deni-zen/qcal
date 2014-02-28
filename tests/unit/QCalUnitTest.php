<?php
/**
 * qCal Wrapper Unit Tests
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest;
use \qCal,
    \qCal\Conformance as Conf,
    \qCal\Element;

class QCalUnitTest extends \qCal\UnitTest\TestCase {

    public function testAddCalendar() {
    
        $cal = new qCal();
        $vcal = new Element\Component\VCalendar();
        $cal->addCalendar($vcal);
        $this->assertEqual($cal->getCalendars(), array($vcal));
    
    }

}
