<?php
/**
 * Common Name Property Parameter
 *
 * RFC 5545 Definition
 *
 * Parameter Name:  CN
 * 
 * Purpose:  To specify the common name to be associated with the
 *    calendar user specified by the property.
 * 
 * Format Definition:  This property parameter is defined by the
 *    following notation:
 * 
 *   cnparam    = "CN" "=" param-value
 * 
 * Description:  This parameter can be specified on properties with a
 *    CAL-ADDRESS value type.  The parameter specifies the common name
 *    to be associated with the calendar user specified by the property.
 *    The parameter value is text.  The parameter value can be used for
 *    display text to be associated with the calendar address specified
 *    by the property.
 * 
 * Example:
 * 
 *     ORGANIZER;CN="John Smith":mailto:jsmith@example.com
 * 
 * @package     qCal
 * @subpackage  qCal\Element\Parameter
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Parameter;

class CN extends \qCal\Element\Parameter {

    protected $name = "CN";

}
