<?php

class Cmd extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	//打开指令界面
	public function cmd()
	{
		$data['title'] = "CI框架研究";
		$this->TWIG->view('cmd/cmd.html', $data);
	}
}