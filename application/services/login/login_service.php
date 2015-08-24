<?php

/**
 * 登录模块
 */
class Login_service extends CI_Service {
	public function __construct()
	{
		parent::__construct();

		$CI =& get_instance();
		$CI->load->model('guide_model');
	}

	public function c2s_login_login($protomsg)
	{
		$CI =& get_instance();
		$CI->guide_model->connectdb();

		/*
		for ($id=1001; $id<=1300; $id++)  {
			$data = array(
				'phone' => '159750769'.$id,
				'password' => password_hash('password'.$id, PASSWORD_DEFAULT),
				'sex' => 1,
				'id_card' => '440781199110174'.$id,
				'name' => '导游'.$id,
				'wechat' => 'wechat'.$id,
				'guide_id' => '440781199110174'.$id,
				'email' => 'haodaoyou_'.$id.'@haodaoyou.com',
			);
			$CI->guide_model->db->insert('haody_guide_0001', $data);
		}
		*/

		$id = '1597507691300';
		return $CI->guide_model->get_guide_data($id);
	}
}