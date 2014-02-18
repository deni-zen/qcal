<?php
/**
 * Priority Property
 * 
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Element\Property;

class Priority extends \qCal\Element\Property {

    protected $name = "PRIORITY";
    
    protected $type = "INTEGER";

    protected $default = "0";

}