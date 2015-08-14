<?php

/**
 * 新闻控制器
 */
class News extends CI_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();//必须要调用父类构造函数
		$this->load->model('news_model');//加载模型
		/**
		 * 往后再appliction/core/MY_Controller.php 构造函数中根据 ENVIRONMENT 类型进行 开启
		 * 如果开发人员不想启动它,可以在自己的控制器关闭：$this->output->enable_profiler(FALSE);
		 */
		$this->output->enable_profiler(TRUE);

		$this->load->helper('url');
	}

	/**
	 * 默认访问方法
	 * 访问所有新闻数据
	 */
	public function index()
	{
		$data['news'] = $this->news_model->get_news();

		$data['title'] = 'New archive';
		/**
		 * php extract() 函数从数组中把变量导入到当前的符号表中
		 * load->view() 时会对 $data 执行 extract()
		 */
		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	/**
	 * 访问某一条新闻详细信息
	 * $slug 新闻搜索条文
	 */
	public function view($slug)
	{
		$data['news_item'] = $this->news_model->get_news($slug);

		if (empty($data['news_item']))
		{
			show_404();
		}

		$data['title'] = $data['news_item']['title'];
		$this->load->view('templates/header', $data);
		$this->load->view('news/view', $data);
		$this->load->view('templates/footer');
	}

	/**
	 * 创建一条新闻
	 */
	public function create()
	{
		/**
		 * 加载html表单form 辅助函数 system/helpers/form_helper.php
		 * 详细文档：http://codeigniter.org.cn/user_guide/helpers/file_helper.html
		 */
		$this->load->helper('form');

		/**
		 * 加载表单form 验证类 system/libraries/Form_validation.php
		 */
		$this->load->library('form_validation');

		/**
		 * 对表单某个域进行验证规则
		 * required规则：不能为空
		 * 详细文档：http://codeigniter.org.cn/user_guide/libraries/form_validation.html
		 */
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');

		$data['title'] = '创建新闻';

		/**
		 * 执行 form_validation->run() 验证表单, 如果提交数据有误,或是初始化不含数据的, 验证肯定失败
		 */
		if ($this->form_validation->run() === false)
		{
			$this->load->view('templates/header', $data);
			$this->load->view('news/create');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->news_model->set_news();//验证成功, 调用模型插入数据
    		$this->index();//返回主页
		}
	}

	/**
	 * 邮件发送例子
	 */
	/*
	function email()
	{
		$this->load->library('email');
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.163.com';
		$config['smtp_user'] = 'yangxuguangvip@163.com';//这里写上你的163邮箱账户
		$config['smtp_pass'] = 'yexiao-huai320;';//这里写上你的163邮箱密码
		$config['mailtype'] = 'html';
		$config['validate'] = true;
		$config['priority'] = 1;
		$config['crlf']  = "\r\n";
		$config['smtp_port'] = 25;
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);


		$this->email->from('yangxuguangvip@163.com', '合肥学院青年志愿者联合会');//发件人
		$this->email->to('564363690@qq.com');

		$this->email->message('哈哈，测试邮件发送');
		$this->email->send();
		echo $this->email->print_debugger();
	}*/
	public function sendmail()
	{
		$this->load->library('email');
		$this->email->from('yangxuguangvip@163.com', '好导游给你发送邮件啦');
		$this->email->to('564363690@qq.com');
		$this->email->subject('好导游邮件测试主题1');
		//$this->email->message('好导游验证你的邮件啦2');

		$filename = 'application/img/photo2.jpg';
		$this->email->attach($filename);

		$cid = $this->email->attachment_cid($filename);

		$imglink = "<img src=\"cid:$cid\" />";
		$msg = '<p>这是一张在邮件中直接显示的图片</p>' . $imglink;
        $this->email->message($msg);

		$this->email->send();
		echo $this->email->print_debugger();
	}
}