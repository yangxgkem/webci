#mysql -u root -p < gamesql.sql 
show databases;
#创建数据库
create database if not exists lzq;
create database if not exists lzq_log;
#进入数据库
use lzq;
#list
create table if not exists list(
URS varchar(100) not null primary key,
Passwd varchar(100),
Ip varchar(100),
YuanBao int(4),
TotalYuanBao int(4),
ConsumeYuanBao int(4));
#user
create table if not exists user(
Uid varchar(100) not null primary key,
URS varchar(100),
Birthday int(4),
LoginTime int(4),
LogoutTime int(4),
Wizard int(4),
Photo int(4),
CorpId int(4),
Name varchar(100),
Grade int(4),
Sex int(4),
x int(4),
y int(4),
SceneNo int(4),
SaveTime int(4),
MaxFubenNo int(4),
MaxScore int(4),
BuyMoney int(4),
TongbuTime int(4),
IsChongZhi int(4),
SceneRunId int(4));
#item
create table if not exists item(
SId varchar(100) not null primary key,
ItemNo int(4),
IsBind int(4),
Birthday int(4),
Amount int(4),
FrameNo int(4),
Uid varchar(100));
#进入数据库
use lzq_log;
#log
create table if not exists game1001(
Id int(4) not null primary key auto_increment,
Opname varchar(100),
Time int(4),
Time2 varchar(100),
Data varchar(2048));
#添加字段
#alter table user add ip int(4);