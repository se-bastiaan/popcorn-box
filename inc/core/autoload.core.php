<?php

	class Autoload {

	    public static $loader;
	    private $current_directory;

	    public static function init()
	    {
	        if (self::$loader == NULL)
	            self::$loader = new self();

	        return self::$loader;
	    }

	    public function __construct()
	    {
	    	$this->current_directory = str_replace("/core", "", dirname(__FILE__));

	    	spl_autoload_register(array($this,'core'));
	        spl_autoload_register(array($this,'model'));
	        spl_autoload_register(array($this,'helper'));
	        spl_autoload_register(array($this,'controller'));
	        spl_autoload_register(array($this,'library'));
	    }

	    public function core($class)
	    {
	    	$class = strtolower($class);

	        set_include_path(get_include_path().PATH_SEPARATOR.$this->current_directory.'/core/');
	        spl_autoload_extensions('.core.php');
	        spl_autoload($class);
	    }


	    public function library($class)
	    {
	    	$class = strtolower($class);

	        set_include_path(get_include_path().PATH_SEPARATOR.$this->current_directory.'/libraries/');
	        spl_autoload_extensions('.lib.php');
	        spl_autoload($class);
	    }

	    public function controller($class)
	    {
	        $class = strtolower(preg_replace('/_controller$/ui','',$class));

	        set_include_path(get_include_path().PATH_SEPARATOR.$this->current_directory.'/controllers/');
	        spl_autoload_extensions('.controller.php');
	        spl_autoload($class);
	    }

	    public function model($class)
	    {
	        $class = strtolower(preg_replace('/_model$/ui','',$class));
	        
	        set_include_path(get_include_path().PATH_SEPARATOR.$this->current_directory.'/models/');
	        spl_autoload_extensions('.model.php');
	        spl_autoload($class);
	    }

	    public function helper($class)
	    {
	        $class = strtolower(preg_replace('/_helper$/ui','',$class));

	        set_include_path(get_include_path().PATH_SEPARATOR.$this->current_directory.'/helpers/');
	        spl_autoload_extensions('.helper.php');
	        spl_autoload($class);
	    }

	}

	Autoload::init();