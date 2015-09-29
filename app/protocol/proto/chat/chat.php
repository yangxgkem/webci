<?php

//提示协议
$s2c_chat_notify = array(
	'errno' => array("require", "int"), //提示编号 (400-499为错误提示)
	'errmsg' => array("require", "string"), //提示内容
);