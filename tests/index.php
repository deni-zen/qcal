<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//phpinfo();
//exit;

/**
 * qCal Unit Test Web Runner
 * This is simply a browser-based frontend to run qCal's unit tests.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */

require_once '../lib/utils/functions.php';
// Load files manually for now... build autoloader later when you know exactly what you need

// require_once 'autoloader.php';

/**
 * Temporary class loading. These will go away once I write my autoloader
 */

// include simpletest classes
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

require_once '../lib/Parser/Reader.php';
require_once '../lib/Parser/Lexer.php';
require_once '../lib/Parser/LexerState.php';

require_once 'unit/qCal/TestCase.php';
require_once 'unit/qCal/Parser/Reader.php';
require_once 'unit/qCal/Parser/Lexer.php';
require_once 'unit/qCal/Parser/LexerState.php';

/**
 * @todo Encapsulate test runner into its own little class
 */
// run tests in html reporter
$test = new GroupTest('qCal iCalendar Library Tests');
$test->addTestCase(new qCal\UnitTest\Parser\Reader);
$test->addTestCase(new qCal\UnitTest\Parser\Lexer);
$test->addTestCase(new qCal\UnitTest\Parser\LexerState);

if (TextReporter::inCli()) {
    exit ($test->run(new TextReporter()) ? 0 : 1);
}
$test->run(new HtmlReporter());
