<?php
/**
 * Property Conformance Exception
 * Thrown when a particular property doesn't conform to the RFC standard in some
 * way, whether that be that it has an invalid value, it is missing in special
 * circumstances, etc. This property differs from RequiredPropertyException in
 * that that exception is used solely for missing required property exceptions,
 * whereas this exception is used in special cases where a property is required
 * only in special circumstances.
 *
 * @package     qCal
 * @subpackage  qCal\Element
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Exception\Conformance;

class PropertyConformanceException extends Exception {

    

}