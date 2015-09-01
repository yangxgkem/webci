<?php

//登录
$c2s_login_login = array(
	'id' => 1,//电话号码 或 导游证id
	'pw' => 2,//密码
);

//返回登录状态
$s2c_login_login = array(
	'errno' => 1,//错误编号 0表示登录成功 101为未验证导游证
	'errmsg' => 2,//错误内容
);

//注册
$c2s_login_register = array(
	'zone' => 1,//手机区号
	'id' => 2,//电话号码
	'pw' => 3,//密码
);

//注册信息
$s2c_login_register_check = array(
	'errno' => 1,//错误编号 0表示此手机号还没注册,已发短信验证
	'errmsg' => 2,//错误内容
);

//输入验证码
$c2s_login_code = array(
	'code' => 1,//短信验证码
);

//返回注册结果
$s2c_login_register_result = array(
	'errno' => 1,//错误编号 0表示服务端注册成功
	'errmsg' => 2,//错误内容
);

//导游证验证
$c2s_login_guide_check = array(
	'name' => 1,//姓名
	'guide_id' => 2,//导游证id
	'id_card' => 3,//身份证
);

//验证成功,会直接入库,此处返回最终入库成功后或某一步骤失败的结果
$s2c_login_guide_check = array(
	'errno' => 1,//错误编号 0表示成功
	'errmsg' => 2,//错误内容
);