<?php
/**
 * Unit Test Cases for qCal\Loader
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest;
use qCal\Loader;

class LoaderUnitTest extends \qCal\UnitTest\TestCase {

    /**
     * Load class by class name
     */
    public function testFileExists() {
    
        $this->assertTrue(Loader::fileExists('unit/qCal/LoaderUnitTest.php'));
    
    }
    
    public function testLoadFile() {
    
        $this->assertTrue(Loader::loadFile('unit/qCal/LoaderUnitTest.php'));
    
    }
    
    public function testLoadClass() {
    
        $this->assertTrue(Loader::loadClass('qCal\Loader'));
    
    }

}