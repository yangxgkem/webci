mysql读写分离配置

=====================================================master

### 配置my.cnf:
server-id               = 1 #master id
log_bin                 = /var/log/mysql/mysql-bin.log #slave会基于此log-bin来做replication
expire_logs_days        = 60 #日志存活时间
max_binlog_size         = 1024M #日志最大size
#binlog_do_db           = include_database_name #用于master-slave的具体数据库 逗号隔开
#binlog_ignore_db       = include_database_name #忽略哪些用于master-slave的具体数据库 逗号隔开



### 重启mysql
/etc/init.d/mysql stop
/etc/init.d/mysql start


### 进入mysql查看master状态:
mysql> show master status;
+------------------+----------+--------------+------------------+
| File             | Position | Binlog_Do_DB | Binlog_Ignore_DB |
+------------------+----------+--------------+------------------+
| mysql-bin.000001 |      107 |              |                  |
+------------------+----------+--------------+------------------+
1 row in set (0.00 sec)



### repl用户必须具有REPLICATION SLAVE权限，除此之外没有必要添加不必要的权限，密码为mysql。
### 说明一下192.168.0.%，这个配置是指明repl用户所在服务器，这里%是通配符，表示192.168.0.0 - 192.168.0.255的Server都可以以repl用户登陆主服务器。
### 当然你也可以指定固定Ip。
mysql> grant replication slave on *.* to 'repl'@'192.168.247.%' identified by 'mysql';
Query OK, 0 rows affected (0.00 sec)

### 查看用户信息
mysql> use mysql;
mysql> select host,user, Select_priv,Insert_priv,Update_priv,Delete_priv from user; 



=====================================================slave

### 配置my.cnf:
server-id               = 2 #slave id


### 重启mysql
/etc/init.d/mysql stop
/etc/init.d/mysql start


### 执行指令选择master:
change master to master_host='192.168.247.129', #服务器IP
master_port=3306, #服务器mysql 端口
master_user='repl', #用户名
master_password='mysql', #密码
master_log_file='mysql-bin.000002', #当前master日志写在哪个文件 由master的 mysql> show master status; 查看获得
master_log_pos=337; #当前日志写到哪位置 由master的 mysql> show master status; 查看获得


mysql> change master to master_host='192.168.247.129',
    -> master_port=3306,
    -> master_user='repl',
    -> master_password='mysql', 
    -> master_log_file='mysql-bin.000002',
    -> master_log_pos=337;
Query OK, 0 rows affected (0.00 sec)


### 启动slave
mysql> slave start;
Query OK, 0 rows affected (0.00 sec)



### 查看slave状态
mysql> show slave status;
+----------------------------------+-----------------+-------------+-------------+---------------+------------------+---------------------+-------------------------+---------------+-----------------------+------------------+-------------------+-----------------+---------------------+--------------------+------------------------+-------------------------+-----------------------------+------------+------------+--------------+---------------------+-----------------+-----------------+----------------+---------------+--------------------+--------------------+--------------------+-----------------+-------------------+----------------+-----------------------+-------------------------------+---------------+---------------+----------------+----------------+-----------------------------+------------------+
| Slave_IO_State                   | Master_Host     | Master_User | Master_Port | Connect_Retry | Master_Log_File  | Read_Master_Log_Pos | Relay_Log_File          | Relay_Log_Pos | Relay_Master_Log_File | Slave_IO_Running | Slave_SQL_Running | Replicate_Do_DB | Replicate_Ignore_DB | Replicate_Do_Table | Replicate_Ignore_Table | Replicate_Wild_Do_Table | Replicate_Wild_Ignore_Table | Last_Errno | Last_Error | Skip_Counter | Exec_Master_Log_Pos | Relay_Log_Space | Until_Condition | Until_Log_File | Until_Log_Pos | Master_SSL_Allowed | Master_SSL_CA_File | Master_SSL_CA_Path | Master_SSL_Cert | Master_SSL_Cipher | Master_SSL_Key | Seconds_Behind_Master | Master_SSL_Verify_Server_Cert | Last_IO_Errno | Last_IO_Error | Last_SQL_Errno | Last_SQL_Error | Replicate_Ignore_Server_Ids | Master_Server_Id |
+----------------------------------+-----------------+-------------+-------------+---------------+------------------+---------------------+-------------------------+---------------+-----------------------+------------------+-------------------+-----------------+---------------------+--------------------+------------------------+-------------------------+-----------------------------+------------+------------+--------------+---------------------+-----------------+-----------------+----------------+---------------+--------------------+--------------------+--------------------+-----------------+-------------------+----------------+-----------------------+-------------------------------+---------------+---------------+----------------+----------------+-----------------------------+------------------+
| Waiting for master to send event | 192.168.247.129 | repl        |        3306 |            60 | mysql-bin.000002 |                 777 | mysqld-relay-bin.000002 |           363 | mysql-bin.000002      | Yes              | Yes               |                 |                     |                    |                        |                         |                             |          0 |            |            0 |                 777 |             520 | None            |                |             0 | No                 |                    |                    |                 |                   |                |                     0 | No                            |             0 |               |              0 |                |                             |                1 |
+----------------------------------+-----------------+-------------+-------------+---------------+------------------+---------------------+-------------------------+---------------+-----------------------+------------------+-------------------+-----------------+---------------------+--------------------+------------------------+-------------------------+-----------------------------+------------+------------+--------------+---------------------+-----------------+-----------------+----------------+---------------+--------------------+--------------------+--------------------+-----------------+-------------------+----------------+-----------------------+-------------------------------+---------------+---------------+----------------+----------------+-----------------------------+------------------+
1 row in set (0.00 sec)


### 停止slave
mysql> slave stop;




=====================================================相关信息查看

### 在master上查看slave连接信息
mysql> show processlist;
+----+------+-----------------------+------+-------------+------+-----------------------------------------------------------------------+------------------+
| Id | User | Host                  | db   | Command     | Time | State                                                                 | Info             |
+----+------+-----------------------+------+-------------+------+-----------------------------------------------------------------------+------------------+
| 42 | root | localhost             | news | Query       |    0 | NULL                                                                  | show processlist |
| 43 | repl | 192.168.247.130:52065 | NULL | Binlog Dump |  407 | Master has sent all binlog to slave; waiting for binlog to be updated | NULL             |
+----+------+-----------------------+------+-------------+------+-----------------------------------------------------------------------+------------------+
2 rows in set (0.00 sec)



### 在slave上查看master连接信息
mysql> show processlist;
+----+-------------+-----------+------+---------+------+-----------------------------------------------------------------------------+------------------+
| Id | User        | Host      | db   | Command | Time | State                                                                       | Info             |
+----+-------------+-----------+------+---------+------+-----------------------------------------------------------------------------+------------------+
| 47 | root        | localhost | news | Query   |    0 | NULL                                                                        | show processlist |
| 48 | system user |           | NULL | Connect |  335 | Waiting for master to send event                                            | NULL             |
| 49 | system user |           | NULL | Connect |  280 | Slave has read all relay log; waiting for the slave I/O thread to update it | NULL             |
+----+-------------+-----------+------+---------+------+-----------------------------------------------------------------------------+------------------+
3 rows in set (0.00 sec)



