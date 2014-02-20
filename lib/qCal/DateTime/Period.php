<?php
/**
 * Period
 * A period represents a period of time spanning from one date/time to another
 */
namespace qCal\DateTime;
use \qCal\DateTime,
    \qCal\DateTime\Duration,
    \qCal\Exception\DateTime\DurationException;

class Period {

    protected $start;
    
    protected $end;
    
    public function __construct(DateTime $start, $end) {
    
        if (!$end instanceof DateTime) {
            if (!$end instanceof Duration) {
                throw new DurationException("Second argument of qCal\DateTime\Period::__construct() must be one of either qCal\DateTime\Period or qCal\DateTime\Duration");
            }
            $endTs = $start->getTimestamp() + $end->toSeconds();
            $end = DateTime::createFromFormat('U', $endTs);
        }
        if ($start->getTimestamp() > $end->getTimestamp()) {
            throw new DurationException('Cannot create negative time period');
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

}
