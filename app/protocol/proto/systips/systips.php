<?php

//请求消息列表
$c2s_systips_list_info = array(
	'place_holder' => array('optional', 'int', 1),		//占位符 
);

//请求消息列表
$c2s_systips_send = array(
	'guide_id' => array('required', 'string'),	//绑定导游唯一id
	'title' => array('required', 'string', 45),		//标题
	'contents' => array('required', 'string'),	//内容
);

//删除消息
$c2s_systips_delete = array(
	'id' => array('required', 'string'),		//消息id
);

//消息处理反馈
$s2c_systips_delete = array(
	'id' => array('optional', 'string'),		//成功返回唯一id
	'errno' => array('required', 'int'),		//错误码 0表示成功
	'errmsg' => array('optional', 'string'),	//错误信息
);

$Tips_list = array(
	'id' => array('required', 'string'),		//消息id
	'title' => array('required', 'string'),		//标题
	'contents' => array('required', 'string'),	//内容
	'createtime' => array('required', 'string'),	//创建时间
	'ver_id' => array('required', 'string'),	//版本号
);

//返回消息列表
$s2c_systips_list_info = array(
	'list' => array('repeated', $Tips_list),
);

//消息处理反馈
$s2c_systips_send = array(
	'ver_id' => array('optional', 'string'),	//版本号
	'id' => array('optional', 'string'),		//成功返回唯一id
	'errno' => array('required', 'int'),		//错误码 0表示成功
	'errmsg' => array('optional', 'string'),	//错误信息
);
