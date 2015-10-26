<?php

class Cachetag_service extends CI_Service {

	//cache tag前缀
	public $per = "cachetag_service_";
	
	public function __construct()
	{
		parent::__construct();
	}

	//给某标签添加缓存key
	public function addtagkey($key, $tag, $time=3600)
	{
		$taglist = $this->cache->get($this->per.$tag);
		if (!$taglist) $taglist = array();

		$taglist[$key] = strtotime('now');
		$this->cache->save($this->per.$tag, $taglist, $time);
	}

	//清除某标签中的缓存key
	public function deltagkey($key, $tag)
	{
		$taglist = $this->cache->get($this->per.$tag);
		if (!$taglist OR !$taglist[$key]) return;

		unset($taglist[$key]);
		$this->cache->save($this->per.$tag, $taglist);
	}

	//清除某标签
	public function deltag($tag)
	{
		$this->cache->delete($this->per.$tag);
	}

	//获取某标签内容
	public function gettag($tag)
	{
		$taglist = $this->cache->get($this->per.$tag);
		return $taglist;
	}

	//删除某标签的所有cache
	public function cleantag($tag)
	{
		$taglist = $this->gettag($tag);
		if (!$taglist) return;

		foreach ($taglist as $key => $value) {
			$this->cache->delete($key);
		}

		$this->deltag($tag);
	}
}