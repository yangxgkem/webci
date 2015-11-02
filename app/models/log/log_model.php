<?php

class Log_model extends CI_Model {

	//数据库对象
	public $db;

	//数据库工具类
	public $dbutil;

	//数据库工厂类
	public $dbforge;

	//行程数据库名称
	public $db_name = 'db_log';

	//行程基本数据表名称
	public $tbl_name = 'log_';

	//连接数据库
	public function connectdb()
	{
		if ($this->db !== NULL) {
			return;
		}
		$data = $this->base_model->connectdb('default');
		$this->db = $data['db'];
		$this->dbutil = $data['dbutil'];
		$this->dbforge = $data['dbforge'];
	}

	//校验数据库
	public function checkdb()
	{
		if ( ! $this->dbutil->database_exists($dbname)) {
			if ( ! $this->dbforge->create_database($dbname)) {
				$this->efunc->RUNTIME_ERROR("create database error", $dbname);
			}
		}
		$this->db->db_select($dbname);
	}

	//校验数据表
	public function check_table($tblname)
	{
		if ($this->db->table_exists($tblname)) {
			return;
		}

		//id 主key
		$this->dbforge->add_field("id bigint not null auto_increment primary key");
		//记录时间
		$this->dbforge->add_field("time datetime not null");
		//名称
		$this->dbforge->add_field("name varchar(40)");
		//日志数据
		$this->dbforge->add_field("data text not null");

		//表类型
		$attributes = array('ENGINE' => 'InnoDB');
		$this->dbforge->create_table($tblname, TRUE, $attributes);
	}

	//校验数据完整性
	public function chekc_data($data)
	{
		foreach ($data as $key => $value) {
			switch ($key) {
				case 'name':
					if (is_string($value) AND strlen($value)<=40) break;
					return;
				default:
					break;
			}
		}

		return TRUE;
	}

	//添加日志
	public function addlog($data)
	{
		$tblname = $this->tbl_name.date("Ym",strtotime('now'));;
		$this->connectdb();
		$this->checkdb();
		$this->check_table($tblname);
		$this->chekc_data($data);

		$this->db->insert($tblname, $data);
	}
}


