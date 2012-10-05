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
use Zend\View\Model\ConsoleModel;
use GTool\Model\Map;
use Zend\Console\ColorInterface as Color;

class ModulemapController extends AbstractActionController {

    
    /**
     * Rename Folder and replace textsin the files 
     * 
     * @return \Zend\View\Model\ConsoleModel 
     */
    public function renameAction()
    {

        $moduleDir = getcwd() . DIRECTORY_SEPARATOR . "module" . DIRECTORY_SEPARATOR;
        $request = $this->getRequest();
        $console = $this->getServiceLocator()->get('console');

        $moduleName = $request->getParam('moduleName');
        $newModuleName = $request->getParam('newModuleName', null);

        //Validate directory
        if (!is_dir($moduleDir . $moduleName)) {
            $m = new ConsoleModel();
            $m->setErrorLevel(2);
            $m->setResult('Invalid module directory provided "' . $moduleName . ', no found"' . PHP_EOL);
            return $m;
        }

        //validate NewName
        if (null === $newModuleName || !preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $newModuleName)) {
            $m = new ConsoleModel();
            $m->setErrorLevel(2);
            $m->setResult('Name is NULL or "' . $newModuleName . '" name is invalid for module' . PHP_EOL);
            return $m;
        }

      


        $files = new Map($moduleDir . $moduleName);
        $listFiles = array();
       
        //mapfiles
        foreach ($files as $file) {
            $pathInfo = pathinfo($file->getBasename());
            if ($file->isFile() && isset($pathInfo['extension']) && $pathInfo['extension'] == 'php') {
                $listFiles['file'][] = array(
                    'name' => $file->getBasename(),
                    'realpath' => $file->getRealPath(),
                    'path' => $file->getPath()
                );
            }
            if ($file->isDir() && ($file->getBasename() == $moduleName || $file->getBasename() == $this->getCamelCaseName($moduleName))) {
                $listFiles['folder'][] = array(
                    'name' => $file->getBasename(),
                    'realpath' => $file->getRealPath(),
                    'path' => $file->getPath()
                );
            }
        }


        //tranforms files
        foreach ($listFiles as $type => $list) {
            foreach ($list as $file) {

                //replace content
                if ($type == 'file') {
                    $contents = file_get_contents($file['realpath']);

                    $patterns = array(
                        "/" . $moduleName . "/",
                        "/module-specific-root/",
                        "/" . $this->getCamelCaseName($moduleName) . "/"
                    );
                    $replacements = array(
                        $newModuleName,
                        $this->getCamelCaseName($newModuleName),
                        $this->getCamelCaseName($newModuleName)
                    );
                    $contents = preg_replace($patterns, $replacements, $contents);

                    file_put_contents($file['realpath'], $contents);

                    $console->writeLine(" Wrote File " . $file['name'], Color::GREEN);
                }

                //rename files
                if ($type == 'folder') {
                    if ($file['name'] == $moduleName) {
                        rename($file['realpath'], $file['path'] . DIRECTORY_SEPARATOR . $newModuleName);
                        $console->writeLine(" Rename Folder " . $file['name'] . " to " . $newModuleName, Color::GREEN);
                    }
                    if ($file['name'] == $this->getCamelCaseName($moduleName)) {
                        rename($file['realpath'], $file['path'] . DIRECTORY_SEPARATOR . $this->getCamelCaseName($newModuleName));
                        $console->writeLine(" Rename Folder " . $file['name'] . " to " . $this->getCamelCaseName($newModuleName), Color::GREEN);
                    }
                }
            }
        }
        rename($moduleDir . $moduleName, $moduleDir . DIRECTORY_SEPARATOR . $newModuleName);
        $console->writeLine(" Rename Module " . $moduleName . " to " . $newModuleName, Color::GREEN);
    }
    
    /**
     * Transform Name in CamelCase
     * @param string $str
     * @return string
     */
    private function getCamelCaseName($str)
    {
        $str[0] = strtolower($str[0]);
        return preg_replace_callback('/([A-Z])/', function ($c) {
                            return "-" . strtolower($c[1]);
                        }, $str);
    }
}