<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_main extends CI_Controller //前台主界面控制器，控制所有主界面操作
{
	public function __construct()      //构造函数，用以自加载方法
	{
		parent :: __construct();
		$this->load->model('main_model','main');   //默认载入数据库模型
		$this->load->model('type_model','type');   //默认载入类型数据模型
		$this->load->helper('form');               //默认载入表单辅助函数
		$this->load->library('form_validation');   //默认载入表单验证类
	}
	
	public function index()
	{
		$this->load->view('index/index.html');
	}
	
	public function main()            //加载主界面视图
	{
		$data['main'] = $this->main->select_main();
		$this->load->view('index/main.html',$data);
	}
	
	public function insert()        //新增设备视图方法，跳转到新增设备视图
	{
		$data['type'] = $this->type->select_all_type(); 
		$this->load->view('index/insert.html',$data);
	}
	
	public function inserting()    //新增设备方法，点击新增按钮时跳转至此页面对数据库进行操作
	{
		$this->load->view('index/insert.html');
	}
	
	
	
	
	
	
	
	
}
















?>