<?php

class Base_model extends CI_Model {

	//数据库对象
	public $db;

	//数据库工具类
	public $dbutil;

	//数据库工厂类
	public $dbforge;

	public function __construct()
    {
        parent::__construct();
    }
	
	//连接数据库
	public function connectdb($confdb_name)
	{
		if ($this->db !== NULL) {
			return;
		}
		$data = $this->auto_model->connectdb($confdb_name);
		$this->db = $data['db'];
		$this->dbutil = $data['dbutil'];
		$this->dbforge = $data['dbforge'];
	}

	//校验数据库
	public function checkdb($db_name)
	{
		if ( ! $this->dbutil->database_exists($db_name)) {
			if ( ! $this->dbforge->create_database($db_name)) {
				$this->EFUNC->RUNTIME_ERROR("create database error", $db_name);
			}
		}
		$this->db->db_select($db_name);
	}
}