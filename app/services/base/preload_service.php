<?php


class Preload_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('base/setting_service');
		$this->load->service('base/proto_service');
		$this->load->service("base/efunc_service", "efunc");
		$this->load->service("user/user_service", "userObj");
	}
}