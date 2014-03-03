<?php
/**
 * Period Property Value
 *
 * RFC 5545 Definition                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         * RFC 5545 Definition
 * 
 * Value Name: PERIOD
 * 
 * Purpose: This value type is used to identify values that contain a
 * precise period of time.
 * 
 * Formal Definition: The data type is defined by the following
 * notation:
 * 
 *   period	 = period-explicit / period-start
 * 
 *   period-explicit = date-time "/" date-time
 *   ; [ISO 8601] complete representation basic format for a period of
 *   ; time consisting of a start and end. The start MUST be before the
 *   ; end.
 * 
 *   period-start = date-time "/" dur-value
 *   ; [ISO 8601] complete representation basic format for a period of
 *   ; time consisting of a start and positive duration of time.
 * 
 * Description: If the property permits, multiple "period" values are
 * specified by a COMMA character (US-ASCII decimal 44) separated list
 * of values. There are two forms of a period of time. First, a period
 * of time is identified by its start and its end. This format is
 * expressed as the [ISO 8601] complete representation, basic format for
 * "DATE-TIME" start of the period, followed by a SOLIDUS character
 * (US-ASCII decimal 47), followed by the "DATE-TIME" of the end of the
 * period. The start of the period MUST be before the end of the period.
 * Second, a period of time can also be defined by a start and a
 * positive duration of time. The format is expressed as the [ISO 8601]
 * complete representation, basic format for the "DATE-TIME" start of
 * 
 * the period, followed by a SOLIDUS character (US-ASCII decimal 47),
 * followed by the [ISO 8601] basic format for "DURATION" of the period.
 * 
 * Example: The period starting at 18:00:00 UTC, on January 1, 1997 and
 * ending at 07:00:00 UTC on January 2, 1997 would be:
 * 
 *   19970101T180000Z/19970102T070000Z
 * 
 * The period start at 18:00:00 on January 1, 1997 and lasting 5 hours
 * and 30 minutes would be:
 * 
 *   19970101T180000Z/PT5H30M
 * 
 * No additional content value encoding (i.e., BACKSLASH character
 * encoding) is defined for this value type.
 * 
 * @package     qCal
 * @subpackage  qCal\Value
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
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
     * @todo Is it possible to preserve a duration rather than convert to a
     *       period with set start/end times? It would be ideal to preserve
     *       rather than lose that information.
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
