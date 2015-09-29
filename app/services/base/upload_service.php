<?php

/**
 * 上传模块
 */
class Upload_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 加载上传类
	 */
	public function load_upload($user_conf = array())
	{
		//默认配置
		$config = array(
			"upload_path" => config_item('upload_path'), //存放目录
			"allowed_types" => "jpg|png", //允许上传文件类型
			"file_ext_tolower" => TRUE, //文件后缀名将转换为小写
			"overwrite" => TRUE, //覆盖同名文件, 如果设置为TRUE, 则encrypt_name将不会生效
			"max_size" => 1024, //文件大小
			"max_width" => 1024, //图片最大宽
			"max_height" => 768, //图片最大高
			"min_width" => 10, //图片最小宽
			"min_height" => 10, //图片最小高
			"max_filename" => 100, //文件名最大长度
			"encrypt_name" => FALSE, //文件名将会转换为一个随机的字符串 如果你不希望上传文件的人知道保存后的文件名，这个参数会很有用
			"remove_spaces" => TRUE, //文件名中的所有空格将转换为下划线
			"detect_mime" => TRUE, //将会在服务端对文件类型进行检测，可以预防代码注入攻击，请不要禁用该选项，这将导致安全风险
			"mod_mime_fix" => TRUE, //带有多个后缀名的文件将会添加一个下划线后缀 这样可以避免触发 Apache mod_mime。 如果你的上传目录是公开的，请不要关闭该选项，这将导致安全风险
		);

		//用户配置
		foreach ($user_conf as $key => $value) {
			if ($key === "upload_path") {
				$config[$key] = $config[$key].$value;
			}
			else {
				$config[$key] = $value;
			}
		}

		//目录检查创建
		file_exists($config['upload_path']) OR mkdir($config['upload_path'], 0755, TRUE);

		//加载upload类
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
	}

	/**
	 * 处理客户端上传过来的数据
	 */
	public function upload_file($type, $params = array())
	{
		if ( ! $this->upload->do_upload('uploadedfile')) {
			return array('ret' => FALSE, 'error' => $this->upload->display_errors());
		}
		
		$data = $this->upload->data();
		
		//保存相关参数信息
		$typefile = $data['file_path'].$data['raw_name'].'.dat';
		file_put_contents($typefile, json_encode($data, JSON_UNESCAPED_UNICODE));

		//返回可访问http链接（$type类型 guide，notebook已占用）
		switch ($type) {
			case 'trip_photo':
				$url = sprintf('http://%s/photoshow/showpic?type=ctphoto&tripid=%s&contentid=%s&id=%s', "192.168.247.130:6001", $params['trip_id'], $params['tripcontent_id'], $params['id']);
				break;
			default:
				$url = sprintf('http://%s/photoshow/showpic?id=%s&type=%s','192.168.5.133', $data['raw_name'], $type;)
				break;
		}
		return array('ret' => TRUE, 'url' => $url);
	}
}