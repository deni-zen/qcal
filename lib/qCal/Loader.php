<?php
/**
 * qCal Class Loader
 * This class loads qCal classes based on their names. It is used by the auto-
 * loader to load qCal classes automatically.
 */
namespace qCal;

class Loader {

    static public function loadClass($name) {
    
        if (class_exists($name)) return true;
        $path = str_replace("\\", DIRECTORY_SEPARATOR, $name) . ".php";
        return self::loadFile($path);
    
    }
    
    static public function loadFile($filename) {
    
        if (!self::fileExists($filename)) {
            throw new \qCal\Exception\FileNotFound("$filename does not exist.");
        }
        return require_once $filename;
    
    }
    
    static public function fileExists($filename) {
    
        $ip = explode(PATH_SEPARATOR, get_include_path());
        foreach ($ip as $path) {
            $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            if (file_exists($path . $filename)) return true;
        }
        return false;
    
    }

}