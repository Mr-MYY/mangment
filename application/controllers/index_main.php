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
		// $this->output->enable_profiler(TRUE);        //开启调试模式
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
	/**
	 * [show_allot 调拨查询按钮，用于点击【调拨查询】后将某一设备的所有调拨信息查询出来]
	 * @return [type] [description]
	 */
	public function show_allot()
	{
		$mid = $this->uri->segment(3);
		$data['main'] = $this->main->detailallot($mid);
		// print_r($data);die;
		$this->load->view('index/main_showallot.html',$data);
	}

	/**
	 * [click_zt 在主界面点击状态后显示的方法，用于显示该设备维修记录]
	 * @return [type] [description]
	 */
	public function click_zt()
	{
		$mid = $this->uri->segment(3);
		$data['repair'] = $this->main->show_repair($mid);
		$data['main'] = $mid;
		// print_r($data);die;
		$this->load->view('index/main_repair.html',$data);

	}

	/**
	 * [insert_repair 加载新增维修单界面]
	 * @return [type] [description]
	 */
	public function insert_repair()
	{
		$mid = $this->uri->segment(3);
		$sqlcondition = array('mid'=>$mid);
		$data['main'] = $this->main->select_edit($sqlcondition);

		$this->load->view('index/main_insertrepair.html',$data);

	}

	/**
	 * [repair 设备维修新增方法，用于新增设备维修记录的表单验证及数据库操作]
	 * @return [type] [description]
	 */
	public function repair()
	{
		$mid = $this->uri->segment(3);
		if (!($this->form_validation->run('repair')))       //进行表单验证，具体内容可见config\form_validation
		{
			$this->insert_repair();
		}
		else
		{	
			$repairarray = array(                                  //第一步：向维修表中插入数据
							'mid' => $mid,
							'gzsm' => $this->input->post('gzsm'),
							'sxsj' => $this->input->post('sxsj'),
							'fhsj' => $this->input->post('fhsj'),
							'ghpj' => $this->input->post('ghpj'),
							'wxje' => $this->input->post('wxje'),
							'bz' => $this->input->post('bz'),
							'rzt' => 4
							 );
			if ($this->main->insert_repair($repairarray) && $this->main->zt_torepair($mid))       //第二步：将主表中对应设备的状态改为维修中
			{
				success('index_main/click_zt/'.$mid,'新增设备维修成功');
			}
			else
			{
				error('数据库操作异常');
			}
		}
	}

	/**
	 * [edit_repair 用于跳转至维修单编辑界面，跳转时将相应主表信息及维修单信息传至界面]
	 * @return [type] [description]
	 */
	public function edit_repair()
	{
		$rid = $this->uri->segment(3);
		$data['repair'] = $this->main->select_repair($rid);   //获取需要修改的维修记录表
		//通过此维修记录表中的mid关联到设备主表的信息
		$mid = $data['repair'][0]['mid'];

		$sqlcondition = array('mid'=>$mid);
		$data['main'] = $this->main->select_edit($sqlcondition);
		$this->load->view('index/main_editrepair.html',$data);
	}

	/**
	 * [repairediting 维修单编辑方法，用于对维修单的数据库修改操作]
	 * @return [type] [description]
	 */
	public function repairediting()
	{
		$rid = $this->uri->segment(3);
		$data['repair'] = $this->main->select_repair($rid);
		$mid = $data['repair'][0]['mid'];
		if (!($this->form_validation->run('repair')))       //进行表单验证，具体内容可见config\form_validation
		{
			$this->edit_repair();
		}
		else
		{
			$repairarray = array(                                  //第一步：编辑维修表中数据
							'gzsm' => $this->input->post('gzsm'),
							'sxsj' => $this->input->post('sxsj'),
							'fhsj' => $this->input->post('fhsj'),
							'ghpj' => $this->input->post('ghpj'),
							'wxje' => $this->input->post('wxje'),
							'bz' => $this->input->post('bz'),
							 );
			if ($this->main->edit_repair($rid,$repairarray))
			{
				success('index_main/click_zt/'.$mid,'修改设备维修单成功');
			}
			else
			{
				error('数据库操作异常');
			}

		}
	}

/**
 * [finish_repair 维修单中点击[完成]链接进行的操作，这里首先判断维修单的维修状态，根据维修状态
 * 切换相应的单据状态，同时编辑成功后，判断主表中此mid有无还在维修中的维修单，若无，则将主表中的状态一起改为0]
 * @return [type] [description]
 */
	public function finish_repair()
	{
		$rid = $this->uri->segment(3);
		$data['r'] = $this->main->select_repair($rid);
		$mid = $data['r'][0]['mid'];
		$rzt = $data['r'][0]['rzt'];

		switch ($rzt) {             //对维修单的维修状态作判断，进行相应的操作
			case 0:					//0:表示维修单状态为已完成，需将状态切换至4
				$this->main->chang_rzt($rid);
				$this->main->zt_torepair($mid);   //同时改变主表的状态为维修中
				$data['repair'] = $this->main->show_repair($mid);
				$data['main'] = $mid;
				// print_r($data);die;
				$this->load->view('index/main_repair.html',$data);
				break;
			
			case 4:					//4:表示维修单状态为维修中，需将状态切换至0
				$this->main->chang_rzt($rid);
				if (!($this->main->check_repair($mid)))   //判断是否还有在维修的单据，若没有，将主表状态切换成使用中
				{
					$this->main->zt_touse($mid);
				}
				$data['repair'] = $this->main->show_repair($mid);
				$data['main'] = $mid;
				$this->load->view('index/main_repair.html',$data);
				break;
		}
	}

	/**
	 * [del_repair 删除维修单方法，用于点击【删除】按钮后跳转至删除页面]
	 * @return [type] [description]
	 */
	public function del_repair()
	{
		$rid = $this->uri->segment(3);
		$data['repair'] = $this->main->select_repair($rid);   //获取需要修改的维修记录表
		//通过此维修记录表中的mid关联到设备主表的信息
		$mid = $data['repair'][0]['mid'];

		$sqlcondition = array('mid'=>$mid);
		$data['main'] = $this->main->select_edit($sqlcondition);
		$this->load->view('index/main_delrepair.html',$data);

	}

	/**
	 * [repairdeling 删除维修单方法，用于删除维修单时进行数据库操作]
	 * @return [type] [description]
	 */
	public function repairdeling()
	{
		$rid = $this->uri->segment(3);
		$data['r'] = $this->main->select_repair($rid);
		$rzt = $data['r'][0]['rzt'];
		$mid = $data['r'][0]['mid'];
		if ($rzt == 4)     //判断改维修单状态是否为维修中，删除后，需根据维修单状态改变主表状态
		{
			$this->main->chang_rzt($rid);
				if (!($this->main->check_repair($mid)))   //判断是否还有在维修的单据，若没有，将主表状态切换成使用中
				{
					$this->main->zt_touse($mid);
				}
		}
		if ($this->main->delete_repair($rid))
			{
				success('index_main/click_zt/'.$mid,'删除设备维修单成功');
			}
			else
			{
				error('数据库操作异常');
			}
	}
	
	
	
}
















?>