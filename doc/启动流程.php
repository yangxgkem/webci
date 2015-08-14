<?php

@1
index.php
//初始化参数
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
$system_path = 'system';
$application_folder = 'application';
$view_folder = '';
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', str_replace('\\', '/', $system_path));
define('FCPATH', dirname(__FILE__).'/');
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
define('VIEWPATH', $view_folder);

ENVIRONMENT:development
SELF:index.php
BASEPATH:/mnt/hgfs/web/ci/system/
FCPATH:/mnt/hgfs/web/ci/
SYSDIR:system
APPPATH:/mnt/hgfs/web/ci/application/
VIEWPATH:/mnt/hgfs/web/ci/application/views/


@2
system/core/Codeigniter.php
	@3 application/config/constants.php //宏定义

	@4 system/core/Common.php //全局函数定义

	@5 //设置错误处理函数,函数在Common.php里定义了
		set_error_handler('_error_handler');// 设置一个用户定义的错误处理函数
		set_exception_handler('_exception_handler');//自定义异常处理。
		register_shutdown_function('_shutdown_handler');//定义PHP程序执行完成后执行的函数

	@6 //重新指向扩展类前缀信息 assign_to_config

	@7 //载入composer autoload
		require_once($composer_autoload);

	@8 //加载运行时间计算模块
		$BM =& load_class('Benchmark', 'core');

	@9 //加载钩子
		$EXT =& load_class('Hooks', 'core');

	@10 //设置编码方式
		$charset = strtoupper(config_item('charset'));
		ini_set('default_charset', $charset);
		if (extension_loaded('mbstring')) //多字节字符串
		if (extension_loaded('iconv')) //iconv函数库能够完成各种字符集间的转换，是php编程中不可缺少的基础函数库。
		//mbstring 和 iconv 都是针对编码转换功能
	
	@11 //加载版本函数兼容
		require_once(BASEPATH.'core/compat/mbstring.php');
		require_once(BASEPATH.'core/compat/hash.php');
		require_once(BASEPATH.'core/compat/password.php');
		require_once(BASEPATH.'core/compat/standard.php');

	@12 //utf8处理类加载，主要是格式的转换
	$UNI =& load_class('Utf8', 'core');

	@13 //加载路由
	$URI =& load_class('URI', 'core');
	$RTR =& load_class('Router', 'core', isset($routing) ? $routing : NULL);

	@14 //加载最终内容输出给浏览器的类
	$OUT =& load_class('Output', 'core');

	@15 //加载预防跨站脚本攻击XSS
	$SEC =& load_class('Security', 'core');


