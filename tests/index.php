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
 * @todo        This code is using SimpleTest v1.01, Update to v1.10
 * @todo        In a few cases, assertEqual() seems to be asserting equality
 *              when its arguments aren't equal. It is doing basically a boolean
 *              equality check. So that 1 == true, 'foo' == 'Object', etc. Find
 *              out why and fix it.
 *              
 */
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 'On');

// Set default timezone
// @todo There should probably be a qCal::setDefaultTimezone() method or
//       something that calls this function and also makes any other necessary
//       settings changes
date_default_timezone_set('UTC');

set_include_path(
    realpath(__DIR__ . '/../lib') . PATH_SEPARATOR .
    __DIR__ . PATH_SEPARATOR .
    get_include_path()
);

// Include utility functions (mainly debugging tools and shortcuts)
// @todo Test utility functions
require_once '../lib/autoload.php';
require_once '../lib/utils/functions.php';

// Include simpletest classes
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

// Include unit test cases
require_once 'unit/qCal/TestCase.php';
<<<<<<< HEAD
require_once 'unit/qCal/UtilityFunctionsUnitTest.php';
require_once 'unit/qCal/LoaderUnitTest.php';
require_once 'unit/qCal/ValueUnitTest.php';
=======
>>>>>>> parent of 33a101a... Added unit tests for utility functions
require_once 'unit/qCal/Parse/ReaderUnitTest.php';
require_once 'unit/qCal/Parse/LexerUnitTest.php';
require_once 'unit/qCal/Parse/LexerStateUnitTest.php';
require_once 'unit/qCal/DateTime/DateTimeUnitTest.php';
require_once 'unit/qCal/DateTime/DurationUnitTest.php';
require_once 'unit/qCal/DateTime/PeriodUnitTest.php';
require_once 'unit/qCal/Element/ComponentUnitTest.php';
require_once 'unit/qCal/Element/PropertyUnitTest.php';
require_once 'unit/qCal/Element/ParameterUnitTest.php';

// Build test cases
$test = new GroupTest('qCal iCalendar Library Tests');
<<<<<<< HEAD
$test->addTestCase(new qCal\UnitTest\LoaderUnitTest);
$test->addTestCase(new qCal\UnitTest\ValueUnitTest);
$test->addTestCase(new qCal\UnitTest\UtilityFunctionsUnitTest);
=======
>>>>>>> parent of 33a101a... Added unit tests for utility functions
$test->addTestCase(new qCal\UnitTest\Parse\ReaderUnitTest);
$test->addTestCase(new qCal\UnitTest\Parse\LexerUnitTest);
$test->addTestCase(new qCal\UnitTest\Parse\LexerStateUnitTest);
$test->addTestCase(new qCal\UnitTest\DateTime\DateTimeUnitTest);
$test->addTestCase(new qCal\UnitTest\DateTime\DurationUnitTest);
$test->addTestCase(new qCal\UnitTest\DateTime\PeriodUnitTest);
$test->addTestCase(new qCal\UnitTest\Element\ComponentUnitTest);
$test->addTestCase(new qCal\UnitTest\Element\PropertyUnitTest);
$test->addTestCase(new qCal\UnitTest\Element\ParameterUnitTest);

// Determine which reporter to use and run tests
if (TextReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());
