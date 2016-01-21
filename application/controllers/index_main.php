<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_main extends CI_Controller //前台主界面控制器，控制所有主界面操作
{
	public function __construct()      //构造函数，用以自加载方法
	{
		parent :: __construct();
		$this->load->model('main_model','main');   //默认载入数据库模型
	}
	
	public function index()
	{
		$this->load->view('index/index.html');
	}
	
	public function main()            //加载主界面视图
	{
		$this->load->view('index/main.html');
	}
	
	
	
	
	
	
	
	
}
















?>