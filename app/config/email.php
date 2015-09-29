<?php
defined('BASEPATH') OR exit('No direct script access allowed');



//用户代理 'user agent'
$config['useragent'] = 'CodeIgniter';

//mail, sendmail, or smtp	邮件发送协议
$config['protocol'] = 'smtp';

//服务器上 Sendmail 的实际路径。protocol 为 sendmail 时使用
$config['mailpath']  = '/usr/sbin/sendmail';

//smtp服务器地址
//$config['smtp_host'] = 'smtp.163.com';
$config['smtp_host'] = 'smtp.exmail.qq.com';

//smtp用户账户
$config['smtp_user'] = '******@***.com';

//smtp用户密码
$config['smtp_pass'] = '******';

//smtp端口
$config['smtp_port'] = 25;

//stmp超时设置
$config['smtp_timeout'] = 5;

//是否启用 SMTP 持久连接
$config['smtp_keepalive'] = FALSE;

//tls or ssl	SMTP 加密方式
$config['smtp_crypto'] = 'tls';

//开启自动换行
$config['wordwrap'] = TRUE;

//自动换行时每行的最大字符数
$config['wrapchars'] = 76;

//邮件类型。发送 HTML 邮件比如是完整的网页。请确认网页中是否有相对路径的链接和图片地址，它们在邮件中不能正确显示
$config['mailtype'] = 'html';

//字符集(utf-8, iso-8859-1 等)
$config['charset'] = 'utf-8';

//是否验证邮件地址
$config['validate'] = FALSE;

//Email 优先级. 1 = 最高. 5 = 最低. 3 = 正常
$config['priority'] = 1;

//换行符 这两项千万不能修改 否则腾讯服务器将无法发送
$config['crlf']  = "\r\n";
$config['newline']="\r\n";

//启用批量暗送模式
$config['bcc_batch_mode'] = TRUE;

//批量暗送的邮件数
$config['bcc_batch_size'] = 200;
