<?php
/**
 * qCal\Element\Parameter unit tests
 */
namespace qCal\UnitTest\Element;
use \qCal\Element\Component,
    \qCal\Element\Property,
    \qCal\Element\Parameter;

class ParameterUnitTest extends \qCal\UnitTest\TestCase {

    public function testParameterWorks() {
    
        $trigger = new Property\Trigger('-PT10M', array('RELATED' => 'END'));
        $alarm = new Component\VAlarm(array('TRIGGER' => $trigger));
        //pcom($alarm);
    
    }

}