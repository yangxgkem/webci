<?php

//请求记事本
$c2s_notebook_info = array(
	'notebookid' => array("required", "string"),//记事本id
);

//请求记事本
$c2s_notebook_list_info = array(
	'tripid' => array("required", "string"),//通过行程id获取记事本列表
);

//创建记事本
$c2s_notebook_create = array(
	'title' => array("required", "string", 45) , 	//标题
	'contents' => array("required", "string") , 	//内容
	'tripid' => array("required", "string") , 	//行程id
);

//创建消息反馈
$s2c_notebook_create = array(
	'notebookid' => array("optional", "string"),	//成功返回唯一id
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
	'ver_id' => array("optional", "string"),	//版本号
);

//更新记事本记事本
$c2s_notebook_update = array(
	'notebookid' => array("required", "string"),//记事本id
	'title' => array("optional", "string"),	//标题
	'contents' => array("optional", "string") , 	//内容
);

//更新消息反馈
$s2c_notebook_update = array(
	'notebookid' => array("optional", "string"),	//成功返回唯一id
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
	'ver_id' => array("optional", "string"),	//版本号
);

//删除记事本
$c2s_notebook_delete = array(
	'notebookid' => array("required", "string"),//记事本id
);

//删除消息反馈
$s2c_notebook_delete = array(
	'notebookid' => array("optional", "string"),	//成功返回唯一id
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//上传图片
$c2s_notebook_upload_pic = array(
	'notebookid' => array("optional", "string"),	//记事本id
	'updatefile' => array("required", "string"),	//客户端发送上传文件字符串 php会预处理 逻辑层不用再处理
);

//上传图片消息反馈
$s2c_notebook_upload_pic = array(
	'notebookid' => array("optional", "string"),	//成功返回唯一id
	'ver_id' => array("optional", "string"),	//版本号
	'errno' => array("required", "string"),			//错误码 0表示成功
	'errormsg' => array("optional", "string"),		//错误内容
);

//单个记事本信息
$s2c_notebook_info = array(
	'createtime' => array("required", "string") , 	//创建时间 格式:2015-9-10 12:10:10
	'title' => array("required", "string") , 	//标题
	'contents' => array("required", "string") , 	//内容
	'pic' => array("optional", "string"),	//图片
	'ver_id' => array("required", "string"),	//版本号
);

//列表中一个行程数据
$Notebook_info = array(
	'notebookid' => array("required", "string"),//记事本id
	'createtime' => array("required", "string") , 	//创建时间 格式:2015-9-10 12:10:10
	'title' => array("required", "string") , 	//标题
	'ver_id' => array("required", "string"),	//版本号
);

//返回记事本列表信息
$s2c_notebook_list_info = array(
	'list' => array("repeated", $Notebook_info),
);

//消息反馈
$s2c_notebook_msg = array(
	'notebookid' => array("optional", "string"),	//成功返回唯一id
	'errno' => array("required", "string"),	//错误码 0表示成功
	'errormsg' => array("required", "string"),		//错误内容
);