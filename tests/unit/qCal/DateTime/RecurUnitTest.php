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
    
    /*public function testFreqYearly() {
    
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
    
    public function testFreqMonthly() {
    
        $start = new DT('20100423');
        $monthly = new Recur\Freq\Monthly(2);
        $recur = new Recur($start, $monthly);
        $recur//->setByMonth(4, 5,-3)
              ->setByMonthDay(23, -10) 
              //->setByWeekNo(array(10, 20, 30, -10, -20))
              ->setByDay('SA','1SU','-2TH')
              //->setByYearDay(15)
              //->setByHour(5, 10, 15, 20)
              ->setUntil('now');
        $recur->getRecurrences(); 
    
    }
    
    public function testFreqDaily() {
    
        $start = new DT('20100423');
        $daily = new Recur\Freq\Daily(2); // every other day
        $recur = new Recur($start, $daily);
        $recur->setByMonth(1, 2, 3, 4, 5, 6, 7, 8, 9, 10) // every other day in jan, feb, and march
              ->setByMonthDay(1, 2, 3, 10, 23, -10) // but only if it falls on the 23rd or the 10th to last day of the month
              //->setByWeekNo(array(10, 20, 30, -10, -20))
              ->setByDay('SA') // and only if it falls on a saturday
              //->setByYearDay(15)
              ->setByHour(5, 10, 15, 20)
              ->setUntil('now'); // until now
        $recur->getRecurrences(); 
    
    }*/
    
    public function testFreqWeekly() {
    
        $start = new DT('20100423');
        $weekly = new Recur\Freq\Weekly(4); // every other week
        $recur = new Recur($start, $weekly);
        $recur->setByMonth(1, 2, 3) // every other week in jan, feb, and march
              //->setByMonthDay(1, 2, 3, 10, 23, -10) // but only if it falls on the 23rd or the 10th to last day of the month
              //->setByWeekNo(array(10, 20, 30, -10, -20))
              ->setByDay('SA','SU') // every saturday and sunday of every other week
              //->setByYearDay(15)
              ->setByHour(5, 10, 15, 20)
              ->setUntil('now'); // until now
        $recur->getRecurrences(); 
    
    }

}