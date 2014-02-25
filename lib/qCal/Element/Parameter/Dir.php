<?php
/**
 * Directory Entry Reference Property Parameter
 *
 * RFC 5545 Definition
 *
 * Parameter Name:  DIR
 * 
 * Purpose:  To specify reference to a directory entry associated with
 *    the calendar user specified by the property.
 * 
 * Format Definition:  This property parameter is defined by the
 *    following notation:
 * 
 *     dirparam   = "DIR" "=" DQUOTE uri DQUOTE
 * 
 * Description:  This parameter can be specified on properties with a
 *    CAL-ADDRESS value type.  The parameter specifies a reference to
 *    the directory entry associated with the calendar user specified by
 *    the property.  The parameter value is a URI.  The URI parameter
 *    value MUST be specified in a quoted-string.
 * 
 *       Note: While there is no restriction imposed on the URI schemes
 *       allowed for this parameter, CID [RFC2392], DATA [RFC2397], FILE
 *       [RFC1738], FTP [RFC1738], HTTP [RFC2616], HTTPS [RFC2818], LDAP
 *       [RFC4516], and MID [RFC2392] are the URI schemes most commonly
 *       used by current implementations.
 * 
 * Example:
 * 
 *     ORGANIZER;DIR="ldap://example.com:6666/o=ABC%20Industries,
 *      c=US???(cn=Jim%20Dolittle)":mailto:jimdo@example.com
 * 
 * @package     qCal
 * @subpackage  qCal\Element\Parameter
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Parameter;

class Dir extends \qCal\Element\Parameter {

    protected $name = "DIR";

}
