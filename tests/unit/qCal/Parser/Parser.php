<?php
/**
 * Unit Test Cases for qCal\Parser\Parser
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Parser;
use \qCal\Parser;

class ParserTests extends \qCal\UnitTest\TestCase {

    /**
     * Set up a test context stack
     */
    public function setUp() {
    
        parent::setUp();
    
    }
    
    public function testParserPlayground() {
    
        $reader = new Parser\Reader\File('/var/www/qcal/tests/data/bastille-day.ics');
        $lexer = new Parser\Lexer($reader);
        
    
    }

}