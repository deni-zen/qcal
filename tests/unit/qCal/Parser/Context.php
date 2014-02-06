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
     * Test data
     */
    protected $data = array(
        'foobar',
        'bar',
        'foo',
        'barfoo',
    );

    /**
     * Test context stack
     */
    protected $context;
    
    /**
     * Set up a test context stack
     */
    public function setUp() {
    
        parent::setUp();
        $this->context = with(new \qCal\Parser\Context())
            ->push($this->data[0])
            ->push($this->data[1])
            ->push($this->data[2])
            ->push($this->data[3]);
    
    }
    
    /**
     * Context class is a stack. Test that data can be oushed to the stack.
     */
    public function testPushAndPopResult() {
    
        $this->assertEqual($this->context->pop(), $this->data[3]);
        $this->assertEqual($this->context->pop(), $this->data[2]);
        $this->assertEqual($this->context->pop(), $this->data[1]);
        $this->assertEqual($this->context->pop(), $this->data[0]);
    
    }
    
    public function testCountResult() {
    
        $this->assertEqual($this->context->count(), 4);
        $data = $this->context->pop();
        $this->assertEqual($this->context->count(), 3);
    
    }
    
    /**
     * Take a look at the data at the top of the stack without popping it
     */
    public function testPeekResult() {
    
        $this->assertEqual($this->context->count(), 4);
        $this->assertEqual($this->context->peek(), $this->data[3]);
        $this->assertEqual($this->context->count(), 4);
    
    }
    
    /**
     * @todo Write custom exception for this
     */
    public function testPeekResultThrowsExceptionOnEmptyStack() {
    
        $empty = new \qCal\Parser\Context();
        $this->expectException(new \Exception('Empty context stack'));
        $empty->peek();
    
    }

}