#-*- coding: utf-8 -*-
#!/usr/local/bin/python

import sys,os,string,dircache,commands,re,shutil,time,fcntl

#执行系统指令
def safe_exec(cmd):
	status = os.system(cmd)
	status >>= 8
	return status

#读取文件数据
def read(file):
	fp = open(file)
	ret = fp.read()
	fp.close()
	return ret

#重写文件数据
def write(file, content):
	fp = open(file, "w+")
	fp.write(content)
	fp.close()

#追加文件数据
def append_write(file, content):
	fp = open(file, "a+")
	fp.write(content)
	fp.close()

#脚本执行用户 commands.getoutput执行linux指令 返回执行结果
def whoami():
	return commands.getoutput("whoami")

#当前是否root用户
def is_root_run():
	if whoami() == "root":
		return True
	else:
		return False

#打印指令信息
def usage():
	print ""
	for cmdinfo in cmdTable:
		print " ", cmdinfo[1], ":", sys.argv[0], cmdinfo[0], cmdinfo[2]
	print ""

#判断系统是否含有此用户
def is_has_user(username):
	cmd = "id %s" % username
	data = commands.getoutput(cmd)
	if data.find("uid=") != -1:
		return True
	else:
		return False


#系统优化
def sys_optimize():
	#进程文件句柄
	limits_content = """
* soft nofile 65535
* hard nofile 65535
* soft nproc 65535
* hard nproc 65535
"""
	append_write("/etc/security/limits.conf", limits_content)
	ulimit_content="""
ulimit -n 65535
ulimit -c unlimited
ulimit -m unlimited
ulimit -s unlimited
ulimit -t unlimited
ulimit -v unlimited
"""
	append_write("/etc/profile",ulimit_content)

	#更新软件
	cmd = "yum update"
	safe_exec(cmd)

	#关闭selinux
	selinux_content="""
# This file controls the state of SELinux on the system.
# SELINUX= can take one of these three values:
#     enforcing - SELinux security policy is enforced.
#     permissive - SELinux prints warnings instead of enforcing.
#     disabled - No SELinux policy is loaded.
#SELINUX=enforcing
# SELINUXTYPE= can take one of these two values:
#     targeted - Targeted processes are protected,
#     mls - Multi Level Security protection.
#SELINUXTYPE=targeted 
SELINUX=disabled
"""
	write("/etc/selinux/config", selinux_content)
	
	#开启防火墙相应端口，apache需要开启80端口  MySQL需要开启3306端口
	iptables_content="""
# Firewall configuration written by system-config-firewall
# Manual customization of this file is not recommended.
*filter
:INPUT ACCEPT [0:0]
:FORWARD ACCEPT [0:0]
:OUTPUT ACCEPT [0:0]
-A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
-A INPUT -p icmp -j ACCEPT
-A INPUT -i lo -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 22 -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 3306 -j ACCEPT
-A INPUT -j REJECT --reject-with icmp-host-prohibited
-A FORWARD -j REJECT --reject-with icmp-host-prohibited
COMMIT
"""
	write("/etc/sysconfig/iptables", iptables_content)
	cmd = "/etc/init.d/iptables restart"
	safe_exec(cmd)

	#使配置立即生效
	cmd = "setenforce 0"
	safe_exec(cmd)
	
	print "sys_optimize  successful!!"


#添加源
def add_rpm():
	#下载atomic源Atomic仓库支持哪些软件可以到这个地址查看：http://www.atomicorp.com/channels/atomic/, 有php、mysql、nginx、openvas、memcached、php-zend-guard-loader等软件
	cmd = "wget -q -O - http://www.atomicorp.com/installers/atomic | sh"
	safe_exec(cmd)

	#下载网易源 http://mirrors.163.com/.help/centos.html
	cmd = "mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup"
	safe_exec(cmd)
	cmd = "wget http://mirrors.163.com/.help/CentOS6-Base-163.repo"
	safe_exec(cmd)
	cmd = "mv CentOS6-Base-163.repo /etc/yum.repos.d/"
	safe_exec(cmd)
	#缓存更新
	cmd = "yum clean all"
	safe_exec(cmd)
	cmd = "yum makecache"
	safe_exec(cmd)

	print "add_rpm  successful!!"


#添加系统用户
def add_all_user():
	all_user = (
	)
	for data in all_user:
		username = data[0]
		keydata = data[1]
		add_user(username, keydata)

	add_user("hitu")#web进程用户
	print "add_all_user successful!!"


#添加用户
def add_user(username, keydata=None):
	if is_has_user(username):
		return False
	print "add_user", username, keydata
	cmd = "useradd -s /bin/bash -m -G root sudo %s" % username
	safe_exec(cmd)
	cmd = "mkdir -p /home/%s/.ssh" % username
	safe_exec(cmd)
	if keydata:
		cmd = "echo %s>>/home/%s/.ssh/authorized_keys" % (keydata, username)
		safe_exec(cmd)
	cmd = "chown -R %s:%s /home/%s" % (username, username, username)
	safe_exec(cmd)
	cmd = "chmod 700 /home/%s" % (username)
	safe_exec(cmd)
	cmd = "chmod 644 /home/%s/.ssh/authorized_keys" % (username)
	safe_exec(cmd)


#系统软件安装
def init_sys():
	#安装开发包和库文件
	cmd = "yum -y install ntp make openssl openssl-devel pcre pcre-devel libpng libpng-devel libjpeg-6b libjpeg-devel-6b freetype"
	safe_exec(cmd)
	cmd = "yum -y install freetype-devel gd gd-devel zlib zlib-devel gcc gcc-c++ libXpm libXpm-devel ncurses ncurses-devel libmcrypt"
	safe_exec(cmd)
	cmd = "yum -y install libmcrypt-devel libxml2 libxml2-devel imake autoconf automake screen sysstat compat-libstdc++-33 curl curl-devel"
	safe_exec(cmd)

	#卸载已安装的apache、mysql、php
	cmd = "yum remove httpd mysql php"
	safe_exec(cmd)
	
	#安装其他相关
	cmd = "yum install rsync psmisc autoconf lua"
	safe_exec(cmd)

	#nginx
	cmd = "yum install nginx"
	safe_exec(cmd)

	#mysql
	cmd = "yum install mysql mysql-server mysql-devel"
	safe_exec(cmd)

	#memcached
	cmd = "yum install memcached"
	safe_exec(cmd)

	#php
	cmd = "yum install php lighttpd-fastcgi php-cli php-mysql php-gd php-imap php-ldap php-odbc php-pear php-xml php-xmlrpc php-mbstring"
	safe_exec(cmd)
	cmd = "php-tidy php-common php-devel php-fpm php-mcrypt php-mssql php-snmp php-soap"
	safe_exec(cmd)

	print "init_sys successful!!"


cmdTable = (
	("sys_optimize", "第一步：系统优化", ""),
	("add_rpm", "第二步：添加源", ""),
	("add_all_user" , "第三步：添加系统用户,此步骤可不执行", ""),
	("init_sys", "第四步：系统初始化及安装基本软件", ""),
)

#main
def Main(cmd, *args):
	assert cmd, "need action"
	function = None
	try:
		function = eval(cmd)
	except NameError:
		print "action '%s' is invalid" % cmd
		return

	assert function, "action %s is invalid" % cmd

	function(*args)

if __name__=='__main__':
	if len(sys.argv) < 2:
		usage()
		sys.exit(0)
	try:
		Main(*(sys.argv[1:]))
	except AssertionError, value:
		print "  AssertionError:", value