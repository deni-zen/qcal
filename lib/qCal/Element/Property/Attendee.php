<?php
/**
 * Attendee Property
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Property;

class Attendee extends \qCal\Element\Property {

    protected $name = "ATTENDEE";
    
    protected $type = "CAL-ADDRESS";

}