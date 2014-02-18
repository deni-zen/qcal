<?php
/**
 * Version Property
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Property;

class Version extends \qCal\Element\Property {

    protected $name = "VERSION";
    
    protected $type = "TEXT";

    protected $default = "2.0";

}