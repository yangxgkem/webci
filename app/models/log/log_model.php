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
		$data = $this->base_model->connectdb('guide');
		$this->db = $data['db'];
		$this->dbutil = $data['dbutil'];
		$this->dbforge = $data['dbforge'];
	}

	//校验数据库
	public function checkdb($dbname = NULL)
	{
		if ( ! $dbname) $dbname = $this->db_name;

		if ( ! $this->dbutil->database_exists($dbname)) {
			if ( ! $this->dbforge->create_database($dbname)) {
				$this->efunc->RUNTIME_ERROR("create database error", $dbname);
			}
		}

		$this->db->db_select($dbname);
	}

	//校验数据表
	public function check_trip_table($tblname = NULL)
	{
		if ( ! $tblname) $tblname = $this->tbl_name;

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

	//根据月份分表
	public function get_tblname() 
	{
		return $this->tbl_name.date("Ym",strtotime('now'));
	}

	//添加日志
	public function addlog($data)
	{
		$tblname = $this->get_tblname();
		$this->connectdb();
		$this->checkdb();
		$this->check_trip_table($tblname);

		$this->db->trans_start();
		$this->db->insert($tblname, $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
	}
}