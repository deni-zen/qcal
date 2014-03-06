<?php
/**
 * Recurrence Iterator
 * Allows user to treat a range of recurrences as an iterator.
 *
 * @package     qCal
 * @subpackage  qCal\DateTime\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\DateTime\Recur;
use \qCal\DateTime as DT;

class Iterator implements \Iterator {

    /**
     * Position within current recurrence array
     */
    protected $pos = 0;
    
    /**
     * Range of date/times that this iterator will loop through
     */
    protected $range;
    
    /**
     * Current date position
     */
    protected $date;
    
    /**
     * Recurrence rule
     */
    protected $recur;
    
    /**
     * If recurrence count is set, use this
     */
    protected $count = 0;
    
    /**
     * How many recurrences have been returned
     */
    protected $returned = 0;
    
    /**
     * Class constructor
     */
    public function __construct(\qCal\DateTime\Recur $recur, $end) {
    
        if ($end instanceof DT) {
            $this->range = new DT\Period($recur->getStart(), $end);
        } elseif ($end instanceof DT\Period) {
            $this->range = $end;
        } elseif (!is_null($end)) {
            $this->range = new DT\Period($recur->getStart(), new DT($end));
        } else {
            if ($until = $recur->getUntil()) {
                $this->range = new DT\Period($recur->getStart(), $until);
            }
            if (!$count = $recur->getCount()) {
                // throw exception because iterator goes on forever
                
            }
        }
        $this->count = $recur->getCount();
        $this->recur = $recur;
        $this->init();
    
    }
    
    protected function init() {
    
        $this->rewind();
        //$this->date = $this->range->getStart();
        //$this->recurrences = $this->loadRecurrences($this->date);
    
    }
    
    public function loadRecurrences(DT $date) {
    
        while ($date->toUtc() < $this->range->getEnd()->toUtc()) {
            $recurrences = $this->recur->getFreq()->getRecurrences($date);
            if (!empty($recurrences)) {
                return $recurrences;
            }
            $date = $this->recur->getFreq()->getNextInterval($date);
        }
        return array();
    
    }
    
    public function rewind() {
    
        $this->returned = 0;
        $this->pos = 0;
        $this->date = $this->range->getStart();
        $this->recurrences = $this->loadRecurrences($this->date);
    
    }
    
    public function current() {
    
        return $this->recurrences[$this->pos];
    
    }
    
    public function key() {
    
        return $this->recurrences[$this->pos]->getId();
    
    }
    
    public function next() {
    
        $this->returned++;
        $this->pos++;
        if (!isset($this->recurrences[$this->pos])) {
            $this->pos = 0;
            $this->date = $this->recur->getFreq()->getNextInterval($this->date);
            $this->recurrences = $this->loadRecurrences($this->date);
        }
    
    }
    
    public function valid() {
    
        if ($this->count) {
            if ($this->returned >= $this->count) return false;
        }
        return isset($this->recurrences[$this->pos]);
    
    }

}