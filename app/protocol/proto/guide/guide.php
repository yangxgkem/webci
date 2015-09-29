<?php

//***************************************个人信息*******************//
//请求个人信息
$c2s_guide_info = array(
	'id' => array("required", "string", 30),//电话号码 或 导游证id
);

//更新个人信息
$c2s_guide_update = array(
	'name' => array("optional", "string", 45),	//名字
	'sex' => array("optional", "int",1),		//性别
	'sign' => array("optional", "string", 100),	//个性签名
);

$s2c_guide_update = array(
	'ver_id' => array('optional','string'),	//版本号
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//个人信息
$s2c_guide_info = array(
	'pic' => array("required", "string"),			//图片地址
	'name' => array("required", "string"),		//名字
	'guide_id' => array("required", "string"),	//导游证
	'wechat' => array("required", "string"),	//微信号
	'sex' => array("required", "int"),	//性别
	'sign' => array("required", "string"),	//签名
	'email' => array("required", "string"),	//邮箱
	'phone' => array("required", "string"),	//邮箱
);

//消息反馈
$s2c_guide_msg = array(
	'errno' => array("required", "int"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//***************************************修改、绑定邮箱*******************//

//发送验证码
$c2s_guide_email_code = array(
	'email' => array("required", "string", 40),		//目标邮箱
);

$s2c_guide_email_code = array(
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//完成修改邮箱
$c2s_guide_bind_email = array(
	'code' => array("required", "int",6),		//验证码
);

$s2c_guide_bind_email = array(
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//***************************************修改手机号码*******************//

$c2s_guide_phone_code = array(
	'phone' => array("required", "int", 11),		//验证码
);

$s2c_guide_phone_code = array(
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//完成修改手机
$c2s_guide_bind_phone = array(
	'code' => array("required", "int", 6),		//验证码
);

$s2c_guide_bind_phone = array(
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);


//***************************************上传头像*******************//

//上传头像
$c2s_guide_upload_pic= array(
	'updatefile' => array("required", "string"),	//客户端发送上传文件字符串 php会预处理 逻辑层不用再处理
);

//上传头像
$s2c_guide_upload_pic= array(
	'ver_id' => array('optional','string'),		//版本号
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);


//***************************************意见反馈*******************//

//提交反馈
$c2s_guide_feedback = array(
	'contents' => array('required', 'string', 1200)		//反馈内容
);

//提交反馈
$s2c_guide_feedback = array(
	'errno' => array("required", "int"),		//错误码 0表示成功
	'errormsg' => array("optional", "int"),		//错误内容
);

