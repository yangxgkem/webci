<?php


class Efunc_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('log/log_model');//数据库
	}

	//添加日志
	public function addlog($name, $data)
	{
		$logdata = array();
		$logdata['time'] = date("Y-m-d H:i:s",strtotime('now'));
		$logdata['name'] = $name;
		$logdata['data'] = json_encode($data, JSON_UNESCAPED_UNICODE);
		$this->log_model->addlog($logdata);
	}

	//打印函数调用堆栈
	function print_stack_trace()
	{
		$array = debug_backtrace();
		unset($array[0]);
		foreach ($array as $row) {
			$msg .= $row['file'].':'.$row['line'].'line, call func:'.$row['function'].'<p>';
		}
		log_message("error", $msg);
	}

	//打印信息
	function RUNTIME()
	{
		$args = func_num_args();//获取参数个数
		$arg_list = func_get_args(); //获取参数集合
		if($args <= 0) {
			return;
		}

		$array = debug_backtrace();
		$row = $array[0];
		$msg = "[RUNTIME] ".$row['file'].':'.$row['line']."\t\t";
		foreach ($arg_list as $key => $value) {
			if (is_array($value)) {
				$msg = $msg.json_encode($value, JSON_UNESCAPED_UNICODE)."\t";
			}
			else {
				$msg = $msg.$value."\t";
			}
		}
		$msg = $msg."\n";
		log_message("error", $msg);
	}

	//打印警告信息
	function RUNTIME_ERROR()
	{
		$args = func_num_args();//获取参数个数
		$arg_list = func_get_args(); //获取参数集合
		if($args <= 0) {
			return;
		}

		$array = debug_backtrace();
		$row = $array[0];
		$msg = "[RUNTIME_ERROR] ".$row['file'].':'.$row['line']."\t\t";
		foreach ($arg_list as $key => $value) {
			if (is_array($value)) {
				$msg = $msg.json_encode($value, JSON_UNESCAPED_UNICODE)."\t";
			}
			else {
				$msg = $msg.$value."\t";
			}
		}
		$msg = $msg."\n";
		log_message("error", $msg);
	}
}