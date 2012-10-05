<?php

/**
 * Gnbit (http://gnbit.com);
 * 
 * @link        http://git@github.com:benjamingb/GTool.git source repository
 * @copyright   Copyright (c) 2012 Gnbit.SAC. (http://www.zend.com)  
 * @author      Benjamin Gonzales (http://codigolinea.com)   
 */

namespace GTool;

use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapterInterface;

class Module implements ConsoleUsageProviderInterface, AutoloaderProviderInterface, ConfigProviderInterface {

    /*
     * array $config
     */
    protected $config;

    public function onBootstrap($e)
    {
       //
    }

    /**
     * Get path to config file
     * 
     * @return string 
     */
    public function getConfig()
    {
        return $this->config = include __DIR__ . '/config/module.config.php';
    }

    /**
     * Get Autolader Config 
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Configure messages the display in console 
     * 
     * @param ConsoleAdapterInterface $console
     * @return array
     */
    public function getConsoleUsage(ConsoleAdapterInterface $console)
    {
        if (!empty($this->config->disableUsage)) {
            return null; // usage information has been disabled
        }

        // TODO: Load strings from a translation container
        return array(
             'Basic information:',
            'zfversion' => 'display current Zend Framework version',

            'Modules:',
            'rename <ModuleDirectory> <NewNameModule>' => '',
            array('<ModuleDirectory>','The Directory Module'),
            array('<NewNameModule>','The new name Moddule rename Directory '),
        );
    }

}
