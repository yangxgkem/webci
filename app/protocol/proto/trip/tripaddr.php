<?php

//创建一个通讯录
$c2s_tripaddr_create = array(
	'trip_id' => array("require", "int"), //行程id
	'name' => array("require", "string", 45), //名称
	'phone' => array("require", "string", 25), //电话
	'sex' => array("require", "int"), //性别
	'id_card' => array("optional", "string", 20), //身份证
	'place' => array("optional", "string", 45), //籍贯
	'impress_01' => array("optional", "string", 18), //我的印象
	'impress_02' => array("optional", "string", 18), //我的印象
	'impress_03' => array("optional", "string", 18), //我的印象
	'impress_04' => array("optional", "string", 18), //我的印象
	'impress_05' => array("optional", "string", 18), //我的印象
	'impress_06' => array("optional", "string", 18), //我的印象
	'is_star' => array("optional", "int"), //是否置顶
);
//返回创建结果
$s2c_tripaddr_create = array(
	'tripaddr_id' => array("optional", "int"), //游客唯一id 成功时返回此字段
	'ver_id' => array("optional", "string"), //版本号
);


//修改游客信息
$c2s_tripaddr_update = array(
	'tripaddr_id' => array("require", "int"), //游客id
	'name' => array("optional", "string", 45), //名称
	'phone' => array("optional", "string", 25), //电话
	'sex' => array("optional", "int"), //性别
	'id_card' => array("optional", "string", 20), //身份证
	'place' => array("optional", "string", 45), //籍贯
	'impress_01' => array("optional", "string", 18), //我的印象
	'impress_02' => array("optional", "string", 18), //我的印象
	'impress_03' => array("optional", "string", 18), //我的印象
	'impress_04' => array("optional", "string", 18), //我的印象
	'impress_05' => array("optional", "string", 18), //我的印象
	'impress_06' => array("optional", "string", 18), //我的印象
	'is_star' => array("optional", "int"), //是否置顶
);
//返回更新结果
$s2c_tripaddr_update = array(
	'tripaddr_id' => array("require", "int"), //内容id 成功时返回此字段
	'ver_id' => array("optional", "string"), //版本号
);

//删除某游客
$c2s_tripaddr_del = array(
	'tripaddr_id' => array("require", "int"), //游客id
);
//返回状态结果
$s2c_tripaddr_del = array(
	'tripaddr_id' => array("optional", "int"), //游客id
);


//获取某行程所有通讯录列表
$c2s_tripaddr_list = array(
	'trip_id' => array("require", "int"), //行程id
);
//列表中一个行程数据
$Tripaddr_info = array(
	'tripaddr_id' => array("require", "int"), //游客id
	'name' => array("require", "string", 45), //名称
	'phone' => array("require", "string", 25), //电话
	'sex' => array("optional", "int"), //性别
	'id_card' => array("optional", "string", 20), //身份证
	'place' => array("optional", "string", 45), //籍贯
	'impress_01' => array("optional", "string", 18), //我的印象
	'impress_02' => array("optional", "string", 18), //我的印象
	'impress_03' => array("optional", "string", 18), //我的印象
	'impress_04' => array("optional", "string", 18), //我的印象
	'impress_05' => array("optional", "string", 18), //我的印象
	'impress_06' => array("optional", "string", 18), //我的印象
	'is_star' => array("optional", "int"), //是否置顶
);
//返回列表数据
$s2c_tripaddr_list = array(
	'list' => array("repeated", $Tripaddr_info),
);


//根据游客号码获取云端印象
$c2s_tripaddr_impress = array(
	'phone' => array("require", "string", 25), //电话号码
);

$Tripaddr_impress_info = array(
	'impress' => array("require", "string"),
	'usenum' => array("require", "int"),
);

//返回印象列表
$s2c_tripaddr_impress = array(
	'list' => array("repeated", $Tripaddr_impress_info),
);