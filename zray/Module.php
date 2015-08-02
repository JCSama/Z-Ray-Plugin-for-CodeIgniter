<?php

namespace ZRayExtension;

class Module extends \ZRay\ZRayModule
{

    public function config()
    {
        return array(
            'extension' => array(
                'name' => 'CodeIgniter',
            ),
            'panels' => array(
                'request' => array(
                    'display' => true,
                    'logo' => 'images/request.png',
                    'menuTitle' => 'Request',
                    'panelTitle' => 'Request Info',
                    'searchId' => 'codeigniter-request-search',
                ),
                'helpers' => array(
                    'display' => true,
                    'logo' => 'images/helper.png',
                    'menuTitle' => 'Helpers',
                    'panelTitle' => 'Loaded helpers',
                    'searchId' => 'codeigniter-helpers-search',
                ),
                'models' => array(
                    'display' => true,
                    'logo' => 'images/model.png',
                    'menuTitle' => 'Models',
                    'panelTitle' => 'Loaded models',
                    'searchId' => 'codeigniter-models-search',
                ),
                'libraries' => array(
                    'display' => true,
                    'logo' => 'images/library.png',
                    'menuTitle' => 'Libraries',
                    'panelTitle' => 'Loaded libraries',
                    'searchId' => 'codeigniter-libraries-search',
                ),
                'hooks' => array(
                    'display' => true,
                    'logo' => 'images/hook.png',
                    'menuTitle' => 'Hooks',
                    'panelTitle' => 'Active hooks',
                    'searchId' => 'codeigniter-hooks-search',
                ),
                'views' => array(
                    'display' => true,
                    'logo' => 'images/view.png',
                    'menuTitle' => 'Views',
                    'panelTitle' => 'Loaded views',
                ),
                'configuration' => array(
                    'display' => true,
                    'alwaysShow' => true,
                    'logo' => 'images/config.png',
                    'menuTitle' => 'Configuration',
                    'panelTitle' => 'Configuration',
                    'searchId' => 'codeigniter-configuration-search',
                    'pagerId' => 'codeigniter-configuration-pager',
                ),
                'installation' => array(
                    'display' => true,
                    'logo' => 'logo.png',
                    'menuTitle' => 'Installation',
                    'panelTitle' => 'Installation',
                ),
            )
        );
    }
}