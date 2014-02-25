<?php
/**
 * Delegators Property Parameter
 *
 * RFC 5545 Definition
 *
 * Parameter Name:  DELEGATED-FROM
 * 
 * Purpose:  To specify the calendar users that have delegated their
 *    participation to the calendar user specified by the property.
 * 
 * Format Definition:  This property parameter is defined by the
 *    following notation:
 * 
 *     delfromparam       = "DELEGATED-FROM" "=" DQUOTE cal-address
 *                           DQUOTE *("," DQUOTE cal-address DQUOTE)
 * 
 * Description:  This parameter can be specified on properties with a
 *    CAL-ADDRESS value type.  This parameter specifies those calendar
 *    users that have delegated their participation in a group-scheduled
 *    event or to-do to the calendar user specified by the property.
 *    The individual calendar address parameter values MUST each be
 *    specified in a quoted-string.
 * 
 * Example:
 * 
 *     ATTENDEE;DELEGATED-FROM="mailto:jsmith@example.com":mailto:
 *      jdoe@example.com
 * 
 * @package     qCal
 * @subpackage  qCal\Element\Parameter
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Parameter;

class DelegatedFrom extends \qCal\Element\Parameter {

    protected $name = "DELEGATED-FROM";

}
