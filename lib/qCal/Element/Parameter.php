<?php
/**
 * qCal Parameter Class
 *
 * RFC 5545 Definition
 *
 * A property can have attributes with which it is associated.  These
 * "property parameters" contain meta-information about the property or
 * the property value.  Property parameters are provided to specify such
 * information as the location of an alternate text representation for a
 * property value, the language of a text property value, the value type
 * of the property value, and other attributes.

 * Property parameter values that contain the COLON, SEMICOLON, or COMMA
 * character separators MUST be specified as quoted-string text values.
 * Property parameter values MUST NOT contain the DQUOTE character.  The
 * DQUOTE character is used as a delimiter for parameter values that
 * contain restricted characters or URI text.  For example:
 * 
 *   DESCRIPTION;ALTREP="cid:part1.0001@example.org":The Fall'98 Wild
 *     Wizards Conference - - Las Vegas\, NV\, USA
 * 
 * Property parameter values that are not in quoted-strings are case-
 * insensitive.
 * 
 * The general property parameters defined by this memo are defined by
 * the following notation:
 * 
 *   icalparameter = altrepparam       ; Alternate text representation
 *                 / cnparam           ; Common name
 *                 / cutypeparam       ; Calendar user type
 *                 / delfromparam      ; Delegator
 *                 / deltoparam        ; Delegatee
 *                 / dirparam          ; Directory entry
 *                 / encodingparam     ; Inline encoding
 *                 / fmttypeparam      ; Format type
 *                 / fbtypeparam       ; Free/busy time type
 *                 / languageparam     ; Language for text
 *                 / memberparam       ; Group or list membership
 *                 / partstatparam     ; Participation status
 *                 / rangeparam        ; Recurrence identifier range
 *                 / trigrelparam      ; Alarm trigger relationship
 *                 / reltypeparam      ; Relationship type
 *                 / roleparam         ; Participation role
 *                 / rsvpparam         ; RSVP expectation
 *                 / sentbyparam       ; Sent by
 *                 / tzidparam         ; Reference to time zone object
 *                 / valuetypeparam    ; Property value data type
 *                 / other-param
 * 
 *   other-param   = (iana-param / x-param)
 * 
 *   iana-param  = iana-token "=" param-value *("," param-value)
 *   ; Some other IANA-registered iCalendar parameter.
 * 
 *   x-param     = x-name "=" param-value *("," param-value)
 *   ; A non-standard, experimental parameter.
 * 
 * Applications MUST ignore x-param and iana-param values they don't
 * recognize.
 *
 * @package     qCal
 * @subpackage  qCal\Element
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Some parameters allow multiple values (delimited by commas). Add
 *              a MultiParameter (name can be anything; MultiValueParameter,
 *              Parameter\MultiValue, etc.)
 */
namespace qCal\Element;
use \qCal\Loader;

abstract class Parameter extends \qCal\Element {

    /**
     * @var array Mapping of component names to class names
     * @todo I would prefer not to have to have a map, but I also don't want to
     *       have the ugly class names I had before. So this is fine for now.
     */
    static protected $parameterMap = array(
        'ALTREP'  => 'AltRep',
        'CN'  => 'CN',
        'CUTYPE'  => 'CUType',
        'DELEGATED-FROM'  => 'DelegatedFrom',
        'DELEGATED-TO'  => 'DelegatedTo',
        'DIR'  => 'Dir',
        'ENCODING'  => 'Encoding',
        'FBTYPE'  => 'FBType',
        'FMTTYPE'  => 'FmtType',
        'LANGUAGE'  => 'Language',
        'MEMBER'  => 'Member',
        'PARTSTAT'  => 'PartStat',
        'RANGE'  => 'Range',
        'RELATED'  => 'Related',
        'RELTYPE'  => 'RelType',
        'ROLE'  => 'Role',
        'RSVP'  => 'RSVP',
        'SENTBY'  => 'SentBy',
        'TZID'  => 'TZID',
        'VALUE'  => 'Value',
    );
    
    /**
     * @var string The parameter name
     */
    protected $name;
    
    /**
     * @var string The parameter's default value
     */
    protected $default;
    
    /**
     * @var string The parameter's value
     */
    protected $value;
    
    public function __construct($value) {
    
        $this->setValue($value);
    
    }
    
    static public function generate($name, $value) {
    
        try {
            $className = 'qCal\\Element\\Parameter\\' . self::$parameterMap[$name];
            Loader::loadClass($className);
            return new $className($value);
        } catch (FileNotFound $e) {
            // @todo create and throw this exception
            // throw new UndefinedParameterException($name . ' is not a known component type');
            throw new \Exception($name . ' is not a known parameter type');
        }
    
    }
    
    public function getName() {
    
        return $this->name;
    
    }
    
    public function getValue() {
    
        return $this->value;
    
    }
    
    public function setValue($value) {
    
        $this->value = $value;
    
    }

}
