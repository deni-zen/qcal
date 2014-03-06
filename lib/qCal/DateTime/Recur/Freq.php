<?php
/**
 * Date/Time Recurrence Frequency Class
 * Represents each of the types of recurrence frequency
 *
 * @package     qCal
 * @subpackage  qCal\DateTime\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\DateTime\Recur;
use \qCal\DateTime;

abstract class Freq {

    /**
     * Parent recur class injects itself
     */
    protected $recur;
    
    protected $interval;
    
    public function __construct($interval) {
    
        $this->setInterval($interval);
    
    }
    
    public function setRecur(\qCal\DateTime\Recur $recur) {
    
        $this->recur = $recur;
    
    }
    
    public function getRecur() {
    
        return $this->recur;
    
    }
    
    public function setInterval($interval) {
    
        $this->interval = $interval;
    
    }
    
    public function getInterval() {
    
        return $this->interval;
    
    }
    
    abstract public function getNextInterval(\qCal\DateTime $date);
    
    protected function getRulesArray() {
    
        return array(
            'byMonth' => $this->recur->getByMonth()->getForLoop(),
            'byMonthDay' => $this->recur->getByMonthDay()->getForLoop(),
            'byYearDay' => $this->recur->getByYearDay()->getForLoop(),
            'byDay' => $this->recur->getByDay()->getForLoop(),
            'byWeekNo' => $this->recur->getByWeekNo()->getForLoop(),
            'byHour' => $this->recur->getByHour()->getForLoop(),
            'byMinute' => $this->recur->getByMinute()->getForLoop(),
            'bySecond' => $this->recur->getBySecond()->getForLoop()
        );
    
    }

}
