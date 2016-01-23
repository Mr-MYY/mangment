<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_type extends CI_Controller                      //类型控制器，操作与类型有关的操作
{
	public function __construct()
	{
		parent :: __construct();
		//$this->output->enable_profiler(TRUE);
		$this->load->model('type_model','type');	       //默认载入类型数据库
	}
	
	public function main()                                 //类型默认方法，查看类型界面
	{
		$data['type'] = $this->type->select_all_type();  
		$this->load->view('index/type_main.html',$data);
	}
	
	public function insert()                               //插入方法，用于显示插入界面                         
	{	
		$this->load->view('index/type_insert.html');
	}
	
	public function inserting()                           //插入方法，用于点击插入按钮时的数据库操作；
	{
		$this->load->library('form_validation');
		
		if ($this->form_validation->run('type') == FALSE)
		{
			$this->load->view('index/type_insert.html');
		}
		else
		{
			$data = array('tname' => $this->input->post('tname'),'firm' => $this->input->post('firm'));  
			if ($this->type->check($data) == FALSE)   //插入时的名称校验，用来查询类型库中是否已有此类型,如果有则不允许插入
			{
				$this->type->insert_type($data);
				success('index_type/main','新增类型成功');
			}
			else
			{
				success('index_type/main','类型表中已有重复类型');	
			}
			
		}
	}
	
	public function delete()                                //载入删除视图；
	{
		$tid = $this->uri->segment(3);
		$data['type'] = $this->type-> select_one($tid);
		
 		$this->load->view('index/type_del.html',$data);
	}
	
	public function deleting()                                //删除方法，对视图删除的数据库操作在此执行；
	{
		$tid = $this->uri->segment(3);
		$data = array('tid' => $tid);
		if ($this->type->count_type($data) == FALSE)         //判断主表是否含有即将要删除的类型，如果有，则不允许用户删除
		{
			$this->type->del_type($data);
			success('index_type/main','删除类型成功');
		}
		else
		{
			success('index_type/main','该类型已被使用，无法删除');
		}
	}
	
	public function search()                                  //查询按钮，用于点击查询按钮后显示内容,采用模糊搜素
	{
		if (($this->input->post('tname') || $this->input->post('firm')) == FALSE)
		{
			error('没有输入查询信息');
		}
		else
		{
			//不做判断直接载入会出现一项不输则选择出全部数据的情况，故加以判断，如果未输入查询数据，则post得到的结果是null
			$data = array(
					'tname' => ($this->input->post('tname') == NULL)? 'null' :$this->input->post('tname'),
					'firm' => ($this->input->post('firm') == NULL)? 'null' :$this->input->post('firm')
						);
			if (!($this->type->search_type($data)))
			{
				success('index_type/main','未找到相关数据');
			}
			else
			{
				$result['type'] = $this->type->search_type($data);
				print_r($result);
				$this->load->view('index/type_main.html',$result);
			}
		}
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}















?>