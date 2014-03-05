<?php
/**
 * ByWeekNo Recurrence Rule
 *
 * @package     qCal
 * @subpackage  qCal\DateTime\Recur
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\DateTime\Recur\Rule;

class ByWeekNo extends \qCal\DateTime\Recur\Rule {

    public function getDefault() {
    
        return $this->getRecur()->getStart()->getWeekNo();
    
    }

}
