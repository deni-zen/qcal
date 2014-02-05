<?php
/**
 * Unit Test Cases for qCal\Parser\Lexer
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest\Parser;
use \qCal\Parser;

class Context extends \qCal\UnitTest\TestCase {

    /**
     * Context class is a stack. Test that data can be oushed to the stack.
     */
    public function testPushAndPopResult() {
    
        $data = 'foobar';
        $context = new \qCal\Parser\Context();
        $context->push($data);
        $this->assertEqual($context->pop(), $data);
    
    }

}