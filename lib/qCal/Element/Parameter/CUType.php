<?php
/**
 * Calendar User Type
 *
 * RFC 5545 Definition
 *
 * Parameter Name:  CUTYPE
 * 
 * Purpose:  To identify the type of calendar user specified by the
 *    property.
 * 
 * Format Definition:  This property parameter is defined by the
 *    following notation:
 * 
 *     cutypeparam        = "CUTYPE" "="
 *                        ("INDIVIDUAL"   ; An individual
 *                       / "GROUP"        ; A group of individuals
 *                       / "RESOURCE"     ; A physical resource
 *                       / "ROOM"         ; A room resource
 *                       / "UNKNOWN"      ; Otherwise not known
 *                       / x-name         ; Experimental type
 *                       / iana-token)    ; Other IANA-registered
 *                                        ; type
 *     ; Default is INDIVIDUAL
 * 
 * Description:  This parameter can be specified on properties with a
 *    CAL-ADDRESS value type.  The parameter identifies the type of
 *    calendar user specified by the property.  If not specified on a
 *    property that allows this parameter, the default is INDIVIDUAL.
 *    Applications MUST treat x-name and iana-token values they don't
 *    recognize the same way as they would the UNKNOWN value.
 * 
 * Example:
 * 
 *     ATTENDEE;CUTYPE=GROUP:mailto:ietf-calsch@example.org
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
    
    protected $default = "INDIVIDUAL";

}
