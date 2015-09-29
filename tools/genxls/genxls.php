<?php

require_once "gen/base/xls.php";

//指令数据
function gen_cmd($xlsObj) {
	require_once "gen/cmd/gen_cmd.php";
	DoGen($xlsObj);
}

//gen all
function gen_all($xlsObj) {
	$actions = $GLOBALS['Actions'];
	$ignore = array("genall");
	foreach ($actions as $key => $value) {
		if (! in_array($key, $ignore)) {
			$value($xlsObj);
		}
	}
}


//指令集合
$Actions = array(
	"cmd" => "gen_cmd",//指令数据
	"genall" => "gen_all",//所有导表
);


function gen($argv) {
	if (count($argv)<=1) {
		echo "\nplease input action. eg: php genxls.php genall\n\n";
		return;
	}
	$actions = $GLOBALS['Actions'];
	$xlsObj = new xls();
	for ($i=1; $i<count($argv); $i++) {
		$act = $actions[($argv[$i])];
		$act($xlsObj);
	}
	echo "\ngen success!!!\n\n";
}
gen($argv);