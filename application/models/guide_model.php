<?php

class Guide_model extends CI_Model {

	//数据库对象
	public $db;

	//数据库工具类
	public $dbutil;

	//数据库工厂类
	public $dbforge;

	//导游数据库名称
	public $db_guide_name = 'hitudb_guide';

	//导游数据表名称
	public $tbl_guide_name = 'hitutbl_guide';

	/**
	 * 连接数据库
	 */
	public function connectdb()
	{
		if ($this->db !== NULL)
		{
			return;
		}

		$CI =& get_instance();
		$this->db = $CI->load->database('guide', TRUE);
		$this->dbutil = $CI->load->dbutil($this->db, TRUE);
		$this->dbforge = $CI->load->dbforge($this->db, TRUE);
	}

	/**
	 * 校验数据库
	 */
	public function checkdb($dbname = NULL)
	{
		if ( ! $dbname)
		{
			$dbname = $this->db_guide_name;
		}

		if ( ! $this->dbutil->database_exists($dbname))
		{
			if ($this->dbforge->create_database($dbname))
			{
			    log_message('error', 'create database true:'.$dbname.' in guide');
			}
			else
			{
				log_message('error', 'create database false:'.$dbname.' in guide');
			}
		}

		$this->db->db_select($dbname);
	}

	/**
	 * 校验导游数据表
	 */
	public function check_guide_table($tblname = NULL)
	{
		if ( ! $tblname)
		{
			$tblname = $this->tbl_guide_name;
		}

		if ($this->db->table_exists($tblname))
		{
			return;
		}

		//手机号
		$this->dbforge->add_field("phone varchar(30) not null primary key");
		//密码 哈希加密后的值  password_hash(), 不是密码明文
		$this->dbforge->add_field("password varchar(80) not null");
		//记录创建时间
		$this->dbforge->add_field("birthday datetime");
		//最近一次刷新记录时间 TIMESTAMP时间范围是 1970-01-01 00:00:01 ~ 2038
		$this->dbforge->add_field("update_time timestamp on update current_timestamp");
		//性别 1为男 0为女
		$this->dbforge->add_field("sex tinyint");
		//身份证
		$this->dbforge->add_field("id_card varchar(40) unique key");
		//姓名
		$this->dbforge->add_field("name varchar(40)");
		//微信号
		$this->dbforge->add_field("wechat varchar(40) unique key");
		//导游证
		$this->dbforge->add_field("guide_id varchar(40) unique key");
		//邮箱
		$this->dbforge->add_field("email varchar(40) unique key");
		//通讯录分类列表 json{{"标签id","标签名称","创建时间"},...}
		$this->dbforge->add_field("tag_list text");
		//通讯录id列表 json{userid,......}
		$this->dbforge->add_field("address mediumtext");
		//行程id列表 json{tripid,......}
		$this->dbforge->add_field("trip mediumtext");

		//表类型
		$attributes = array('ENGINE' => 'InnoDB');
		$this->dbforge->create_table($tblname, TRUE, $attributes);
	}

	/**
	 * 添加导游
	 */
	public function add_guide($data = array())
	{
		$CI =& get_instance();
		
		$this->connectdb();
		$this->checkdb();
		$this->check_guide_table();

		$this->db->trans_start();
		$this->db->insert($this->tbl_guide_name, $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			return FALSE;
		}
		$CI->cache->save(MEM_GUIDE_TBL.$data['phone'], $data, 1800);

		return TRUE;
	}

	/**
	 * 修改导游数据
	 */
	public function update_guide($phone, $data = array())
	{
		$CI =& get_instance();

		$this->connectdb();
		$this->checkdb();
		$this->check_guide_table();

		$this->db->trans_start();
		$this->db->where('phone', $phone);
		$this->db->update($this->tbl_guide_name, $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			return FALSE;
		}
		$memdata = $CI->cache->get(MEM_GUIDE_TBL.$phone);
		if ($memdata)
		{
			foreach ($data as $key => $value)
			{
				$memdata[$key] = $value;
			}
			$CI->cache->save(MEM_GUIDE_TBL.$phone, $memdata, 1800);
		}

		return TRUE;
	}

	/**
	 * 根据电话号码或导游证id获取数据
	 */
	public function get_guide_data($id)
	{
		$CI =& get_instance();

		$data = $CI->cache->get(MEM_GUIDE_TBL.$id);
		if ($data)
		{
			return $data;
		}

		$this->connectdb();
		$this->checkdb();
		$this->check_guide_table();

		$this->db->trans_start();
		$this->db->where('phone', $id);
		$this->db->or_where('guide_id', $id);
		$query = $this->db->get('hitutbl_guide');
		$this->db->trans_complete();

		if ($query->num_rows() > 0)
		{
			$data = $query->row_array();
			$CI->cache->save(MEM_GUIDE_TBL.$id, $data, 1800);
			return $data;
		}
	}
}