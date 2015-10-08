<?php 

class Twig_service extends CI_Service {
	
	private $loader;
	
	private $twig;
    
    function __construct() 
    {
    	require_once (APPPATH . '3rd/Twig/Autoloader.php');
		Twig_Autoloader::register();
		$this->loader = new Twig_Loader_Filesystem(VIEWPATH);
		$this->twig = new Twig_Environment($this->loader, array('auto_reload' => true));
	}
	
	public function view($tpl, $data, $return = FALSE) 
	{
		$output = $this->twig->render($tpl, $data);
        if ($return) {
        	return $output;
        } else {
        	$this->output->append_output($output);
        }
    }
    
    public function __call($method, $args) 
    {
        return call_user_func_array(array($this->twig, $method), $args);
    }
}