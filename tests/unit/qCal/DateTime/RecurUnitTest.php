<?php
/**
 * Unit Test Cases for recurrence rules
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\DateTime;
use \qCal\DateTime as DT,
    \qCal\DateTime\Recur;

class RecurUnitTest extends \qCal\UnitTest\TestCase {

    public function setUp() {
    
        
    
    }
    
    public function testFreqYearly() {
    
        $start = new DT('20080423');
        $yrly = new Recur\Freq\Yearly(4);
        $recur = new Recur($start, $yrly);
        $recur->setByMonth(5)
              ->setByMonthDay(array(23, -10))
              ->setByWeekNo(array(10, 20, 30, -10, -20))
              ->setByDay('SA')
              ->setByYearDay(15)
              ->setByHour(5, 10, 15, 20)
              ->setUntil('now');
        $recur->getRecurrences(); // should be 27
    
    }
    
    /*public function testFreqMonthly() {
    
        $start = new DT('20100423');
        $yrly = new Recur\Freq\Monthly(2);
        $recur = new Recur($start, $yrly);
        $recur//->setByMonth(4, 5,-3)
              ->setByMonthDay(23, -10) 
              //->setByWeekNo(array(10, 20, 30, -10, -20))
              ->setByDay('SA','1SU','-2TH')
              //->setByYearDay(15)
              //->setByHour(5, 10, 15, 20)
              ->setUntil('now');
        $recur->getRecurrences(); 
    
    }*/

}