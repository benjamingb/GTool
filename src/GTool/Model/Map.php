<?php
/**
 * Gnbit (http://gnbit.com);
 * 
 * @link        http://git@github.com:benjamingb/GTool.git source repository
 * @copyright   Copyright (c) 2012 Gnbit.SAC. (http://www.zend.com)  
 * @author      Benjamin Gonzales (http://codigolinea.com)   
 */

namespace GTool\Model;

use DirectoryIterator,
    FilterIterator,
    RecursiveIterator,
    RecursiveDirectoryIterator,
    RecursiveIteratorIterator;

class Map extends FilterIterator {

    public function __construct($dir = '.')
    {

        $iterator = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($dir),
                        RecursiveIteratorIterator::SELF_FIRST
        );
        parent::__construct($iterator);
    }

    public function accept()
    {
        $file = $this->getInnerIterator()->current();
        return $file;
    }

}