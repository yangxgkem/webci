<?php

class Guide_model extends CI_Model {

	//数据库对象
	public $db;

	/**
	 * 连接数据库
	 */
	public function connectdb()
	{
		if ($this->db !== NULL)
		{
			return;
		}
		$config = array(
			'dsn'	=> '',
			'hostname' => 'localhost',
			'username' => 'root',
			'password' => 'root',
			'database' => 'haody_guide_0001',
			'dbdriver' => 'mysqli',
			'dbprefix' => '',
			'pconnect' => TRUE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE
		);

		$CI =& get_instance();
		$this->db = $CI->load->database($config, TRUE);
	}

	/**
	 * 根据电话号码或导游证id获取数据
	 */
	public function get_guide_data($id)
	{
		$this->db->trans_start();

			$this->db->where('phone', $id);
			$this->db->or_where('guide_id', $id);
			$query = $this->db->get('haody_guide_0001');

		$this->db->trans_complete();

		return $query->result_array();
	}
}