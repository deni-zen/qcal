<?php
/**
 * Base qCal Exception
 * 
 * @package     qCal
 * @subpackage  qCal\Element
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        The exceptions in this library are inconsistent and non-
 *              intuitive. Reorganize the library's exceptions into a more
 *              uniform and consistent structure. Each of the subpackages
 *              (Conformance, DateTime, Element, Value, and Parse) should have a
 *              namespace (and folder) under the qCal\Exception namespace
 *              (and folder). Each of those namespaces should have their own
 *              class named Exception, each extending qCal\Exception. More
 *              specific exceptions (UnexpectedValueException, for instance)
 *              should live in their respective folder under qcal/exception.
 *              All exception classes should have "Exception" as the last part
 *              of their name (UnknownTypeException, DurationException, etc.)
 */
namespace qCal;

class Exception extends \Exception {

    

}