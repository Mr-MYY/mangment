<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_place extends CI_Controller                      //类型控制器，操作与类型有关的操作
{
	public function __construct()
	{
		parent :: __construct();
		$this->load->model('place_model','place');	       //默认载入类型数据库
	}
	
	public function main()                                 //类型默认方法，查看类型界面
	{
		$data['place'] = $this->place->select_all_place();  
		$this->load->view('index/place_main.html',$data);
	}
	
	public function insert()                               //插入方法，用于显示插入界面                         
	{	
		$this->load->view('index/place_insert.html');
	}
	
	public function inserting()                           //插入方法，用于点击插入按钮时的数据库操作；
	{
		$this->load->library('form_validation');
		
		if ($this->form_validation->run('place') == FALSE)
		{
			$this->load->view('index/place_insert.html');
		}
		else
		{
			$data = array('pname' => $this->input->post('pname'));  
			if ($this->place->check($data) == FALSE)   //插入时的名称校验，用来查询类型库中是否已有此类型,如果有则不允许插入
			{
				$this->place->insert_place($data);
				success('index_place/main','新增位置成功');
			}
			else
			{
				success('index_place/main','位置表中已有重复位置');	
			}
			
		}
	}
	
	public function delete()                                //载入删除视图；
	{
		$pid = $this->uri->segment(3);
		$data['place'] = $this->place->select_one($pid);
		
 		$this->load->view('index/place_del.html',$data);
	}
	
	public function deleting()                                //删除方法，对视图删除的数据库操作在此执行；
	{
		$pid = $this->uri->segment(3);
		$data = array('pid' => $pid);
		if ($this->place->count_place($data) == FALSE)         //判断主表是否含有即将要删除的类型，如果有，则不允许用户删除
		{
			$this->place->del_place($data);
			success('index_place/main','删除位置成功');
		}
		else
		{
			success('index_place/main','该位置已被使用，无法删除');
		}
	}
	
	public function search()                                  //查询按钮，用于点击查询按钮后显示内容,采用模糊搜素
	{
		if ($this->input->post('pname') == FALSE)
		{
			error('没有输入查询信息');
		}
		else
		{
			$data = array('pname' => $this->input->post('pname'));
			if (!($this->place->search_place($data)))
			{
				error('未找到相关数据');
			}
			else
			{
				$result['place'] = $this->place->search_place($data);
				$this->load->view('index/place_main.html',$result);
			}
		}
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}















?>