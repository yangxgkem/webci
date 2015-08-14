<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	protected $_ci_service_paths = array(APPPATH);

	protected $_ci_services = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function service($service, $name = '')
	{
		if (empty($service))
		{
			return $this;
		}
		elseif (is_array($service))
		{
			foreach ($service as $key => $value)
			{
				is_int($key) ? $this->service($value, '') : $this->service($key, $value);
			}

			return $this;
		}

		$path = '';

		// Is the service in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($service, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($service, 0, ++$last_slash);

			// And the service name behind it
			$service = substr($service, $last_slash);
		}

		if (empty($name))
		{
			$name = $service;
		}

		if (in_array($name, $this->_ci_services, TRUE))
		{
			return $this;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('The service name you are loading is the name of a resource that is already being used: '.$name);
		}

		if (!class_exists('MY_Service', FALSE))
		{
			load_class('Service', 'core');
		}

		$service = ucfirst(strtolower($service));

		foreach ($this->_ci_service_paths as $service_path)
			{
				if ( ! file_exists($service_path.'services/'.$path.$service.'.php'))
				{
					continue;
				}

				require_once($service_path.'services/'.$path.$service.'.php');

				$this->_ci_services[] = $name;
				$CI->$name = new $service();
				return $this;
			}

		// couldn't find the service
		show_error('Unable to locate the service you have specified: '.$service);
	}
}