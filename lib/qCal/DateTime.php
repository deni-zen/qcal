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
 * @todo        Implement timezone support. As of now, this class supports
 *              timezones only insofar as PHP's DateTime class does. It doesn't
 *              have integrated support for timezones as far as the rest of the
 *              library goes. Because of this, qCal\DateTime\Period started
 *              calculating its conversion to a qCal\DateTime\Duration
 *              incorrectly when I switched from working from my iMac to working
 *              from my MacBook.
 *              For right now, just so that I can continue working on the lib,
 *              I have temporarily fixed the problem by setting the timezone to
 *              UTC. This doesn't actually fix anything, it just hides the
 *              problem. But it will work for now.
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