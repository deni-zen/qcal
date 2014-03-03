<?php
/**
 * Time Zone Class
 *
 * @package     qCal
 * @subpackage  qCal\DateTime
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\DateTime;

class TimeZone {

    /**
     * Time Zone Identifier
     * Used throughout library to reference this particular time zone
     * @var string identifier
     */
    protected $id;
    
    /**
     * Class Constructor
     * Sets the time zone identifier
     * @param string Time zone identifier
     */
    public function __construct($id) {
    
        $this->setId($id);
    
    }
    
    public function setId($id) {
    
        $this->id = $id;
    
    }
    
    public function getId() {
    
        return $this->id;
    
    }

}
