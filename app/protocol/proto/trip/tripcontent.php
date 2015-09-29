<?php

//创建一个内容
$c2s_tripcontent_create = array(
	'trip_id' => array("require", "int"), //行程id
	'name' => array("require", "string", 30), //内容名称
	'msg' => array("require", "string", 3000), //描述
	'stime' => array("require", "string"), //启动时间
	'city' => array("require", "string", 40), //城市
);
//返回创建结果
$s2c_tripcontent_create = array(
	'tripcontent_id' => array("optional", "int"), //内容唯一id 成功时返回此字段
	'ver_id' => array("optional", "string"), //版本号
);


//修改内容信息
$c2s_tripcontent_update = array(
	'tripcontent_id' => array("require", "int"), //内容id
	'name' => array("optional", "string", 30), //内容名称
	'msg' => array("optional", "string", 3000), //描述
	'stime' => array("optional", "string"), //启动时间
	'city' => array("optional", "string", 40), //城市
);
//返回更新结果
$s2c_tripcontent_update = array(
	'tripcontent_id' => array("require", "int"), //内容id 成功时返回此字段
	'ver_id' => array("optional", "string"), //版本号
);


//删除内容
$c2s_tripcontent_del = array(
	'tripcontent_id' => array("require", "int"), //内容id
);
//返回状态结果
$s2c_tripcontent_del = array(
	'tripcontent_id' => array("require", "int"), //内容id
);


//获取某行程所有内容列表
$c2s_tripcontent_list = array(
	'trip_id' => array("require", "int"), //行程id
);
//列表中一个行程数据
$Tripcontent_info = array(
	'tripcontent_id' => array("require", "int"), //内容id
	'ver_id' => array("require", "string"), //版本号
	'name' => array("require", "string"), //内容名称
	'msg' => array("require", "string"), //描述
	'stime' => array("require", "string"), //启动时间
	'city' => array("require", "string"), //城市
	'photo_1' => array("optional", "string"), //照片1
	'photo_2' => array("optional", "string"), //照片2
	'photo_3' => array("optional", "string"), //照片3
);
//返回列表数据
$s2c_tripcontent_list = array(
	'list' => array("repeated", $Tripcontent_info),
);


//上传照片
$c2s_tripcontent_upload = array(
	'tripcontent_id' => array("require", "int"), //内容id
	'photo_id' => array("require", "int"), //照片id 1-3
);
//返回结果
$s2c_tripcontent_upload = array(
	'tripcontent_id' => array("require", "int"), //内容id
	'ver_id'  => array("optional", "string"), //图片访问地址
	'url' => array("optional", "string"), //版本号
);