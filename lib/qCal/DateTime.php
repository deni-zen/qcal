<?php
/**
 * qCal DateTime Class
 * Since PHP v5.2, the DateTime class allows dates without the limitations that
 * were a problem in the past. This DateTime class is simply an extension of the
 * built-in DateTime class in PHP.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @note        Requires PHP v5.2+
 */
namespace qCal;
 
class DateTime extends \DateTime {

    /**
     * Return date/time as UTC
     * @todo Make sure this is always right no matter the timezone
     */
    public function toUtc() {
    
        return $this->format('Ymd\THis\Z');
    
    }

}