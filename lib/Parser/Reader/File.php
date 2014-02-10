<?php
/**
 * Parser
 * Abstract parser class 
 *
 * @author      Luke Visinoni <luke.visinoni@gmail.com>
 * @copyright   (c) 2014 Luke Visinoni <luke.visinoni@gmail.com>
 * @license     GNU Lesser General Public License v3 (see LICENSE file)
 */
namespace qCal\Parser\Reader;

class File extends \qCal\Parser\Reader {

    protected $fh;
    
    protected $filename;
    
    public function __construct($filename) {
    
        if (!file_exists(realpath($filename))) {
            // @todo handle this
            throw new \Exception('File does not exist: "' . $filename . '"');
        }
        $this->filename = realpath($filename);
        // @todo Handle error opening file
        $this->fh = @fopen($this->filename, 'r');
    
    }
    
    public function getChar() {
    
        if (fseek($this->fh, $this->pos) == -1) {
            // @todo Handle this
            throw new \Exception('Could not seek to position, "' . $this->pos . '", in file, "' . $this->filename . '"');
        }
        if (false === ($char = fread($this->fh, 1))) {
            // @todo Handle this
            throw new \Exception('Could not read character at position, "' . $this->pos . '", in file, "' . $this->filename . '"');
        }
        if (feof($this->fh)) {
            return false;
        }
        $this->pos++;
        return $char;
    }

}