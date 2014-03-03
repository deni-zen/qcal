<?php
/**
 * Calendar User Address Property Value
 *
 * RFC 5545 Definition
 * 
 * Value Name: CAL-ADDRESS
 * 
 * Purpose: This value type is used to identify properties that contain
 * a calendar user address.
 * 
 * Formal Definition: The value type is as defined by the following
 * notation:
 * 
 *  cal-address		= uri
 * 
 * Description: The value is a URI as defined by [RFC 1738] or any other
 * IANA registered form for a URI. When used to address an Internet
 * email transport address for a calendar user, the value MUST be a
 * MAILTO URI, as defined by [RFC 1738]. No additional content value
 * encoding (i.e., BACKSLASH character encoding) is defined for this
 * value type.
 * 
 * Example:
 * 
 *  ATTENDEE:MAILTO:jane_doe@host.com
 * 
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Address and implement any functionality for this value type that isn't
 *              already addressed by qCal\Value\Uri
 */
namespace qCal\Value;

class CalAddress extends Uri {

    

}
