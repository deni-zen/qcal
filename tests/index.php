<?php
/**
 * Unit Test Runner
 * Call this page with either a web browser or a CLI to run the entire suite of
 * unit tests for qCal.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Implement a machanism for selecting which components to run unit
 *              tests for. Once this library is finished, these tests may take a
 *              considerable amount of time to run. Especially during TDD
 *              sprints. Nobody wants to do TDD while having to wait several
 *              seconds or worse for every refresh.
 * @todo        Implement autoloader
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Include utility functions (mainly debugging tools and shortcuts)
require_once '../lib/utils/functions.php';

// Include simpletest classes
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

// Include library classes
require_once '../lib/Parser/Reader.php';
require_once '../lib/Parser/Lexer.php';
require_once '../lib/Parser/LexerState.php';

// Include unit test cases
require_once 'unit/qCal/TestCase.php';
require_once 'unit/qCal/Parser/Reader.php';
require_once 'unit/qCal/Parser/Lexer.php';
require_once 'unit/qCal/Parser/LexerState.php';

// Build test cases
$test = new GroupTest('qCal iCalendar Library Tests');
$test->addTestCase(new qCal\UnitTest\Parser\Reader);
$test->addTestCase(new qCal\UnitTest\Parser\Lexer);
$test->addTestCase(new qCal\UnitTest\Parser\LexerState);

// Determine which reporter to use and run tests
if (TextReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());