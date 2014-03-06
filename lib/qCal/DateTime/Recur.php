<?php
/**
 * Date/Time Recurrence Class
 * Allows user to specify a recurring date/time 
 *
 * @package     qCal
 * @subpackage  qCal\DateTime\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 * @todo        This class may not be needed
 */
namespace qCal\DateTime;
use \qCal\DateTime\Recur\Freq,
    \qCal\Loader;

class Recur {

    protected $until;
    
    protected $freq;
    
    protected $byDay;
    
    protected $byHour;
    
    protected $byMinute;
    
    protected $byMonth;
    
    protected $byMonthDay;
    
    protected $bySecond;
    
    protected $bySetPos;
    
    protected $byWeekNo;
    
    protected $byYearDay;
    
    /**
     * Class Constructor
     * @param qCal\DateTime Date of first recurrence in rule
     * @param integer The interval that this frequency should recur
     */
    public function __construct(\qCal\DateTime $start, Freq $freq) {
    
        $this->setStart($start);
        
        $this->byDay = new \qCal\DateTime\Recur\Rule\ByDay(null, $this);
        $this->byHour = new \qCal\DateTime\Recur\Rule\ByHour(null, $this);
        $this->byMinute = new \qCal\DateTime\Recur\Rule\ByMinute(null, $this);
        $this->byMonth = new \qCal\DateTime\Recur\Rule\ByMonth(null, $this);
        $this->byMonthDay = new \qCal\DateTime\Recur\Rule\ByMonthDay(null, $this);
        $this->bySecond = new \qCal\DateTime\Recur\Rule\BySecond(null, $this);
        $this->bySetPos = new \qCal\DateTime\Recur\Rule\BySetPos(null, $this);
        $this->byWeekNo = new \qCal\DateTime\Recur\Rule\ByWeekNo(null, $this);
        $this->byYearDay = new \qCal\DateTime\Recur\Rule\byYearDay(null, $this);
        
        $freq->setRecur($this);
        $this->setFreq($freq);
    
    }
    
    public function setFreq(Freq $freq) {
    
        $this->freq = $freq;
    
    }
    
    public function getFreq() {
    
        return $this->freq;
    
    }
    
    public function setStart(\qCal\DateTime $start) {
    
        $this->start = $start;
    
    }
    
    public function getStart() {
    
        return $this->start;
    
    }
    
    /**
     * This turns ByWeekNo into ByWeekno. Breaks shit.
     * Needs a class map
     */
    public function __call($name, $args) {
    
        // @todo Disabled until I implement class map
        // $name = strtolower($name);
        $type = ucfirst(substr($name, 5));
        $propName = 'by' . $type;
        if (strpos($name, 'setBy') === 0) {
        
            // if arg 1 is an array, use that. otherwise, use all args
            // this allows both
            // Recur::setByDay('SU', 'MO', '-1SA') and
            // Recur::setByDay(array('SU', 'MO', '-1SA'))
            $val = null;
            if (isset($args[0])) {
                $val = (is_array($args[0])) ? $args[0] : $args;
            }
            
            try {
                $class = 'qCal\\DateTime\\Recur\\Rule\\By' . $type;
                Loader::loadClass($class);
                $rule = new $class($val, $this);
                $this->$propName = $rule;
                return $this;
            } catch (FileNotFound $e) {
                // no rule exists
            }
        
        } elseif (strpos($name, 'getBy') === 0) {
        
            if (property_exists($this, $propName)) {
                return $this->$propName;
            }
            // no property exists
            
        }
        // method doesnt exist--throw exception
    
    }
    
    public function setUntil($until) {
    
        if (!($until instanceof \qCal\DateTime)) {
            $until = new \qCal\DateTime($until);
        }
        $this->until = $until;
        return $this;
    
    }
    
    public function getUntil() {
    
        return $this->until;
    
    }
    
    public function setCount() {
    
        return $this;
    
    }
    
    public function getCount() {
    
        
    
    }
    
    public function setWeekStart() {
    
        
    
    }
    
    public function getWeekStart() {
    
        
    
    }
    
    public function count() {
    
        $this->freq->getRecurrences();
        return $this;
    
    }
    
    /**
     * @todo This is just a temporary method used while I am writing the Freq
     *       classes
     */
    public function getRecurrences() {
    
        $start = $this->getStart();
        $date = clone $start;
        $freq = $this->getFreq();
        $i = 0;
        while (true) {
            if ($date->toUtc() > $this->getUntil()->toUtc()) break;
            $recs = $this->getFreq()->getRecurrences($date);
            if (!empty($recs)) pr(array_keys($recs));
            // pr(array_keys($recs));
            // pr($date->toUtc());
            $date = $freq->getNextInterval($date);
            
            $i++;
        }
    
    }
    
    protected function applyInterval(\qCal\DateTime $date) {
    

    
    }

}
