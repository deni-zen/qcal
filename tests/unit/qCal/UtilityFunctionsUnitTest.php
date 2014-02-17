<?php
/**
 * Unit Test Cases for lib/utils/functions.php
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\UnitTest;

class UtilityFunctionsUnitTest extends \qCal\UnitTest\TestCase {

    public function testPre() {
    
        $var = array('foo' => 'bar');
        ob_start();
        pre($var, false); // Cannot test exit() because it will kill the script
        $output = ob_get_clean();
        $expectedOutput = <<<EXPECTED
<pre>array(1) {
  ["foo"]=>
  string(3) "bar"
}
</pre>
EXPECTED;
        $this->assertIdentical($output, $expectedOutput);
    
    }
    
    public function testPr() {
    
        $var = array('foo' => 'bar');
        ob_start();
        pr($var);
        $output = ob_get_clean();
        $expectedOutput = <<<EXPECTED
<pre>array(1) {
  ["foo"]=>
  string(3) "bar"
}
</pre>
EXPECTED;
        $this->assertIdentical($output, $expectedOutput);
    
    }
    
    public function testPrReturn() {
    
        $var = array('foo' => 'bar');
        $output = pr($var, true);
        $expectedOutput = <<<EXPECTED
<pre>array(1) {
  ["foo"]=>
  string(3) "bar"
}
</pre>
EXPECTED;
        $this->assertIdentical($output, $expectedOutput);
    
    }
    
    public function testWith() {
    
        $object = new \DateTime();
        $this->assertIdentical(with($object), $object);
    
    }

}