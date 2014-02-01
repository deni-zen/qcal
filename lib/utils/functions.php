<?php
/**
 * Convenience Functions
 * These are just a few functions I use regularly for debugging, displaying
 * data, etc. I have included them in this library mainly for use in  testing.
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */

function pre($var, $exit=false) {

    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    if ($exit) exit;
    return true;

}

/**
 * Allows stuff like this with(new Object())->doStuff()
 */
function with($obj) {

    return $obj;

}