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
	cmd = "apt-get update"
	safe_exec(cmd)
	
	#去除portmap nfs
	cmd = "/etc/init.d/portmap stop"
	safe_exec(cmd)
	cmd = "/etc/init.d/nfs-common stop"
	safe_exec(cmd)
	cmd = "update-rc.d -f portmap remove"
	safe_exec(cmd)
	cmd = "update-rc.d -f nfs-common remove"
	safe_exec(cmd)
	
	print "sys_optimize  successful!!"


#添加系统用户
def add_all_user():
	all_user = (
		("yangxg","ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAAAgQCt10oJtgagUsy0jCwO7Q9KC+3khaSSbf2LYjOLSY5ODUB/7kuioA4R3Alu3achLinFZmfLGO0ufGxvBvUEaiwyL1YuZpBvgUxhzT4aRuKaDVpc8XkeN9AIwTUXY/T2ObKDYqN7Vmm9cfPfIvKD7uQtiQxQLB90Gvw1s/rU4GBgrQ== "),
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
	#install gcc
	cmd = "apt-get install gcc"
	safe_exec(cmd)

	#install vim
	cmd = "apt-get install vim"
	safe_exec(cmd)

	#install rsync
	cmd = "apt-get install rsync"
	safe_exec(cmd)
	
	#install killall
	cmd = "apt-get install psmisc"
	safe_exec(cmd)
	
	#install lua
	cmd = "apt-get install lua5.1"
	safe_exec(cmd)
	cmd = "apt-get install lua5.3"
	safe_exec(cmd)

	#mysql
	cmd = "apt-get install mysql-server"
	safe_exec(cmd)
	cmd = "apt-get install mysql-client"
	safe_exec(cmd)

	#memcached
	cmd = "apt-get install memcached"
	safe_exec(cmd)

	#autoconf
	cmd = "apt-get install autoconf"
	safe_exec(cmd)

	#libreadline-dev
	cmd = "apt-get install libreadline-dev"
	safe_exec(cmd)

	#google-perftools 启动引擎所需
	cmd = "apt-get install google-perftools"
	safe_exec(cmd)

	#protobuf
	cmd = "apt-get install protobuf-compiler"
	safe_exec(cmd)

	#nginx
	cmd = "apt-get install nginx"
	safe_exec(cmd)

	#php5
	cmd = "apt-get install php5"
	safe_exec(cmd)

	#php5-fpm
	cmd = "apt-get install php5-fpm"
	safe_exec(cmd)

	#php5-cli
	cmd = "apt-get install php5-cli"
	safe_exec(cmd)

	#php5-memcached
	cmd = "apt-get install php5-memcached"
	safe_exec(cmd)

	#php5-memcache
	cmd = "apt-get install php5-memcache"
	safe_exec(cmd)

	#php5-curl
	cmd = "apt-get install php5-curl"
	safe_exec(cmd)

	print "init_sys successful!!"


def init_mysql():
	if not is_root_run():
		print "is not root whoami"
		return False
	if os.path.exists("/etc/mysql/my.conf"):
		cmd = "cp  /etc/mysql/my.conf /etc/mysql/my.conf.default"
		safe_exec(cmd)
		cmd = "cp  ./mysql_my.conf /etc/mysql/my.conf"
		safe_exec(cmd)
	cmd = "service mysql restart"
	safe_exec(cmd)
	print "init_mysql successful!!"


def init_memcached():
	if not is_root_run():
		print "is not root whoami"
		return False
	if os.path.exists("/etc/memcached.conf"):
		cmd = "cp  /etc/memcached.conf /etc/memcached.conf.default"
		safe_exec(cmd)
		cmd = "cp  ./memcached.conf /etc/memcached.conf"
		safe_exec(cmd)
	cmd = "service memcached restart"
	safe_exec(cmd)
	print "init_memcached successful!!"


def init_nginx():
	if not is_root_run():
		print "is not root whoami"
		return False
	if os.path.exists("/etc/nginx/nginx.conf"):
		cmd = "cp  /etc/nginx/nginx.conf /etc/nginx/nginx.conf.default"
		safe_exec(cmd)
		cmd = "cp  ./nginx_nginx.conf /etc/nginx/nginx.conf"
		safe_exec(cmd)
	if os.path.exists("/etc/nginx/sites-available/default"):
		cmd = "cp  /etc/nginx/sites-available/default /etc/nginx/sites-available/default.default"
		safe_exec(cmd)
		cmd = "cp  ./nginx_default.conf /etc/nginx/sites-available/default"
		safe_exec(cmd)
		cmd = "cp  ./nginx_ci.conf /etc/nginx/sites-available/nginx_ci.conf"
		safe_exec(cmd)
		cmd = "cp  ./nginx_assets.conf /etc/nginx/sites-available/nginx_assets.conf"
		safe_exec(cmd)
	cmd = "service nginx restart"
	safe_exec(cmd)
	print "init_nginx successful!!"



cmdTable = (
	("sys_optimize", "第一步：系统优化", ""),
	("add_all_user" , "第二步：添加系统用户,此步骤可不执行", ""),
	("init_sys", "第三步：系统初始化及安装基本软件", ""),
	("init_mysql","第四步：配置mysql,没有涉及读写分离配置",""),
	("init_memcached","第五步：配置memcached",""),
	("init_nginx","第六步：配置nginx",""),
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