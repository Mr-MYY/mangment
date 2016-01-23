<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_main extends CI_Controller //前台主界面控制器，控制所有主界面操作
{
	public function __construct()      //构造函数，用以自加载方法
	{
		parent :: __construct();
		$this->load->model('main_model','main');   //默认载入数据库模型
		$this->load->model('type_model','type');
		$this->load->model('place_model','place');   //默认载入类型数据模型
		$this->load->helper('form');               //默认载入表单辅助函数
		$this->load->library('form_validation');   //默认载入表单验证类
	}
	
	public function index()
	{
		$this->load->view('index/index.html');
	}
	
	public function main()                        //加载主界面视图
	{
		$data['main'] = $this->main->select_main();
		$this->load->view('index/main.html',$data);
	}
	
	public function insert()                     //新增设备视图方法，跳转到新增设备视图
	{
		$data['type'] = $this->type->select_all_type(); 
		$data['place'] = $this->place->select_all_place();
		$this->load->view('index/insert.html',$data);
	}
	
	public function inserting()                  //新增设备方法，点击新增按钮时跳转至此页面对数据库进行操作
	{
		
		if (!($this->form_validation->run('main')))       //进行表单验证，具体内容可见config\form_validation
		{
			$this->insert();
		}
		else
		{
			$sqlcondition = array(
								'tid' => $this->input->post('type'),
								'xhgg'=> $this->input->post('xhgg'),
								'sn'  => $this->input->post('sn'),
								'zcbh'=> $this->input->post('zcbh'),
								'zt'  => $this->input->post('zt'),
								'je'  => $this->input->post('je'),
								'dhsj'=> $this->input->post('dhsj'),
								'pid' => $this->input->post('pname'),
								'azsj'=> $this->input->post('azsj'),
								'fph' => $this->input->post('fph'),
								'hth' => $this->input->post('hth'),
								'bz'  => $this->input->post('bz'),
								);	
			//print_r($this->main->isnert_main($sqlcondition));die;
			if ($this->main->isnert_main($sqlcondition))
			{
				success('index_main/main','新增设备成功');
			}
			else
			{
				error('数据库操作异常');
			}
									
		}
	}
	
	
	
	
	
	
	
	
}
















?>