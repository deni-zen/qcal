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
 * Debugging function - Dumps component in a human-readable way
 */
function pcom($com) {

    echo '<div style="font-family: lucida grande; margin: 10px; padding: 10px 25px; border: 1px solid #999; background-color: #bbb">';
    if ($com instanceof \qCal\Element\Component) {
        echo '<strong style="text-decoration: underline;">' . $com->getName() . '</strong>' . "<br>";
        foreach ($com->getAllProperties() as $prop) {
            pprop($prop);
        }
        foreach ($com->getAllChildren() as $child) {
            pcom($child);
        }
    } else {
        echo 'Not A Component';
        pr($com);
    }
    echo "</div>";

}

function pprop($prop) {

    if ($prop instanceof \qCal\Element\Property) {
        $print = '<strong>' . $prop->getName() . "</strong>";
        if ($prop->hasParams()) {
            // $params = array();
            foreach ($prop->getParams() as $key => $param) {
                // $params[] = $key . '=' . $param;
                $print .= ';' . $key . '=' . $param->getValue();
            }
            // $print .= implode(';', $params)
        }
        if (is_array($prop->getValue())) {
            $value = implode(',', $prop->getValue());
        } else {
            $value = $prop->getValue();
        }
        $print .= ": " . $value . "<br>";
    }
    print $print;

}

function ppar($param) {

    

}

function pad($string, $pad, $padder = "&nbsp;") {

    $ret = '';
    for($i = 1; $i < $pad; $i++) {
        $ret .= $padder;
    }
    return $ret . $string;

}

/**
 * Allows stuff like this with(new Object())->doStuff()
 */
function with($obj) {

    return $obj;

}

/**
 * "With Index" Gets index of an array
 * Allows within(functionThatReturnsAnArray(), 0)->doSomething()
 * Where before you'd have had to do $arr = functionThatReturnsAnArray(); $arr->doSomething()
 * @todo Should this throw an exception?
 */
function within($array, $index = 0) {

    if (array_key_exists($index, $array)) return $array[$index];
    return false;

}