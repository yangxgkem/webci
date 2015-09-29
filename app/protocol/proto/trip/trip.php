<?php

//创建一个行程
$c2s_trip_create = array(
	'guide_id' => array("require", "int"), //导游id
	'source' => array("require", "string", 60), //出发点
	'des' => array("require", "string"), //目的地
	'stime' => array("require", "string"), //开始时间
	'etime' => array("require", "string"), //返回时间
	'tour' => array("optional", "string", 60), //参团社
	'travel' => array("optional", "string", 60), //地接社
	'joinnum' => array("optional", "int"), //参团人数
	'guide_name' => array("optional", "string", 150), //全陪导游
	'traffic' => array("optional", "string", 60), //远途交通
);
//返回创建结果
$s2c_trip_create = array(
	'trip_id' => array("optional", "int"), //行程唯一id 成功时返回此字段
	'ver_id' => array("optional", "string"), //版本号
);



//修改行程基本信息
$c2s_trip_update = array(
	'trip_id' => array("require", "int"), //行程id
	'source' => array("optional", "string", 60), //出发点
	'des' => array("optional", "string"), //目的地
	'stime' => array("optional", "string"), //开始时间
	'etime' => array("optional", "string"), //返回时间
	'tour' => array("optional", "string", 60), //参团社
	'travel' => array("optional", "string", 60), //地接社
	'joinnum' => array("optional", "int"), //参团人数
	'guide_name' => array("optional", "string", 150), //全陪导游
	'traffic' => array("optional", "string", 60), //远途交通
	'status' => array("optional", "int"), //1激活状态 0未激活状态
);
//返回更新结果
$s2c_trip_update = array(
	'trip_id' => array("require", "int"), //行程唯一id 成功时返回此字段
	'ver_id' => array("require", "string"), //版本号
);



//删除行程
$c2s_trip_del = array(
	'trip_id' => array("require", "int"), //行程id
);
//返回状态结果
$s2c_trip_del = array(
	'trip_id' => array("require", "int"), //行程唯一id 成功时返回此字段
);



//获取所有行程列表
$c2s_trip_list = array(
	'guide_id' => array("require", "string"), //导游id
);
//列表中一个行程数据
$Trip_info = array(
	'trip_id' => array("require", "int"), //行程id
	'ver_id' => array("require", "string"), //版本号
	'source' => array("require", "string", 60), //出发点
	'des' => array("require", "string"), //目的地
	'stime' => array("require", "string"), //开始时间
	'etime' => array("require", "string"), //返回时间
	'tour' => array("optional", "string", 60), //参团社
	'travel' => array("optional", "string", 60), //地接社
	'joinnum' => array("optional", "int"), //参团人数
	'guide_name' => array("optional", "string", 150), //全陪导游
	'traffic' => array("optional", "string", 60), //远途交通
	'status' => array("require", "int"), //状态
);
//返回列表数据
$s2c_trip_list = array(
	'list' => array("repeated", $Trip_info),
);



