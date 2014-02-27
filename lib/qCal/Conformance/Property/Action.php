<?php
/**
 * Action Property Conformance
 * The action property is conformance-checked by this class.
 *
 * RFC 5545 Definition
 *
 * Conformance: This  property MUST be specified once in a "VALARM"
 * calendar component.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class Action extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VALARM');
    
    /**
     * Check that action property is conformant
     * @param qCal\Element\Property
     * @todo As far as I can tell, since the conformance definition for this
     *       property is so vague, the only component this property is allowed
     *       to be defined for is the VALARM component. Other than that, there
     *       doesn't appear to be any other conformance rules. It is a required
     *       property for the VALARM component, but that seems to be more a
     *       conformance rule for VALARM than for ACTION.
     * @todo It may be a good idea to have this method throw more specific
     *       exceptions, but for now, rather than have it throw unnecessarily
     *       specific exceptions, I'll stick with the one generic exception.
     * @todo Check into whether the value of this property must be one of a list
     *       of choices and figure out whether you want to check the value as a
     *       conformance rule.
     */
    public function conform(Element\Property\Action $property) {
    
        return parent::conform($property);
    
    }

}