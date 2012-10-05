<?php

/**
 * Gnbit (http://gnbit.com);
 * 
 * @link        http://git@github.com:benjamingb/GTool.git source repository
 * @copyright  Copyright (c) 2012 Gnbit.SAC. (http://www.zend.com)  
 * @author      Benjamin Gonzales (http://codigolinea.com)   
 */

namespace GTool\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Version\Version;


class InfoController extends AbstractActionController
{
    /**
     * Version Zend Framework 
     * @return Zend\version
     */
    public function versionAction()
    {
        return "You are using Zend Framework ".Version::VERSION."\n";
    }
}
