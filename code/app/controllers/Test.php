<?php

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	//打开指令界面
	public function cmd()
	{
		$this->TWIG->view('cmd/cmd.html');
	}

    //打开富文本界面
    public function ueditor()
    {
        $this->TWIG->view('ueditor/test.html');
    }

    public function controller()
    {
        $data = $this->input->post();
        $data = $this->security->xss_clean($data);
        $this->TWIG->view('ueditor/test_show.html', $data);
    }
}