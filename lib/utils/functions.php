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

/**
 * Debugging function - Dumps information about $var in a pre-formatted html tag
 */
function pre($var, $exit=true) {

    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    if ($exit) exit;
    return true;

}

/**
 * Does the same thing as pre() but without exiting
 */
function pr($var, $return = false) {

    if ($return) {
        ob_start();
        pre($var, false);
        return ob_get_clean();
    }
    return pre($var, false);

}

/**
 * Allows stuff like this with(new Object())->doStuff()
 */
function with($obj) {

    return $obj;

}