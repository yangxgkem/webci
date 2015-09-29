<?php

class Base_model extends CI_Model {

	//连接数据库列表
	public $conlist = array();

	//连接数据库
	public function connectdb($confname)
	{
		if (isset($this->conlist[$confname])) {
			return $this->conlist[$confname];
		}

		$file_path = APPPATH.'config/database.php';
		include($file_path);

		//如果之前加载的配置中,存在以下字段相同的,则认为这两个配置是连接相同的服务器,无需再次连接db,直接返回数据
		foreach ($this->conlist as $key => $value) {
			foreach (array('hostname','username','password','port') as $key => $value) {
				if ($db[$key][$value] !== $db[$confname][$value]) {
					$isconnect = TRUE;
					break;
				}
			}
			if ($isconnect) {
				$this->conlist[$confname] = array(
					'db' => $value['db'],
					'dbutil' => $value['dbutil'],
					'dbforge' => $value['dbforge'],
				);
				return $this->conlist[$confname];
			}
		}

		$db = $this->load->database($confname, TRUE);//数据库对象
		$dbutil = $this->load->dbutil($db, TRUE);//数据库工具类
		$dbforge = $this->load->dbforge($db, TRUE);//数据库工厂类

		$this->conlist[$confname] = array(
			'db' => $db,
			'dbutil' => $dbutil,
			'dbforge' => $dbforge,
		);

		return $this->conlist[$confname];
	}
}