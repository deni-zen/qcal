<?php
/**
 * Product Identifier Property Conformance
 *
 * RFC 5545 Definition
 *
 * Conformance: The property MUST be specified once in an iCalendar
 * object.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        The RFC mentions the value of this property being a globally
 *              unique identifier such as "FPI", defined by ISO 9070. I could
 *              not find much on this standard, but typing ISO 9070 did return
 *              this page in google:
 *              https://tools.ietf.org/id/draft-ietf-calsch-icalfpi-00.txt
 */
namespace qCal\Conformance\Property;
use \qCal\Element,
    \qCal\Exception\Conformance\Exception as ConformanceException;

class ProdId extends \qCal\Conformance\Property {

    /**
     * @var array A list of components the property is allowed to be defined on.
     */
    protected $allowedComponents = array('VCALENDAR');
    
    /**
     * Check that this property is conformant
     * @param qCal\Element\Property
     */
    public function conform(Element\Property\ProdId $property) {
    
        return parent::conform($property);
    
    }

}