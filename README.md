# webci
codeigniter3.0框架学习,用于app webservice 和 web 端

尽量区分 `system` 和 `application` 两大块，属于 system 的功能就尽量在 system 下进行，不再 application 下扩展，保证两大块相对简洁和独立。

以下列出修改内容：

>1

修改目录 system 为 `sys`
修改目录 application 为 `app`

------------------------------------------------------

>2

删除所有目录下的 `index.html` 和 `.htaccess`，要防止用户访问相关文件，手段有很多，但极力不喜欢用index.html 和 .htaccess这种方式，使得目录下无端端多了很多冗余，对于有简洁
洁癖的我来接受不了

------------------------------------------------------

>3

app/views 目录移到app相同目录结构下，允许用户之间访问view目录

------------------------------------------------------

>4

添加service层，把本来的MVC模式 改为现在的 SMVC模式。

sys/core/Service.php
app/services/*_service.php

随着业务越来越复杂，controller越来越臃肿，举一个简单的例子，比如说用户下订单，这必然会有一系列的操作：更新购物车、添加订单记录、会员添加积分等等，且下订单的过程可能在多种场景出现，
如果这样的代码放controller中则很臃肿难以复用，如果放model会让持久层和业务层耦合。很多人将一些业务逻辑写到model中去了，model中又调其它model，也就是业务层和持久层相互耦合。
这是极其不合理的，会让model难以维护，且方法难以复用。

可以考虑在controller和model中加一个业务层service，由它来负责业务逻辑，封装好的调用接口可以被controller复用。这样各层的任务就明确了：

Model: 数据持久层的工作，对数据库的操作都封装在这。

Service: 业务逻辑层，负责业务模块的逻辑应用设计，controller中就可以调用service的接口实现业务逻辑处理，提高了通用的业务逻辑的复用性，设计到具体业务实现会调用Model的接口。

Controller: 控制层，负责具体业务流程控制，这里调用service层，将数据返回到视图

View: 负责前端页面展示，与Controller紧密联系。

------------------------------------------------------

>5

添加日志模块，存储业务处理过程中需要记录的相关的log

models/log/log_model.php

所有的数据连接必须由 models/base_model.php 下进行，由 base_model 统一管理。它还优化了如果需要连接多个数据库时，如果地址一样，只会第一次连接生效，第二次开始不会执行。

------------------------------------------------------

>6

app/services/base 下添加了相关常用功能模块

preload_service.php 在config/autoroad下配置加载 此模块用于管理需要全局加载的service

efunc_service.php 常用函数集

proto_service.php 协议处理模块

setting_service.php 静态数据加载模块 用于加载excel表导出的数据

upload_service.php 文件上传模块

xls_service.php excel文件读写操作

------------------------------------------------------

>7

app/protocol 定制了客户端向服务器请求数据时的协议格式

c2s_模块_请求: 为客户端向服务器请求数据

s2c_模块_请求: 为服务器返回数据

eg:
```
cmd.php
//执行指令
$c2s_cmd_cmd = array(
	'command' => array("require", "string"), //指令字符串
);
```

每条协议为一个array，每条字段有以下信息

名称 => array(可选状态, 数据类型, 数据大小最大限制)

可选状态有：require(必填)，optional(可填), repeated（数组）

数据类型有：string,int,或自定义array

详细可阅读代码：app/service/base/proto_service.php

------------------------------------------------------

>8

3rd为第三方代码
当前嵌入第三方库有：
phpexcel
Twig
phpqrcode

------------------------------------------------------

>9

tools/genxls 导表程序，把策划填写excel导出自己想要的解析数据

详情查看 **[https://github.com/yangxgkem/genxls](https://github.com/yangxgkem/genxls)**