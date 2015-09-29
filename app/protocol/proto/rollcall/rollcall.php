<?php

//创建点名
$c2s_rollcall_create = array(
	'is_auto' => array('required', 'int'),		//是否自动 0不是 1是
	'tripid' => array('required', 'string'),		//行程id
	'hascall' => array('optional', 'string'),		//已应答游客id {'id':1,'id':1}
);

//创建点名反馈
$s2c_rollcall_create = array(
	'rollcallid' => array("optional", "string"),	//成功返回唯一id
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
	'ver_id' => array("optional", "string"),	//版本号
);

//更新点名
$c2s_rollcall_list_info = array(
	'tripid' => array('required', 'string'),		//行程id
);

$List_info = array(
	'rollcallid' => array('required', 'string'),	//唯一id
	'is_auto' => array('required', 'int'),			//是否自动 0不是 1是
	'createtime' => array('required', 'string'),	//创建时间
	'hascall' => array('required', 'string'),	//已应答人 json 只记录id{'id':1,'id':1}
	'ver_id' => array("required", "string"),	//版本号
);

//更新点名
$s2c_rollcall_list_info = array(
	'list' => array('repeated', $List_info),
);

//消息反馈
$s2c_rollcall_msg = array(
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//删除点名数据
$c2s_rollcall_del = array(
	'rollcallid' => array('required', 'string'),		//点名id
);

//删除点名反馈
$s2c_rollcall_del = array(
	'rollcallid' => array("optional", "string"),	//成功返回唯一id
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//更新点名数据
$c2s_rollcall_update = array(
	'rollcallid' => array('required', 'string'),		//点名id
);

//更新点名数据
$s2c_rollcall_update = array(
	'hascall' => array('required', 'string'),		//已应答人 json 只记录id{'id':1,'id':1}
	'ver_id' => array('required','string'),			//版本号
);
