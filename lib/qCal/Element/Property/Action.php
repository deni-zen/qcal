<?php
/**
 * Action Property
 *
 * RFC 5545 Definition
 * 
 * Property Name: ACTION
 * 
 * Purpose: This property defines the action to be invoked when an alarm
 * is triggered.
 * 
 * Value Type: TEXT
 * 
 * Property Parameters: Non-standard property parameters can be
 * specified on this property.
 * 
 * Conformance: This property MUST be specified once in a "VALARM"
 * calendar component.
 * 
 * Description: Each "VALARM" calendar component has a particular type
 * of action associated with it. This property specifies the type of
 * action
 * 
 * Format Definition: The property is defined by the following notation:
 * 
 *   action	 = "ACTION" actionparam ":" actionvalue CRLF
 * 
 *   actionparam		= *(";" xparam)
 * 
 *   actionvalue		= "AUDIO" / "DISPLAY" / "EMAIL" / "PROCEDURE"
 *					  / iana-token / x-name
 * 
 * Example: The following are examples of this property in a "VALARM"
 * calendar component:
 * 
 *   ACTION:AUDIO
 * 
 *   ACTION:DISPLAY
 * 
 *   ACTION:PROCEDURE
 *
 * @package     qCal
 * @subpackage  qCal\Element\Property
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Property;

class Action extends \qCal\Element\Property {

    protected $name = "ACTION";
    
    protected $type = "TEXT";

}