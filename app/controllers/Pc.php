<?php

class Pc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('base/proto_service');
		$this->output->enable_profiler(FALSE);
	}
	
	/**
	 * PC协议处理
	 */
	public function checkproto()
	{
		//执行业务并返回数据给客户端
		$this->proto_service->checkproto();
		$protoinfo = $this->userObj->get_send_data();
		if ($protoinfo) {
			echo json_encode($protoinfo, JSON_UNESCAPED_UNICODE);
			return TRUE;
		}
	}

	/**
	 * 打开登录界面
	 */
	public function login()
	{
		$this->load->view('pc/login.html');
	}

	/**
	 * 打开指令界面
	 */
	public function cmd()
	{
		if ( ! $this->userObj->is_login()) return;
		$this->load->view('pc/cmd.html');
	}

	/**
	 * 打开基本信息界面
	 */
	public function baseinfo()
	{
		if ( ! $this->userObj->is_login()) return;
		$this->load->view('pc/baseinfo.html');
	}
}