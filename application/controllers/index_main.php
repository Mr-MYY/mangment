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
		$this->output->enable_profiler(TRUE);        //开启调试模式
	}
	
	public function index()
	{
		$this->load->view('index/index.html');
	}
	
	public function main()                        //加载主界面视图
	{
		$data['main'] = $this->main->select_main();
		$data['type'] = $this->main->select_distinct_type();
		// print_r($data);die;
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
			
			if ($this->main->isnert_main($sqlcondition))
			{
				//print_r($this->main->isnert_main($sqlcondition));die;
				success('index_main/main','新增设备成功');
			}
			else
			{
				error('数据库操作异常');
			}
									
		}
	}
/**
 * [check 查询办法：用于点击查询按钮后产生的事件]
 * 
 */
	public function check()
	{
		$type = $this->input->post('type');
		$xhgg = $this->input->post('xhgg');
		$sn = $this->input->post('sn');
		$zcbh = $this->input->post('zcbh');
		$pid = $this->input->post('pid');
		$zt = $this->input->post('zt');

		$sqlcondition = array(
							'main.tid' => $type,
							'xhgg'=> $xhgg,
							'sn'  => $sn,
							'zcbh'=> $zcbh,
							'main.pid' => $pid,
							'zt'  => $zt
								);
		if ($this->main->check_main($sqlcondition))
		{
			$data['main'] = $this->main->check_main($sqlcondition);
			$data['type'] = $this->main->select_distinct_type();
			$this->load->view('index/main.html',$data);
		}
		else
		{
			success('index_main/main','未找到相关数据');
		}
	}

	/**
	 * [click_type 在主界面点击类型时的事件，点击后进入设备编辑页面]
	 * @return [type] [description]
	 */
	public function click_type()
	{
		$this->output->enable_profiler(TRUE);
		$id = $this->uri->segment(3);
		$sqlcondition = array(
							'mid' => $id
							);
		$data['main'] = $this->main->select_edit($sqlcondition);
		$data['type'] = $this->type->select_all_type();
		$data['place']= $this->place->select_all_place();
		// print_r($data);die;
		$this->load->view('index/main_edit.html',$data);
	}

	
/**
 * [editing 根据传入参数mid对设备主表进行修改，这里要进行表单验证]
 * @return [type] [description]
 */
	public function editing()
	{
		$mid = $this->uri->segment(3);
		if (!($this->form_validation->run('main')))       //进行表单验证，具体内容可见config\form_validation
		{
			$this->click_type();
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
			
			if ($this->main->edit_main($mid,$sqlcondition))
			{
				success('index_main/main','更新设备成功');
			}
			else
			{
				error('数据库操作异常');
			}
									
		}
		
	}

	/**
	 * [click_place 在主界面点击地点后使用的方法，用于转到设备调拨界面]
	 * @return [type] [转到设备调拨界面]
	 */
	public function click_place()
	{
		$mid= $this->uri->segment(3);
		$sqlcondition = array('mid'=>$mid);
		$data['main'] = $this->main->select_edit($sqlcondition);
		$data['place']= $this->place->select_all_place();
		$this->load->view('index/main_allot.html',$data);
	}

	/**
	 * [allot 用于更新设备调拨表及设备主表中的记录]
	 * @return [type] [description]
	 */
	public function allot()
	{
		$this->form_validation->set_rules('dbsj','调拨时间','required|exact_length[8]');
		$this->form_validation->set_rules('newplace','新地点','callback_pid_check');
		if (!($this->form_validation->run()))
		{
			$this->click_place();
		}
		else
		{
			//echo "hello";die;
			$mid = $this->uri->segment(3);
			$sqlcondition =array('pid'=> $this->input->post('newplace')); 
			$this->main->edit_main($mid,$sqlcondition); //第一步：更新主表中的地点名；			
			$allotarray = array(
								'mid'=>$mid,
								'dbsj'=>$this->input->post('dbsj'),
								'oldpid'=>$this->input->post('oldpid'),
								'newpid'=>$this->input->post('newplace')
								);
			if ($this->main->insert_allot($allotarray))   //第二步：向调拨表中插入信息；
			{
				success('index_main/main','设备调拨成功');
			}
			else
			{
				error('数据库操作异常');
			}

		}
		
	}
/**
 * [pid_check 地点表单验证函数，用于验证设备调拨时新老地点不能相同，
 * 用$this->form_validation->set_rules('newplace','新地点','callback_pid_check');调用此函数方法]
 * @return [BOOL] [相同时返回假，不相同时返回真；]
 */
	public function pid_check()
	{
		$newpid = $this->input->post('newplace');
		$oldpid = $this->input->post('oldpid');
		if($newpid == $oldpid)
		{
			$this->form_validation->set_message('pid_check', '{field} 不能和原地点相同.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	} 

	public function show_allot()
	{
		$mid = $this->uri->segment(3);
		$data['main'] = $this->main->detailallot($mid);
		// print_r($data);die;
		$this->load->view('index/main_showallot.html',$data);
	}
	
	
	
}
















?>