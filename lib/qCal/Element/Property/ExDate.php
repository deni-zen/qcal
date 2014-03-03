<?php
/**
 * ExDate Property
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Property;

class ExDate extends \qCal\Element\Property\MultiValue {

    protected $name = "EXDATE";
    
    protected $type = "DATE-TIME";

}