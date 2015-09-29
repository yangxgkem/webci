<?php

class Proto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

	//协议处理
	public function checkproto()
	{
		//执行业务并返回数据给客户端
		$this->proto_service->checkproto();
		$protoinfo = $this->userObj->get_send_data();
		if ($protoinfo) {
			echo json_encode($protoinfo, JSON_UNESCAPED_UNICODE);
			return;
		}
	}
}