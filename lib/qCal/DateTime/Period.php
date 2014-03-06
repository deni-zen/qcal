<?php
/**
 * Period
 * A period represents a period of time spanning from one date/time to another
 */
namespace qCal\DateTime;
use \qCal\DateTime as DT,
    \qCal\DateTime\Duration,
    \qCal\Exception\DateTime\DurationException,
    \qCal\Exception\DateTime\PeriodException;

class Period {

    protected $start;
    
    protected $end;
    
    public function __construct($start, $end) {
    
        if (!($start instanceof DT)) {
            $start = new DT($start);
        }
        if (!($end instanceof DT)) {
            if ($end instanceof Duration) {
                $endTs = $start->getTimestamp() + $end->toSeconds();
                $end = new DT('@' . $endTs);
            } else {
                $end = new DT($end);
            }
        }
        if ($start->getTimestamp() > $end->getTimestamp()) {
            throw new PeriodException('Cannot create negative time period');
        }
        $this->start = $start;
        $this->end = $end;
    
    }
    
    public function getDiffInSeconds() {
    
        return $this->end->getTimestamp() - $this->start->getTimestamp();
    
    }
    
    public function getDuration() {
    
        return new Duration(array('S' => $this->getDiffInSeconds()));
    
    }
    
    public function getStart() {
    
        return $this->start;
    
    }
    
    public function getEnd() {
    
        return $this->end;
    
    }
    
    public function toICal() {
    
        return sprintf('%s/%s', $this->start->toUtc(), $this->end->toUtc());
    
    }

}
