<?php

/**
 * 登录模块
 */
class Login_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();

		//加载需要调用到的模块,包括service 和 model
		$CI =& get_instance();
		$CI->load->model('guide_model');
	}

	/**
	 * 登录
	 */
	public function c2s_login_login($protomsg)
	{
		$CI =& get_instance();

		//顶号登录,清空用户缓存数据
		if ($CI->userObj->get_status() !== LOGIN_STATUS_00)
		{
			$CI->userObj->clear_cache();
		}
		$CI->userObj->set_status(LOGIN_STATUS_00);

		//验证账号
		$id = $protomsg['id'];
		$data = $CI->guide_model->get_guide_data($id);
		if ($data === NULL)
		{
			$protoinfo = array(
				'errno' => 401,
				'errmsg' => '账号或密码有误,请重新输入',
			);
			return $CI->userObj->send_proto('s2c_login_login', $protoinfo);
		}

		//验证密码
		$pw = password_hash($protomsg['pw'], PASSWORD_DEFAULT);
		if ($pw !== $data['password'])
		{
			$protoinfo = array(
				'errno' => 402,
				'errmsg' => '账号或密码有误,请重新输入',
			);
			return $CI->userObj->send_proto('s2c_login_login', $protoinfo);
		}

		$CI->userObj->set_status(LOGIN_STATUS_01);
		$CI->userObj->login_check($data);

		//判定是否已验证导游证
		if ( ! isset($data['guide_id']))
		{
			$CI->userObj->set_status(LOGIN_STATUS_03);
			$protoinfo = array(
				'errno' => 101,
			);
			return $CI->userObj->send_proto('s2c_login_login', $protoinfo);
		}

		//登录成功
		$CI->userObj->set_status(LOGIN_STATUS_SUCC);
		$protoinfo = array(
			'errno' => 0,
		);
		$CI->userObj->send_proto('s2c_login_login', $protoinfo);
	}

	/**
	 * 注册
	 */
	public function c2s_login_register($protomsg)
	{
		$CI =& get_instance();

		//顶号注册,清空用户缓存数据
		if ($CI->userObj->get_status() !== LOGIN_STATUS_00)
		{
			$CI->userObj->clear_cache();
		}
		$CI->userObj->set_status(LOGIN_STATUS_00);

		$zone = $protomsg['zone'];
		$id = $protomsg['id'];
		$pw = $protomsg['pw'];

		if (strlen($zone) > 3 OR strlen($id) > 16 OR strlen($pw) > 16)
		{
			$protoinfo = array(
				'errno' => 401,
				'errmsg' => '填入数据长度有误',
			);
			return $CI->userObj->send_proto('s2c_login_register_check', $protoinfo);
		}

		if ($CI->guide_model->get_guide_data($id) !== NULL)
		{
			$protoinfo = array(
				'errno' => 402,
				'errmsg' => '该手机号码已被注册',
			);
			return $CI->userObj->send_proto('s2c_login_register_check', $protoinfo);
		}

		//生成验证码 发送短信验证
		$randStr = str_shuffle('0123456789');
		$code = substr($randStr, 0, 6);

		//-------------------------------------------------------------------第三方接口
		
		//发送短信成功
		$regdata = array(
			'zone' => $zone,
			'phone' => $id,
			'pw' => $pw,
			'code' => $code,
		);
		$CI->userObj->set_sess('regdata', $regdata);

		$protoinfo = array(
			'errno' => 0,
		);
		return $CI->userObj->send_proto('s2c_login_register_check', $protoinfo);
	}

	/**
	 * 注册输入短信验证码
	 */
	public function c2s_login_code($protomsg)
	{
		$CI =& get_instance();

		$code = $protomsg['code'];
		$regdata = $CI->userObj->get_sess('regdata');
		if ( ! $regdata OR ! isset($regdata['code']) OR $regdata['code'] !== $code)
		{
			$protoinfo = array(
				'errno' => 401,
				'errmsg' => '您输入的验证码有误',
			);
			return $CI->userObj->send_proto('s2c_login_register_result', $protoinfo);
		}

		$data = array(
			'phone' => $regdata['phone'],
			'password' => password_hash($regdata['pw'], PASSWORD_DEFAULT),
			'birthday' => date("Y-m-d H:i:s",strtotime('now')),
		);
		if ( ! $CI->guide_model->add_guide($data))
		{
			$protoinfo = array(
				'errno' => 402,
				'errmsg' => '数据操作有误',
			);
			return $CI->userObj->send_proto('s2c_login_register_result', $protoinfo);
		}

		$CI->userObj->unset_sess('regdata');
		$CI->userObj->set_status(LOGIN_STATUS_01);
		$CI->userObj->login_check($data);
		
		$protoinfo = array(
			'errno' => 0,
		);
		return $CI->userObj->send_proto('s2c_login_register_result', $protoinfo);
	}

	/**
	 * 验证导游证
	 */
	public function c2s_login_guide_check($protomsg)
	{
		$CI =& get_instance();

		$name = $protomsg['name'];
		$guide_id = $protomsg['guide_id'];
		$id_card = $protomsg['id_card'];

		if (strlen($name) > 30 OR strlen($guide_id) > 13 OR strlen($id_card) > 18)
		{
			$protoinfo = array(
				'errno' => 401,
				'errmsg' => '填入数据长度有误',
			);
			return $CI->userObj->send_proto('s2c_login_guide_check', $protoinfo);
		}

		if ($CI->userObj->get_status() !== LOGIN_STATUS_01)
		{
			$protoinfo = array(
				'errno' => 402,
				'errmsg' => '执行步骤有误',
			);
			return $CI->userObj->send_proto('s2c_login_guide_check', $protoinfo);
		}

		//-------------------------------------------------------------------第三方接口
		

		//验证成功,写入数据库
		$data = array(
			'name' => $name,
			'guide_id' => $guide_id,
			'id_card' => $id_card,
		);
		if ( ! $CI->guide_model->update_guide($CI->userObj->get_sess('phone'), $data))
		{
			$protoinfo = array(
				'errno' => 403,
				'errmsg' => '数据操作有误',
			);
			return $CI->userObj->send_proto('s2c_login_guide_check', $protoinfo);
		}

		//写入session
		foreach ($data as $key => $value) {
			$CI->userObj->set_sess($key, $value);
		}
		$CI->userObj->set_status(LOGIN_STATUS_SUCC);

		$protoinfo = array(
			'errno' => 0,
		);
		return $CI->userObj->send_proto('s2c_login_guide_check', $protoinfo);
	}
}