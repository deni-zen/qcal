<?php
/**
 * Period Value
 */
namespace qCal\Value;
use \qCal\DateTime\Period as Per,
    \qCal\DateTime\Duration as Dur,
    \qCal\Datetime as DT,
    \qCal\Exception\Value\UnexpectedValueException;

class Period extends \qCal\Value {

    public function toString() {
    
        return sprintf("%s/%s", $this->value->getStart()->toUtc(), $this->value->getEnd()->toUtc());
    
    }
    
    /**
     * Cast from string to native qCal\Period object
     */
    protected function cast($value) {
    
        // period start/end is separated by a slash
        $dates = explode('/', $value);
        if (count($dates) != 2) {
            throw new UnexpectedValueException('Invalid format for Period type');
        }
        $start = new DT($dates[0]);
        
        try {
            // try creating a datetime with end date
            $end = new DT($dates[1]);
        } catch (\Exception $e) {
            // if not a datetime, maybe it's a duration
            try {
                $end = new Dur($dates[1]);
            } catch (DurationException $e) {
                // @todo throw proper exception here when I come back to test this
                throw new Exception('Invalid end date');
            }
        }
        return new Per($start, $end);
    
    }

}
