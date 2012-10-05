<?php
return array(
    'GTool' => array(
        'disableUsage' => false,
    ),
    'controllers' => array(
        'invokables' => array(
            'GTool\Controller\Info'         => 'GTool\Controller\InfoController',
            'GTool\Controller\Modulemap'    => 'GTool\Controller\ModulemapController',
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'gtool-version' => array(
                    'options' => array(
                        'route'    => 'zfversion',
                        'defaults' => array(
                            'controller' => 'GTool\Controller\Info',
                            'action'     => 'version',
                        ),
                    ),
                ),
                'gtool-display' => array(
                    'options' => array(
                        'route'    => 'rename <moduleName> <newModuleName>',
                        'defaults' => array(
                            'controller' => 'GTool\Controller\Modulemap',
                            'action'     => 'rename',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
