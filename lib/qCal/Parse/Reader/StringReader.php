<?php
/**
 * iCalendar String Reader
 * Reads iCalendar data directly from a string
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parse\Reader;

class StringReader extends \qCal\Parse\Reader {

    protected $data;

    public function __construct($data) {
    
        $this->data = (string) $data;
    
    }
    
    public function getChar() {
    
        $char = substr($this->data, $this->pos, 1);
        $this->pos++;
        return $char;
    
    }

}
