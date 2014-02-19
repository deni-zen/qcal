<?php
/**
 * DateTime Duration Class
 * Duration is stored internally as an amount of seconds
 */
namespace qCal\DateTime;
use \qCal\Exception\DateTime\DurationException;

class Duration {

    /**
     * @var array
     * This is an array of conversions from weeks, days, hours and seconds into
     * seconds. Things like months and years aren't included here because they
     * are ambiguous. It is not possible to convert arbitrary months into
     * seconds because a month can be anywhere between 28 and 31 days. Years
     * also cannot be consistently converted into seconds.
     * IMPORTANT - don't change the order of these
     */
    protected static $conversions = array ('W' => 604800, 'D' => 86400, 'H' => 3600, 'M' => 60, 'S' => 1);
    
    /**
     * Duration (in seconds)
     */
    protected $duration = 0;
    
    public function __construct($duration) {
    
        if (!is_array($duration)) {
            $duration = $this->durationStringToArray($duration);
        }
        $this->setDuration($duration);
    
    }
    
    public function durationStringToArray($duration) {
    
        // match duration string elements
        if (!preg_match('/^P([0-9]+[W])?([0-9]+[D])?T?([0-9]+[H])?([0-9]+[M])?([0-9]+[S])?$/i', $duration, $matches)) {
            throw new DurationException("Invalid input string: \"$duration\"");
        }
        // remove first element (which is just entire the matched string)
        array_shift($matches);
        $ret = array();
        foreach ($matches as $elem) {
            $elem = strtoupper($elem);
            preg_match('/^([0-9]+)([WDHMS]+)$/', $elem, $match);
            if (empty($match)) continue;
            $amnt = $match[1];
            $type = $match[2];
            $ret[$type] = $amnt;
        }
        return $ret;
    
    }
    
    /**
     * Set the duration by array (see the constructor's comments for more info)
     * @param array $duration An array of time intervals such as "weeks", "hours", etc.
     * @param boolean $rollover Set to true to allow values to "rollover"
     * @return $this
     * @access protected
     */
    protected function setDuration($duration) {
    
        /*if (!is_array($duration)) {
            // @todo Create a custom Exception for this
            throw new DurationException("You need to provide an array with the right keys.");
            // $duration = array($duration);
        }*/
        $diff = array_diff_key($duration, self::$conversions);
        if (!empty($diff)) {
            throw new DurationException("Invalid input array");
        }
        $totalSeconds = 0;
        $posneg = "+";
        foreach (self::$conversions as $intvl => $seconds) {
            if (array_key_exists($intvl, $duration)) {
                $amnt = $duration[$intvl];
                $totalSeconds += self::$conversions[$intvl] * $amnt;
            }
        }
        $interval = (integer) ($posneg . $totalSeconds);
        $this->duration = $interval;
        return $this;
    
    }
    
    /**
     * Converts the internal storage (seconds) to iCal's duration format
     */
    public function toICal() {
    
        $total = $this->duration;
        if ($total < 0) {
            $total = abs($total);
            $interval = "-P";
        } else {
            $interval = "P";
        }
        // this is why order is important when defining self::$conversions
        foreach (self::$conversions as $dur => $amnt) {
            // how many "weeks" are in the value?
            $quotient = (int) ($total / $amnt);
            // get the remainder of the division
            $remainder = $total - ($quotient * $amnt);
            // now if we got a whole number as quotient, add this duration to the return string
            if ($quotient) {
                // if this is the first "time" duration, add the required T char
                if ($dur == "H" || $dur == "M" || $dur == "S") {
                    if (!strpos($interval, "T")) $interval .= "T";
                }
                $interval .= $quotient . $dur;
            }
            $total = $remainder;
        }
        return $interval;
    
    }
    
    /**
     * Get the duration in seconds, since that is the smallest possible unit of
     * time and it would make it possible to convert it to anything else.
     */
    public function toSeconds() {
    
        return $this->duration;
    
    }

}
