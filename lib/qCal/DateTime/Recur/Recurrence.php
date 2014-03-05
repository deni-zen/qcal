<?php
/**
 * Recurrence instance
 * For every recurrence in a recurrence rule, one of these objects is generated
 *
 * @package     qCal
 * @subpackage  qCal\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        Might be better to make this extend a time period since that's
 *              basically what it is. 
 */
namespace qCal\DateTime\Recur;
use \qCal\DateTime as DT;

class Recurrence {

    /**
     * @var \qCal\DateTime Object recurrence start time
     */
    protected $start;
    
    /**
     * Class constructor
     * Recurrence can have start and end date/time. Leave out end date/time to
     * represent a recurrence that just takes place at a certain date/time with 
     * no specified end date/time.
     * 
     * @param mixed Start date/time
     * @param mixed End date/time 
     */
    public function __construct($start, $end = null) {
    
        $this->setStart($start);
        if (!is_null($end)) {
            $this->setEnd($end);
        }
    
    }
    
    /**
     * Set start date/time
     * @param mixed Start date/time object or string
     * @return $this
     */
    public function setStart($start) {
    
        if (!($start instanceof DT)) {
            $start = new DT($start);
        }
        $this->start = $start;
    
    }
    
    /**
     * Get start date/time
     * @return \qCal\DateTime Start date/time
     */
    public function getStart() {
    
        return $this->start;
    
    }
    
    /**
     * Set end date/time
     * @param mixed End date/time object or string
     * @return $this
     */
    public function setEnd($end) {
    
        if (!($end instanceof DT)) {
            $end = new DT($end);
        }
        $this->end = $end;
    
    }
    
    /**
     * Get end date/time
     * @return \qCal\DateTime End date/time
     */
    public function getEnd() {
    
        return $this->end;
    
    }

}
