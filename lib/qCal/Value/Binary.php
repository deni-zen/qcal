<?php
/**
 * Binary Property Value
 * 
 * Allows for binary data to be included (inline) in an iCalendar file. By using
 * a base64 encoded character string, entire images or other typically binary
 * type files may be included within a text-based file format (iCalendar).
 * 
 * RFC 5545 Definition
 * 
 * Value Name: BINARY
 * 
 * Purpose: This value type is used to identify properties that contain
 * a character encoding of inline binary data. For example, an inline
 * attachment of an object code might be included in an iCalendar
 * object.
 * 
 * Formal Definition: The value type is defined by the following
 * notation:
 * 
 *   binary	 = *(4b-char) [b-end]
 *   ; A "BASE64" encoded character string, as defined by [RFC 2045].
 * 
 *   b-end	  = (2b-char "==") / (3b-char "=")
 * 
 *   b-char = ALPHA / DIGIT / "+" / "/"
 * 
 * Description: Property values with this value type MUST also include
 * the inline encoding parameter sequence of ";ENCODING=BASE64". That
 * is, all inline binary data MUST first be character encoded using the
 * "BASE64" encoding method defined in [RFC 2045]. No additional content
 * value encoding (i.e., BACKSLASH character encoding) is defined for
 * this value type.
 * 
 * Example: The following is an abridged example of a "BASE64" encoded
 * binary value data.
 * 
 *   ATTACH;VALUE=BINARY;ENCODING=BASE64:MIICajCCAdOgAwIBAgICBEUwDQY
 *	JKoZIhvcNAQEEBQAwdzELMAkGA1UEBhMCVVMxLDAqBgNVBAoTI05ldHNjYXBlI
 *	ENvbW11bmljYXRpb25zIENvcnBvcmF0aW9uMRwwGgYDVQQLExNJbmZv
 *	  <...remainder of "BASE64" encoded binary data...>
 * 
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Value;

class Binary extends \qCal\Value {

    public function toString() {
    
        return base64_encode($this->value);
    
    }
    
    protected function cast($value) {
    
        return $value;
    
    }

}
