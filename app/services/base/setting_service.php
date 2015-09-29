<?php


class Setting_service extends CI_Service {

	//全局数据
	public $setting_data = array();

	//已加载列表
	public $is_loaded =	array();

	public function __construct()
	{
		parent::__construct();
	}

	//加载数据
	public function load($file)
	{
		if (is_array($file)) {
			foreach ($file as $value) {
				$this->load($value);
			}
			return;
		}

		if (isset($this->is_loaded[$file])) {
			return;
		}

		$basepath = APPPATH.'setting/'.$file;
		if (($found = file_exists($basepath)) === TRUE) {
			include($basepath);
		}

		if ( ! isset($setting_data) OR ! is_array($setting_data)) {
			log_message('error', 'Setting file contains no data: '.$file);
			return;
		}

		$this->is_loaded[$file] = TRUE;
		$this->setting_data = array_merge($this->setting_data, $setting_data);
	}

	//读取某数据
	public function get($line)
	{
		$value = isset($this->setting_data[$line]) ? $this->setting_data[$line] : FALSE;
		return $value;
	}
}