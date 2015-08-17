<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 随着业务越来越复杂，controller越来越臃肿，举一个简单的例子，比如说用户下订单，
 * 这必然会有一系列的操作：更新购物车、添加订单记录、会员添加积分等等，且下订单的过程可能在多种场景出现，
 * 如果这样的代码放controller中则很臃肿难以复用，如果放model会让持久层和业务层耦合。
 * 很多人将一些业务逻辑写到model中去了，model中又调其它model，也就是业务层和持久层相互耦合。
 * 这是极其不合理的，会让model难以维护，且方法难以复用。
 *
 *可以考虑在controller和model中加一个业务层service，由它来负责业务逻辑，封装好的调用接口可以被controller复用。
 *这样各层的任务就明确了：
 *
 *Model(DAO):数据持久层的工作，对数据库的操作都封装在这。
 *
 *Service ： 业务逻辑层，负责业务模块的逻辑应用设计，controller中就可以调用service的接口实现业务逻辑处理，
 *提高了通用的业务逻辑的复用性，设计到具体业务实现会调用Model的接口。
 *
 * Controller ：控制层，负责具体业务流程控制，这里调用service层，将数据返回到视图
 * 
 * View ： 负责前端页面展示，与Controller紧密联系。
 */
class CI_Service {

	public function __construct()
	{
		log_message('info', 'My Service Class Initialized');
	}

	public function __get($key)
	{
		return get_instance()->$key;
	}
}