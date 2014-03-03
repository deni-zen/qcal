<?php
/**
 * Property Element
 *
 * RFC 5545 Definition
 *
 * A property is the definition of an individual attribute describing a
 * calendar or a calendar component. A property takes the form defined
 * by the "contentline" notation defined in section 4.1.1.
 * 
 * The following is an example of a property:
 * 
 *  DTSTART:19960415T133000Z
 * 
 * This memo imposes no ordering of properties within an iCalendar
 * object.
 * 
 * Property names, parameter names and enumerated parameter values are
 * case insensitive. For example, the property name "DUE" is the same as
 * "due" and "Due", DTSTART;TZID=US-Eastern:19980714T120000 is the same
 * as DtStart;TzID=US-Eastern:19980714T120000.
 * 
 * @package     qCal
 * @subpackage  qCal\Element
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Some properties allow multiple values (delimited by commas). Add
 *              a MultiProperty (name can be anything; MultiValueProperty,
 *              Property\MultiValue, etc.)
 */
namespace qCal\Element;
use \qCal\Value,
    \qCal\Element\Parameter;

abstract class Property extends \qCal\Element {

    /**
     * @var array Mapping of property names to class names
     * @todo I would prefer not to have to have a map, but I also don't want to
     *       have the ugly class names I had before. So this is fine for now.
     */
    static protected $propertyMap = array(
        'ACTION'            => 'Action',
        'ATTACH'            => 'Attach',
        'ATTENDEE'          => 'Attendee',
        'CALSCALE'          => 'CalScale',
        'CATEGORIES'        => 'Categories',
        'CLASS'             => 'Classification',
        'COMMENT'           => 'Comment',
        'COMPLETED'         => 'Completed',
        'CONTACT'           => 'Contact',
        'CREATED'           => 'Created',
        'DESCRIPTION'       => 'Description',
        'DTEND'             => 'DtEnd',
        'DTSTAMP'           => 'DtStamp',
        'DTSTART'           => 'DtStart',
        'DUE'               => 'Due',
        'DURATION'          => 'Duration',
        'EXDATE'            => 'ExDate',
        'EXRULE'            => 'ExRule',
        'FREEBUSY'          => 'FreeBusy',
        'GEO'               => 'Geo',
        'LAST-MODIFIED'     => 'LastModified',
        'LOCATION'          => 'Location',
        'METHOD'            => 'Method',
        'ORGANIZER'         => 'Organizer',
        'PERCENT-COMPLETE'  => 'PercentComplete',
        'PRIORITY'          => 'Priority',
        'PRODID'            => 'ProdId',
        'RDATE'             => 'RDate',
        'RECURRENCE-ID'     => 'RecurrenceId',
        'RELATED-TO'        => 'RelatedTo',
        'REPEAT'            => 'Repeat',
        'REQUEST-STATUS'    => 'RequestStatus',
        'RESOURCES'         => 'Resources',
        'RRULE'             => 'RRule',
        'SEQUENCE'          => 'Sequence',
        'STATUS'            => 'Status',
        'SUMMARY'           => 'Summary',
        'TRANSP'            => 'Transp',
        'TRIGGER'           => 'Trigger',
        'TZID'              => 'TZID',
        'TZNAME'            => 'TZName',
        'TZOFFSETFROM'      => 'TZOffsetFrom',
        'TZOFFSETTO'        => 'TZOffsetTo',
        'TZURL'             => 'TZUrl',
        'UID'               => 'UID',
        'URL'               => 'URL',
        'VERSION'           => 'Version',
    );
    
    /**
     * Property Name
     * @var string The RFC5545-designated property name
     */
    protected $name;
    
    /**
     * Property Value
     * @var string The property value
     */
    protected $value;
    
    /**
     * Default property value
     * @var string The RFC5545-designated property default value
     */
    protected $default;
    
    /**
     * Property Type
     * @var string The RFC5545-designated property type
     */
    protected $type;
    
    /**
     * Property Params
     * @var array A list of property parameters
     */
    protected $params = array();
    
    /**
     * Class constructor
     * @param string The property value
     * @param array A list of property parameters
     */
    public function __construct($value = null, $params = array()) {
    
        foreach ($params as $pname => $pval) {
            if (!($pval instanceof Parameter)) {
                $pval = Parameter::generate($pname, $pval);
            } else {
                $pname = $pval->getName();
            }
            $this->setParam($pname, $pval);
        }
        $this->setValue($value);
    
    }
    
    /**
     * Generate property from string
     * @param string The value to generate the property from
     * @return qCal\Element\Property Property populated with the value passed in
     */
    static public function generate($name, $value) {
    
        try {
            $className = 'qCal\\Element\\Property\\' . self::$propertyMap[$name];
            \qCal\Loader::loadClass($className);
            return new $className($value);
        } catch (FileNotFound $e) {
            // @todo is this the right exception?
            throw new UndefinedException($name . ' is not a known property type');
        }
    
    }
    
    /**
     * Get the property name
     * @return string The property name 
     */
    public function getName() {
    
        return $this->name;
    
    }
    
    /**
     * Set a property param
     * @param string Parameter name
     * @param string Parameter value
     * @return $this
     */
    public function setParam($name, $value) {
    
        $name = strtoupper($name);
        $this->params[$name] = $value;
        return $this;
    
    }
    
    /**
     * Get a param by name
     * @param string The parameter name to retrieve
     * @return string The parameter
     */
    public function getParam($name) {
    
        $name = strtoupper($name);
        if ($this->hasParam($name)) {
            return $this->params[$name];
        }
        // @todo Throw exception?
        return null;
    
    }
    
    /**
     * Get all params
     * @return array All property params
     */
    public function getParams() {
    
        return $this->params;
    
    }
    
    /**
     * Check if property has paramaters
     */
    public function hasParams() {
    
        return !empty($this->params);
    
    }
    
    /**
     * Check if property has a specific parameter
     * @param string Parameter name
     * @return boolean True if property has parameter set
     */
    public function hasParam($name) {
    
        return array_key_exists($name, $this->params);
    
    }
    
    /**
     * Set property value
     * @param string The property value
     * @return $this
     */
    public function setValue($value) {
    
        if (is_null($value)) {
            $value = $this->default;
        }
        $this->value = Value::generate($this->type, $value);
        return $this;
    
    }
    
    /**
     * Get this property's value
     * @return qCal\Value The property value
     */
    public function getValue() {
    
        return $this->value;
    
    }
    
    /**
     * Get this property's value as a string
     * @todo This isn't right. Converting this to a string should include the name and params
     */
    public function __toString() {
    
        return $this->value->__toString();
    
    }
    
    /**
     * Get this property's type
     * @return string Property type
     */
    public function getType() {
    
        return $this->type;
    
    }

}