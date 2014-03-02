<?php
/**
 * Allowed parent component exception
 * Thrown when a component is added to a component it isn't allowed on.
 *
 * @package     qCal
 * @subpackage  qCal\Conformance
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        I think all this functionality in this exception isn't worth the
 *              trouble. Probably should just get rid of it.
 */
namespace qCal\Exception\Conformance;

class AllowedParentException extends Exception {

    

}