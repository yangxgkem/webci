<?php

class Cmd extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

	//打开指令界面
	public function cmd()
	{
		$this->load->view('cmd/cmd.html');
	}
}