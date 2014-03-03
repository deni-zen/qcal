<?php
/**
 * Core iCalendar Component
 * @todo I think I want to remove the "V" from the beginning of the component
 *       class names. They have the correct name set in their $name property so
 *       there really shouldn't be any reason why I can't.
 */
namespace qCal\Element\Component;

class VCalendar extends \qCal\Element\Component {

    /**
     * Component Name
     * @var string Component name
     */
    protected $name = "VCALENDAR";

}