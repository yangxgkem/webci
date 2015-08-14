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

	add_user("sngame")#游戏进程用户
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

	#autoconf
	cmd = "apt-get install autoconf"
	safe_exec(cmd)

	#libreadline-dev
	cmd = "apt-get install libreadline-dev"
	safe_exec(cmd)

	#google-perftools 启动万将引擎所需
	cmd = "apt-get install google-perftools"
	safe_exec(cmd)

	#protobuf
	cmd = "apt-get install protobuf-compiler"
	safe_exec(cmd)

	#nginx
	cmd = "apt-get install nginx"
	safe_exec(cmd)

	#php
	cmd = "apt-get install php5"
	safe_exec(cmd)

	print "init_sys successful!!"

#配置ssh
def init_ssh():
	sshd_config = """
# Package generated configuration file
# See the sshd_config(5) manpage for details

# What ports, IPs and protocols we listen for
Port 32233
# Use these options to restrict which interfaces/protocols sshd will bind to
#ListenAddress ::
#ListenAddress 0.0.0.0
Protocol 2
# HostKeys for protocol version 2
HostKey /etc/ssh/ssh_host_rsa_key
HostKey /etc/ssh/ssh_host_dsa_key
#Privilege Separation is turned on for security
UsePrivilegeSeparation yes

# Lifetime and size of ephemeral version 1 server key
KeyRegenerationInterval 3600
ServerKeyBits 768

# Logging
SyslogFacility AUTH
LogLevel INFO

# Authentication:
LoginGraceTime 120
PermitRootLogin no
StrictModes yes

RSAAuthentication yes
PubkeyAuthentication yes
#AuthorizedKeysFile     %h/.ssh/authorized_keys

# Don't read the user's ~/.rhosts and ~/.shosts files
IgnoreRhosts yes
# For this to work you will also need host keys in /etc/ssh_known_hosts
RhostsRSAAuthentication no
# similar for protocol version 2
HostbasedAuthentication no
# Uncomment if you don't trust ~/.ssh/known_hosts for RhostsRSAAuthentication
#IgnoreUserKnownHosts yes

# To enable empty passwords, change to yes (NOT RECOMMENDED)
PermitEmptyPasswords no

# Change to yes to enable challenge-response passwords (beware issues with
# some PAM modules and threads)
ChallengeResponseAuthentication no

# Change to no to disable tunnelled clear text passwords
PasswordAuthentication no

# Kerberos options
#KerberosAuthentication no
#KerberosGetAFSToken no
#KerberosOrLocalPasswd yes
#KerberosTicketCleanup yes

# GSSAPI options
#GSSAPIAuthentication no
#GSSAPICleanupCredentials yes

X11Forwarding yes
X11DisplayOffset 10
PrintMotd no
PrintLastLog yes
TCPKeepAlive yes
#UseLogin no

#MaxStartups 10:30:60
#Banner /etc/issue.net

# Allow client to pass locale environment variables
AcceptEnv LANG LC_*

Subsystem sftp /usr/lib/openssh/sftp-server

# Set this to 'yes' to enable PAM authentication, account processing,
# and session processing. If this is enabled, PAM authentication will
# be allowed through the ChallengeResponseAuthentication and
# PasswordAuthentication.  Depending on your PAM configuration,
# PAM authentication via ChallengeResponseAuthentication may bypass
# the setting of "PermitRootLogin without-password".
# If you just want the PAM account and session checks to run without
# PAM authentication, then enable this but set PasswordAuthentication
# and ChallengeResponseAuthentication to 'no'.
UsePAM yes
"""
	if os.path.exists("/etc/ssh/sshd_config"):
		cmd = "cp  /etc/ssh/sshd_config /etc/ssh/sshd_config.default"
		safe_exec(cmd)
	fp=open("/etc/ssh/sshd_config","w")
	fp.write(sshd_config)
	fp.write("\n")
	fp.close()
	cmd = "/usr/sbin/sshd &"
	safe_exec(cmd)
	print "sshd start on Port 32233 "


#配置rsync
def init_rsync():
	#rsyncd.conf
	rsyncd_conf="""
uid = yangxg
id = yangxg
max connections = 200
timeout = 600
use chroot = no
read only = yes
port = 29989
log file=/home/rsync/work/run/rsyncd.log
[mcs]
    comment = upload
    path = /home/rsync/work/upload/mcs/
    use chroot = yes
    max connections = 20
    read only = false
    list = true
    auth users = upload
    secrets file = /etc/rsyncd/rsyncd.secrets

[client]
    comment = upload
    path = /home/rsync/work/upload/client/
    use chroot = yes
    max connections = 20
    read only = false
    list = true
    auth users = upload
    secrets file = /etc/rsyncd/rsyncd.secrets
[server]
    comment = upload
    path = /home/rsync/work/upload/server/
    use chroot = yes
    max connections = 20
    read only = false
    list = true
    auth users = upload
    secrets file = /etc/rsyncd/rsyncd.secrets
"""
	#rsyncd.secrets
	rsyncd_secrets="""
upload:sngameasdfzxcv
"""
	#rsyncd.motd
	rsyncd_motd="""
---------------------------
upload passwd:sngameasdfzxcv
---------------------------
"""
	if not is_root_run():
		print "is not root whoami"
		return False
	#创建上传目录
	cmd = "mkdir -vp -m 777 /home/rsync/work/upload/mcs"
	safe_exec(cmd)
	cmd = "mkdir -m 777 /home/rsync/work/upload/server"
	safe_exec(cmd)
	cmd = "mkdir -m 777 /home/rsync/work/upload/client"
	safe_exec(cmd)
	cmd = "mkdir /home/rsync/work/run"
	safe_exec(cmd)
	#配置rsync目录
	cmd = "mkdir /etc/rsyncd"
	safe_exec(cmd)

	append_write("/etc/rsyncd/rsyncd.conf", rsyncd_conf)
	append_write("/etc/rsyncd/rsyncd.secrets", rsyncd_secrets)
	append_write("/etc/rsyncd/rsyncd.motd", rsyncd_motd)
	cmd = "chmod 600 /etc/rsyncd/rsyncd.secrets"
	safe_exec(cmd)

	#启动rsync服务：
	cmd = '/usr/bin/rsync --daemon --port=29989 --verbose --config=/etc/rsyncd/rsyncd.conf'
	safe_exec(cmd)

	print "init_rsync successful!!"

def init_mysql():
	#/etc/mysql/my.conf
	my_conf="""
#
# The MySQL database server configuration file.
#
# You can copy this to one of:
# - "/etc/mysql/my.cnf" to set global options,
# - "~/.my.cnf" to set user-specific options.
# 
# One can use all long options that the program supports.
# Run program with --help to get a list of available options and with
# --print-defaults to see which it would actually understand and use.
#
# For explanations see
# http://dev.mysql.com/doc/mysql/en/server-system-variables.html

# This will be passed to all mysql clients
# It has been reported that passwords should be enclosed with ticks/quotes
# escpecially if they contain "#" chars...
# Remember to edit /etc/mysql/debian.cnf when changing the socket location.
[client]
default-character-set=utf8
port            = 3306
socket          = /var/run/mysqld/mysqld.sock

# Here is entries for some specific programs
# The following values assume you have at least 32M ram

# This was formally known as [safe_mysqld]. Both versions are currently parsed.
[mysqld_safe]
socket          = /var/run/mysqld/mysqld.sock
nice            = 0

[mysqld]
#
# * Basic Settings
#
character_set_server=utf8
user            = mysql
pid-file        = /var/run/mysqld/mysqld.pid
socket          = /var/run/mysqld/mysqld.sock
port            = 3306
basedir         = /usr
datadir         = /var/lib/mysql
tmpdir          = /tmp
lc-messages-dir = /usr/share/mysql
skip-external-locking
#
# Instead of skip-networking the default is now to listen only on
# localhost which is more compatible and is not less secure.
bind-address            = 0.0.0.0
#
# * Fine Tuning
#
key_buffer              = 16M
max_allowed_packet      = 16M
thread_stack            = 192K
thread_cache_size       = 8
# This replaces the startup script and checks MyISAM tables if needed
# the first time they are touched
myisam-recover         = BACKUP
#max_connections        = 100
#table_cache            = 64
#thread_concurrency     = 10
#
# * Query Cache Configuration
#
query_cache_limit       = 1M
query_cache_size        = 16M
#
# * Logging and Replication
#
# Both location gets rotated by the cronjob.
# Be aware that this log type is a performance killer.
# As of 5.1 you can enable the log at runtime!
#general_log_file        = /var/log/mysql/mysql.log
#general_log             = 1
#
# Error log - should be very few entries.
#
log_error = /var/log/mysql/error.log
#
# Here you can see queries with especially long duration
#log_slow_queries       = /var/log/mysql/mysql-slow.log
#long_query_time = 2
#log-queries-not-using-indexes
#
# The following can be used as easy to replay backup logs or for replication.
# note: if you are setting up a replication slave, see README.Debian about
#       other settings you may need to change.
#server-id              = 1
#log_bin                        = /var/log/mysql/mysql-bin.log
expire_logs_days        = 10
max_binlog_size         = 100M
#binlog_do_db           = include_database_name
#binlog_ignore_db       = include_database_name
#
# * InnoDB
#
# InnoDB is enabled by default with a 10MB datafile in /var/lib/mysql/.
# Read the manual for more InnoDB related options. There are many!
#
# * Security Features
#
# Read the manual, too, if you want chroot!
# chroot = /var/lib/mysql/
#
# For generating SSL certificates I recommend the OpenSSL GUI "tinyca".
#
# ssl-ca=/etc/mysql/cacert.pem
# ssl-cert=/etc/mysql/server-cert.pem
# ssl-key=/etc/mysql/server-key.pem



[mysqldump]
quick
quote-names
max_allowed_packet      = 16M

[mysql]
#no-auto-rehash # faster start of mysql but no tab completition

[isamchk]
key_buffer              = 16M

#
# * IMPORTANT: Additional settings that can override those from this file!
#   The files must end with '.cnf', otherwise they'll be ignored.
#
!includedir /etc/mysql/conf.d/
"""

	if not is_root_run():
		print "is not root whoami"
		return False
	if os.path.exists("/etc/mysql/my.conf"):
		cmd = "cp  /etc/mysql/my.conf /etc/mysql/my.conf.default"
		safe_exec(cmd)
	fp=open("/etc/mysql/my.conf","w")
	fp.write(my_conf)
	fp.write("\n")
	fp.close()
	cmd = "service mysql restart"
	safe_exec(cmd)
	print "init_mysql successful!!"



cmdTable = (
	("sys_optimize", "第一步：系统优化", ""),
	("add_all_user" , "第二步：添加系统用户", ""),
	("init_sys", "第三步：系统初始化及安装基本软件", ""),
	("init_rsync","第四步：配置rsync",""),
	("init_ssh","第五步：配置ssh",""),
	("init_mysql","第六步：配置mysql",""),
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