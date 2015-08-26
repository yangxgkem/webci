<?php

/**
 * 用户模块
 */
class User_service extends CI_Service {

	//待发送处理数据
	public $send_data;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 返回数据,如果是app 则在controllers/App.php 中直接返回给客户端
	 */
	public function send_proto($pname, $data)
	{
		$data['pname'] = $pname;
		$this->send_data = $data;
	}

	/**
	 * 获取可发送数据
	 */
	public function get_send_data()
	{
		return $this->send_data;
	}

	/**
	 * 获取用户数据
	 */
	public function get_sess($key)
	{
		if (isset($_SESSION[$key]))
		{
			return $_SESSION[$key];
		}
	}

	/**
	 * 保存用户数据
	 */
	public function set_sess($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * 删除某数据
	 */
	public function unset_sess($key)
	{
		unset($_SESSION[$key]);
	}

	/**
	 * 设置登录状态
	 */
	public function set_status($status)
	{
		$this->set_sess('login_status', $status);
	}

	/**
	 * 获取登录状态
	 */
	public function get_status()
	{
		return $this->get_sess('login_status');
	}

	/**
	 * 清空用户缓存数据
	 */
	public function clear_cache()
	{
		$_SESSION = array();
	}

	/**
	 * 登录成功,缓存相关数据到session
	 */
	public function login_check($data)
	{
		foreach ($data as $key => $value) {
			$this->set_sess($key, $value);
		}
	}
}