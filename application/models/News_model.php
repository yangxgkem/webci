<?php

/**
 * 新闻模型
 */
class News_model extends CI_Model {
	
	/**
	 * 构造函数
	 * 无需调用父类的__construct(),因为它没有做什么东西 system/core/Model.php
	 */
	public function __construct()
	{
		/**
		 * 开始连接数据库
		 * 数据库配置信息在 application/config/database.php
		 * 连接成功后可以使用 $self->db 进行数据库操作
		 */
		$this->load->database();
	}

	/**
	 * 获取数据库新闻数据
	 * $slug 为空则获取所有新闻数据
	 * $slug 非空则获取匹配成功的新闻数据
	 */
	public function get_news($slug = false) 
	{
		if ($slug === false)
		{
			$query = $this->db->get('news');//获取数据库某张表全部数据,返回php对象
			return $query->result_array();//返回一个带下标的数组
		}

		$query = $this->db->get_where('news', array('slug' => $slug));//条件查询数据库
		return $query->row_array();//返回一个数组
	}

	/**
	 * 插入一条新闻到数据库
	 */
	public function set_news()
	{
		$this->load->helper('url');

		$slug = url_title($this->input->post('title'), 'dash', true);

		$data = array(
			'title' => $this->input->post('title'),
			'text' => $this->input->post('text'),
			'slug' => $slug,
		);

		return $this->db->insert('news', $data);
	}
}