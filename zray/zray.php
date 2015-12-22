<?php

namespace ZRayExtension;

class CodeIgniter
{

    private $ci = null;

    const SUPPORTED_CI_VERSION = '2.2';

    public function init($context, &$storage)
    {
    
    	if(null !== $this->ci)
	        return;
	        
        $storage['installation']['current_version'] = CI_VERSION;
        $storage['installation']['supported_version'] = static::SUPPORTED_CI_VERSION;
        $storage['installation']['is_supported_version'] = true;
        
        if (version_compare(CI_VERSION, static::SUPPORTED_CI_VERSION, '<')) {
	        $storage['installation']['is_supported_version'] = false;
            return; //this extension support only C.I version >= 2.2.0
        }
        
        $this->ci =& get_instance();
            
        $storage['configuration'] = $this->loadConfiguration();
        $storage['models'] = $this->loadModels();
        $storage['libraries'] = $this->loadLibraries();
        $storage['helpers'] = $this->loadHelpers();
        $storage['hooks'] = $this->loadHooks();
        $storage['views'] = $this->loadViews();
        $storage['request'] = $this->getControllerInfo();
        $storage['cache'] = $this->getCacheInfo();
    }

    private function loadConfiguration()
    {
        $config = array();

        foreach ($this->ci->config->config as $name => $value) {
            $value = is_array($value) ? '<pre>' . print_r($value, true) . '</pre>' : $value;
            $config[$name] = array('name' => $name, 'value' => $value);
        }

        return $config;
    }

    private function loadViews()
    {
        $views = array();
        if (method_exists($this->ci->load, 'get_views')) {
            $views = $this->ci->load->get_views();
        }

        $base_path = substr(str_replace(SYSDIR, '', BASEPATH), 0, -1);

        $_views = array();

        foreach ($views as $path => $view) {
            $path = str_replace($base_path, '', $path);
            $_views[$path] = array('name' => $view, 'path' => $path);
        }

        return $_views;
    }

    private function loadModels()
    {
        $models = array();
        if (method_exists($this->ci->load, 'get_models')) {
            $models = $this->ci->load->get_models();
        }

        return array_map(function ($item) {
            return array('name' => $item);
        }, $models);
    }

    private function loadLibraries()
    {
        $loaded_libraries =& is_loaded();

        return array_map(function ($item) {
            return array('name' => $item);
        }, $loaded_libraries);
    }

    private function loadHelpers()
    {
        $helpers = array();

        if (method_exists($this->ci->load, 'get_helpers')) {
            $helpers = $this->ci->load->get_helpers();
        }

        return array_map(function ($item) {
            return array('name' => $item);
        }, array_keys($helpers));
    }

    private function loadHooks()
    {
        $hooks = array();
        if (!$this->ci->hooks->enabled) {
            return array();
        }

        foreach ($this->ci->hooks->hooks as $hook_point => $_hooks) {
            if (!isset($_hooks[0]))
                $_hooks = array($_hooks);

            foreach ($_hooks as $hook) {
                $hooks[$hook_point] = array_merge(array('event' => $hook_point), $hook);
            }
        }

        return $hooks;
    }

    private function getControllerInfo()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $controller = $this->ci->router->class;
        $action = $this->ci->router->method;
        $parameters = $this->ci->input->{$method}();
        $key = $controller . '::' . $action;

        $info = array();
        $info[$key] = array(
            'controller' => ucfirst($controller),
            'action' => $action,
            'method' => strtoupper($method),
            'parameters' => $parameters
        );
        
        return $info;
    }
    
    private function getCacheInfo(){
	$cacheInfos = array();
    	if(isset($this->ci->cache)){
    		$cacheInfo = $this->ci->cache->cache_info();
    		
    		foreach($cacheInfo as $item){
    			$cacheInfos[$item['name']] = array_merge($cacheInfo[$item['name']], array('items' => $this->ci->cache->get($item['name'])));
    		}
    	}
    	
    	return $cacheInfos;
    }
}

$zre = new \ZRayExtension('CodeIgniter');
$zre->setEnabledAfter('MY_Loader::initialize');

$codeIgniter = new CodeIgniter();

$zre->traceFunction('CI_Output::_display', function () {}, array($codeIgniter, 'init'));

$zre->setMetadata(array(
    'logo' => __DIR__ . DIRECTORY_SEPARATOR . 'logo.png',
));
