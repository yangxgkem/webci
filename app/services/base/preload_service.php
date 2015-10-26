<?php


class Preload_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('base/setting_service');
		$this->load->service('base/proto_service');
		$this->load->service("base/efunc_service", "EFUNC");
		$this->load->service("base/cachetag_service", "CACHETAG");
		$this->load->service("base/twig_service", "TWIG");
		$this->load->service("base/xls_service", "XLS");
		$this->load->service("base/user_service", "USER");
	}
}