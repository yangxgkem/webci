<?php


class Proto_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
	}

	//返回错误信息
	public function senderror($errno, $errmsg)
	{
		$protoinfo = array(
			'errno' => $errno,
			'errmsg' => $errmsg,
		);
		return $this->USER->send_proto('s2c_pname_error', $protoinfo);
	}

	//校验协议数据
	public function checkprotodata($proto, $data) {
		foreach ($proto as $key => $value) {
			//校验是否为空
			switch ($value[0]) {
				case 'required':
					if ( ! isset($data[$key])) {
						$this->senderror(405, 'required data error');
						return;
					}
					break;
				case 'repeated':
					if ( ! isset($data[$key]) OR ! is_array($data[$key])) {
						$this->senderror(405, 'repeated data error');
						return;
					}
					if (is_array($value[1])) {
						if ( ! $this->checkprotodata($value[1], $data[$key])) {
							return;
						}
					}
					break;
				case 'optional':
					break;
			}
			//校验数据类型
			if (isset($data[$key])) {
				if ($value[0] !== 'repeated') {
					switch ($value[1]) {
						case 'int':
							if ( ! is_numeric($data[$key])) {
								$this->senderror(404, 'data type error:'.$key);
								return;
							}
							break;
						case 'string':
							if ( ! is_string($data[$key])) {
								$this->senderror(405, 'data type error:'.$key);
								return;
							}
							break;
					}
				}
				else {
					switch ($value[1]) {
						case 'int':
							foreach ($data[$key] as $key => $value) {
								if ( ! is_numeric($value)) {
									$this->senderror(404, 'data type error:'.$key);
									return;
								}
							}
							break;
						case 'string':
							foreach ($data[$key] as $key => $value) {
								if ( ! is_string($value)) {
									$this->senderror(405, 'data type error:'.$key);
									return;
								}
							}
							break;
					}
				}
				
			}
			//校验长度
			if (isset($value[2]) AND isset($data[$key])) {
				if ($value[0] !== 'repeated') {
					switch ($value[1]) {
						case 'string':
							if (strlen($data[$key]) > $value[2]) {
								$this->senderror(405, 'data size error');
								return;
							}
							break;
						case 'int':
							if ($data[$key] > $value[2]) {
								$this->senderror(405, 'data size error');
								return;
							}
							break;
					}
				}
				else {
					switch ($value[1]) {
						case 'string':
							foreach ($data[$key] as $key => $value) {
								if (strlen($value) > $value[2]) {
									$this->senderror(405, 'data type error:'.$key);
									return;
								}
							}
							break;
						case 'int':
							foreach ($data[$key] as $key => $value) {
								if ($value > $value[2]) {
									$this->senderror(405, 'data type error:'.$key);
									return;
								}
							}
							break;
					}
				}
			}
		}

		foreach ($data as $key => $value) {
			if ( ! isset($proto[$key])) {
				$this->senderror(405, 'data has other key');
				return;
			}
		}
		return TRUE;
	}

	//协议处理
	public function checkproto()
	{
		$protomsg = $this->input->post();
		if (empty($protomsg)) {
			$protomsg = $this->input->raw_input_stream;
			$protomsg = json_decode($protomsg, TRUE);
			if ( ! $protomsg) {
				$this->senderror(404, 'protomsg decode error');
				return;
			}
		}
		$protomsg = $this->security->xss_clean($protomsg);

		//协议名称
		$pname = $protomsg['pname'];
		unset($protomsg['pname']);

		//载入协议名模块
		require_once(APPPATH.'protocol/protocol_name.php');
		
		//校验协议是否存在
		if ( ! array_key_exists($pname, $protocol_name)) {
			$this->senderror(404, 'can not found service');
			return;
		}

		//校验业务是否存在
		$service = $protocol_name[$pname];
		if ( ! array_key_exists(0, $service) OR ! array_key_exists(1, $service) OR ! file_exists(APPPATH.'services/'.$service[0].'.php')) {
			$this->senderror(404, 'can not found service path');
			return;
		}

		//未登陆成功不允许访问提前业务协议
		if ( ! strstr($pname, 'login') AND ! strstr($pname, 'cmd')) {
			if ( ! $this->USER->is_login()) {
				$this->senderror(404, 'please sign in first');
				return;
			}
			//登录时间过长,重新登录
			$nowtime = strtotime('now');
			$logintime = $this->USER->get_sess("login_time");
			if (($nowtime-$logintime)>(3600*2)) {
				$this->senderror(405, 'please sign in first');
				return;
			}
		}

		//校验协议数据完整性
		require_once(APPPATH.'protocol/proto/'.$service[2]);
		if ( ! $this->checkprotodata($$pname, $protomsg)) {
			return;
		}

		//载入业务文件
		$this->load->service($service[0], $service[1]);

		//校验service是否含有此方法
		if ( ! in_array($pname, get_class_methods($this->$service[1])) ) {
			$this->senderror(404, 'can not found service func');
			return;
		}

		//执行业务并返回数据给客户端
		call_user_func_array(array($this->$service[1], $pname), array($protomsg));
	}
}