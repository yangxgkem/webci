<?php

require_once (APPPATH.'models/Base_model.php');

class Log_model extends Base_model {

	public function __construct()
    {
        parent::__construct();
    }

    public function con_and_checkdb()
    {
        $this->connectdb("default");
        $this->checkdb("cilog");
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
		$this->con_and_checkdb();
		$tblname = "log_".date("Ym",strtotime('now'));;
		$this->check_table($tblname);
		$this->chekc_data($data);
		return $this->db->insert($tblname, $data);
	}
}


