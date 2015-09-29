<?php

class Photoshow extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 根据图片描述文件发送图片
	 */
	public function sendphoto($typefile)
	{
		$data = file_get_contents($typefile);
		if ( ! $data) {
			return;
		}
		$data = json_decode($data, TRUE);
		$img = file_get_contents($data['full_path']);
		if ( ! $img) {
			return;
		}
		header("Content-type: " . $data['file_type']);
		echo $img;
	}

	/**
	 * 显示图片
	 */
	public function showpic()
	{
		$type = $this->input->get('type');
		switch ($type) {
			case 'ctphoto':
				$tripid = $this->input->get('tripid');
				$contentid = $this->input->get('contentid');
				$id = $this->input->get('id');
				$typefile = sprintf("%s/trip/%s/%s/%s.dat", config_item('upload_path'), $tripid, $contentid, $id);
				break;
			default:
				$id = $this->input->get('id');
				$typefile = sprintf ("%s%s.dat", config_item('upload_path').$type.'/'.$id.'/', $id);
				break;
		}
		$this->sendphoto($typefile);
	}
}