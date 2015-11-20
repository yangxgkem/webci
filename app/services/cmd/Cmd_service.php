<?php


class Cmd_service extends CI_Service {

	//指令列表 执行函数,权限,描述
	public $cmdtbl = array(
	    'forbitconn' => array("forbit_connect",99, "服务器维护,禁止登录"),
	    'permitconn' => array("permit_connect",99, "服务器维护完毕,开放登录"),
	    'protomsg' => array("check_protomsg", 99, "指令"),
	);
	//权限表
	public $powertbl;


	public function __construct()
	{
		parent::__construct();
		$this->setting_service->load("cmd/cmd_data.php");
		$this->powertbl = $this->setting_service->get("CmdPowerData");
	}

	//执行指令
	public function c2s_cmd_cmd($protomsg)
	{

		$command = $protomsg['command'];
		if(stripos($command, "/") === 0) {
		    $command = substr($command, 1);
		    $cmddata=explode(" ", $command, 2);
		    if ( ! isset($cmddata[0])) {
		    	$this->EFUNC->RUNTIME_ERROR("you send cmd error");
		    	return;
		    }

		    $real_cmd = $cmddata[0];
		    if (isset($cmddata[1])) {
		    	$args = $cmddata[1];
		    }
		    else {
		    	$args = "";
		    }

		    //是否含有此指令
		    if ( ! isset($this->cmdtbl[$real_cmd])) {
		    	$this->EFUNC->RUNTIME_ERROR("not found cmd");
		        return;
		    }

		    //校验权限
		    $power = $this->cmdtbl[$real_cmd][1];
		    $ip = $this->input->ip_address();
		    if(! isset($this->powertbl[$ip]) OR $this->powertbl[$ip] < $power) {
		        $this->EFUNC->RUNTIME_ERROR("permission not power", $ip);
		        return;
		    }

		    //是否含有指令函数
		    $func = $this->cmdtbl[$real_cmd][0];
		    if ( ! in_array($func, get_class_methods($this))) {
		        $this->EFUNC->RUNTIME_ERROR("not found cmd func", $real_cmd);
		        return;
		    }

		    //执行指令
		    call_user_func_array(array($this, $func), array($args));
		}
	}

	//protomsg指令
	public function check_protomsg($args = "")
	{
		$this->load->service('cmd/protomsg_service');
		$this->protomsg_service->check_protomsg($args);
	}
}
