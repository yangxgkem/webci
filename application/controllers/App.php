<?php

class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(FALSE);
	}

	/**
	 * 返回错误信息
	 */
	public function senderror($errno, $errmsg)
	{
		$protoinfo = array(
			'pname' => 's2c_pname_error',
			'errno' => $errno,
			'errmsg' => $errmsg,
		);
		echo json_encode($protoinfo);
	}

	/**
	 * 协议处理
	 */
	public function checkproto()
	{
		$CI =& get_instance();
		
		$protomsg = $this->input->raw_input_stream;
		$protomsg = $this->security->xss_clean($protomsg);
		$protomsg = json_decode($protomsg, true);
		if ( ! $protomsg)
		{
			$this->senderror(404, 'protomsg decode error');
			return;
		}

		//协议名称
		$pname = $protomsg['pname'];

		//载入协议名模块
		require_once(APPPATH.'protocol/protocol_name.php');
		
		//校验协议是否存在
		if ( ! array_key_exists($pname, $protocol_name))
		{
			$this->senderror(404, 'can not found service');
			return;
		}

		//校验业务是否存在
		$service = $protocol_name[$pname];
		if ( ! array_key_exists(0, $service) OR ! array_key_exists(1, $service) OR ! file_exists(APPPATH.'services/'.$service[0].'.php'))
		{
			$this->senderror(404, 'can not found service path');
			return;
		}

		//载入业务文件
		$this->load->service($service[0], $service[1]);

		//校验service是否含有此方法
		if ( ! in_array($pname, get_class_methods($this->$service[1])) )
		{
			$this->senderror(404, 'can not found service func');
			return;
		}

		//启动session
		$CI->load->library('session');

		//执行业务并返回数据给客户端
		call_user_func_array(array($this->$service[1], $pname), array($protomsg));
		$protoinfo = $CI->userObj->get_send_data();
		if ($protoinfo)
		{
			echo json_encode($protoinfo);
		}
	}

	
}