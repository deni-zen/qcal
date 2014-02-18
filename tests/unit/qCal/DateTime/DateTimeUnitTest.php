<?php
/**
 * Unit Test Cases for DateTime class
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\DateTime;

class DateTimeUnitTest extends \qCal\UnitTest\TestCase {

    public function setUp() {
    
        
    
    }
    
    public function testDateTimeInstantiation() {
    
        $dt = new \qCal\DateTime('1390/04/23');
        //pre($dt->format('Y-m-d'));
    
    }

}