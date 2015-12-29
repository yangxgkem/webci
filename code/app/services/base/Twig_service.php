<?php 

class Twig_service extends CI_Service {
	
	private $loader;
	
	private $twig;

    private $data = array();

    function __construct() 
    {
    	require_once (APPPATH.'3rd/Twig/Autoloader.php');
		Twig_Autoloader::register();
		$this->loader = new Twig_Loader_Filesystem(VIEWPATH);
		$this->twig = new Twig_Environment($this->loader, array('debug' => FALSE, 'auto_reload' => TRUE, 'cache' => FCPATH."cache/twig/",));
	}

    //给变量赋值
    public function assign($var, $value = NULL)
    {
        if(is_array($var)) {
            foreach($var as $key => $val) {
                $this->data[$key] = $val;
            }
        } else {
            $this->data[$var] = $value;
        }
    }
	
    //解析渲染
	public function view($tpl, $data=array(), $return = FALSE) 
	{
        $data = array_merge($this->data, $data);
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