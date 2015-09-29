<?php

//登录
$c2s_login_login = array(
	'id' => array("require", "string"),//电话号码 或 邮箱
	'pw' => array("require", "string"),//密码
);

//返回登录状态
$s2c_login_login = array(
	'errno' => array("require", "int"),//错误编号 0表示登录成功 101为未验证导游证
);

//注册
$c2s_login_register = array(
	'zone' => array("require", "string", 9),//手机区号
	'id' => array("require", "string", 16),//电话号码
	'pw' => array("require", "string", 16),//密码
);

//注册信息
$s2c_login_register_check = array(
	'errno' => array("require", "int"),//错误编号 0表示此手机号还没注册,已发短信验证
);

//输入验证码
$c2s_login_code = array(
	'code' => array("require", "string"),//短信验证码
);

//返回注册结果
$s2c_login_register_result = array(
	'errno' => array("require", "int"),//错误编号 0表示服务端注册成功
);

//导游证验证
$c2s_login_guide_check = array(
	'name' => array("require", "string", 45),//姓名
	'guide_id' => array("require", "string", 40),//导游证id
	'id_card' => array("optional", "string"),//身份证
);

//验证成功,会直接入库,此处返回最终入库成功后或某一步骤失败的结果
$s2c_login_guide_check = array(
	'errno' => array("require", "int"),//错误编号 0表示成功
);

//找回密码
$c2s_login_retrieve = array(
	'type' => array("require", "string"),//找回类型 email邮箱 phone手机
	'id' => array("require", "string"),//内容
);

//返回找回密码信息
$s2c_login_retrieve = array(
	'errno' => array("require", "int"),//错误编号 0表示成功
);

//找回更新密码
$c2s_login_retrieve_check = array(
	'code' => array("require", "string"),//验证码
);

//设置结果
$s2c_login_retrieve_check = array(
	'errno' => array("require", "int"),//错误编号 0表示成功
);

//找回更新密码
$c2s_login_newpw = array(
	'pw' => array("require", "string", 16),//内容
);

//设置结果
$s2c_login_newpw = array(
	'errno' => array("require", "int"),//错误编号 0表示成功
);