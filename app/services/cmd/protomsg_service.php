<?php



class Protomsg_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
	}

	//protomsg指令
	public function check_protomsg($args = "")
	{
		$args=explode(" ", $args);
		$cmd = $args[0];
		//前100留个系统指令
		if ($cmd <= 999) {
			$this->sys_cmd($cmd, $args);
		}
		//1000--2000 by yangxg
		elseif ($cmd < 2000) {
			$this->yangxg_cmd($cmd, $args);
		}
		//2001--3000 by fzh
		elseif ($cmd < 3000 AND $cmd>2000) {
			$this->fzh_cmd($cmd, $args);
		}
	}

	// sys cmd
	public function sys_cmd($cmd, $args)
	{
		if($cmd == 101) {
			print_r($_SESSION);
		}
		elseif($cmd == 102) {
			$data = array(
				"zone" => "+86",
				"phone" => "15".strtotime('now'),
				"password" => password_hash("123456", PASSWORD_DEFAULT),
				"birthday" => date("Y-m-d H:i:s",strtotime('now')),
				"sex" => 1,
				"id_card" => "44078119901".strtotime('now'),
				"name" => "王晓峰",
				"guide_id" => "D-1308-003",
				"email" => "1003@qq.com",
				"sign" => "我被项目负责人叫去拍黄片了",
			);
			$this->guide_model->add_guide($data);
		}
	}

	//yangxg cmd
	public function yangxg_cmd($cmd, $args)
	{
		if($cmd == 1001) {
			$protomsg = array(
			    'id' => '123456789',
			    'pw' => '123456789',
			);
			$this->login_service->c2s_login_login($protomsg);
		}
	}

	//fzh cmd
	public function fzh_cmd($cmd, $args)
	{
		if ($cmd == 2001) {
			$protomsg = array(
				'id' => '123456789',
			);
			$this->guide_service->c2s_guide_info($protomsg);
		}
		elseif ($cmd == 2002) {
			$protomsg = array(
				'guide_id' => 'g_55ed0bdba5454',
				'title' => 'ddddddddd',
				'contents' => 'aaaaaadfsdfasdfasdfasdfasdfadfasdfadfadf',
			);
			$this->systips_service->c2s_systips_send($protomsg);
		}
	}
}
