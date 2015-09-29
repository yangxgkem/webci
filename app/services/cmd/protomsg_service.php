<?php

/**
 * 行程模块
 */
class Protomsg_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('login/login_service');
		$this->load->service('trip/trip_service');
		$this->load->service('trip/tripcontent_service');
		$this->load->service('systips/systips_service');
		$this->load->service('user/guide_service');
		$this->load->service('notebook/notebook_service');
		$this->load->service('rollcall/rollcall_service');
		$this->load->service('base/xls_service');
		$this->load->service('base/setting_service');
	}

	/**
	 * protomsg指令
	 */
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

	/**
	 * sys cmd
	 */
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

	/**
	 * yangxg cmd
	 */
	public function yangxg_cmd($cmd, $args)
	{
		if($cmd == 1001) {
			$protomsg = array(
			    'id' => '123456789',
			    'pw' => '123456789',
			);
			$this->login_service->c2s_login_login($protomsg);
		}
		elseif($cmd == 1002) {
			$protomsg = array(
			    'guide_id' => 'g_55f67e2b075bc', //导游id
			    'source' => '广州', //出发点
			    'des' => '广州白云', //目的地
			    'stime' => strval(time()), //开始时间
			    'etime' => strval(time()+24*3600*2), //返回时间
			    'tour' => '好导游', //参团社
			    'travel' => 'hitu', //地接社
			    'joinnum' => 35, //参团人数
			    'guide_name' => '呵呵哒', //全陪导游
			    'traffic' => '飞机', //远途交通
			);
			$this->trip_service->c2s_trip_create($protomsg);
		}
		elseif($cmd == 1003) {
			$protomsg = array(
			    'trip_id' => '10000036',
			    'source' => '广州', //出发点
			    'des' => '广州白云dddddddasdfasdfasdfasdfasdfafasdfasdfasdfadfasdfasdfasdfasdfasdfasdfasdfasdf', //目的地
			    'tour' => '好导游', //参团社
			    'travel' => 'hitu', //地接社
			    'joinnum' => 35, //参团人数
			    'guide_name' => '呵呵哒', //全陪导游
			    'traffic' => '飞机', //远途交通
			);
			$this->trip_service->c2s_trip_update($protomsg);
		}
		elseif($cmd == 1004) {
			$protomsg = array(
			    'trip_id' => '10000039',
			    'guide_id' => 'g_55f67e2b075bc',
			);
			$this->trip_service->c2s_trip_del($protomsg);
		}
		elseif($cmd == 1005) {
			$protomsg = array(
			    'guide_id' => 'g_55f67e2b075bc',
			);
			$this->trip_service->c2s_trip_list($protomsg);
		}
		elseif($cmd == 1006) {
			$protomsg = array(
			    'trip_id' => 't_55f68e6cda44b',
			    'name' => '内容1',
			    'msg' => '这是一个内容的描述，我想不到描述什么，但是又要填充字符，所以随便写写',
			    'stime' => time()-10000,
			    'city' => '广州',
			);
			$this->tripcontent_service->c2s_tripcontent_create($protomsg);
		}
		elseif($cmd == 1007) {
			$protomsg = array(
			    'tripcontent_id' => 'tc_55f68ec176ea9',
			    'name' => '内容2',
			    'msg' => '这是一个内容222222222的描述，我想不到描述什么，但是又要填充字符，所以随便写写',
			    'stime' => time()-1000000,
			    'city' => '赤溪',
			);
			$this->tripcontent_service->c2s_tripcontent_update($protomsg);
		}
		elseif($cmd == 1008) {
			$protomsg = array(
			    'tripcontent_id' => 'tc_55f68ec176ea9',
			);
			$this->tripcontent_service->c2s_tripcontent_del($protomsg);
		}
		elseif($cmd == 1009) {
			$protomsg = array(
			    'trip_id' => 't_55f68e6cda44b',
			);
			$this->tripcontent_service->c2s_tripcontent_list($protomsg);
		}
		elseif($cmd == 1009) {
			$protomsg = array(
			    'trip_id' => 't_55f68e6cda44b',
			);
			$this->tripcontent_service->c2s_tripcontent_list($protomsg);
		}
		elseif($cmd == 1010) {
			$this->setting_service->load("country/country.php");
			print_r($this->setting_service->get("CountryData"));
		}
		
	}

	/*
	*	fzh cmd
	*/
	public function fzh_cmd($cmd, $args)
	{
		if ($cmd == 2001)		//获取基本信息
		{
			$protomsg = array(
				'id' => '123456789',
			);
			$this->guide_service->c2s_guide_info($protomsg);
		}
		elseif ($cmd == 2002)
		{
			$protomsg = array(
				'guide_id' => 'g_55ed0bdba5454',
				'title' => 'ddddddddd',
				'contents' => 'aaaaaadfsdfasdfasdfasdfasdfadfasdfadfadf',
			);
			$this->systips_service->c2s_systips_send($protomsg);
		}
		elseif ($cmd == 2003)
		{
			$protomsg = array(
				'id' => '10000001',
			);
			$this->systips_service->c2s_systips_delete($protomsg);
		}
		elseif ($cmd == 2004)
		{
			$this->systips_service->c2s_systips_list_info();
		}
		elseif ($cmd == 2005)
		{
			$protomsg = array(
				'contents' => 'aaaaaadfsdfasdfasdfasdfasdfadfasdfadfadf',
			);
			$this->guide_service->c2s_guide_feedback($protomsg);
		}
		elseif ($cmd == 2006)
		{
			$protomsg = array(
				'title' => '12345',
				'contents' => 'fsfsdfsdfsdfsfsdfsfsdf',
				'tripid' => '2',
			);
			$this->notebook_service->c2s_notebook_create($protomsg);
		}
		elseif ($cmd == 2007)
		{
			$protomsg = array(
				'notebookid' => '10000001',
				'contents' => 'ZXCZXcZXC',
			);
			$this->notebook_service->c2s_notebook_update($protomsg);
		}
		elseif ($cmd == 2008)
		{
			$protomsg = array(
				'tripid' => '2',
			);
			$this->notebook_service->c2s_notebook_list_info($protomsg);
		}
		elseif ($cmd == 2009)
		{
			$protomsg = array(
				'is_auto' => 1,
				'tripid' => '1',
			);
			$this->rollcall_service->c2s_rollcall_create($protomsg);
		}
	}
}
