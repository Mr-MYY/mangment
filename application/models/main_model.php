<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main_model extends CI_Model
{
	public function select_main()               //主界面显示模型，用于把状态不是作废的设备显示出来；
	{
		$this->db->select('main.*,pname,tname,firm');
		$this->db->where('zt !=',3);
		$this->db->order_by('pid','ASC');
		$this->db->order_by('tid','ASC');
		$this->db->order_by('xhgg','ASC');
		$this->db->join('type','main.tid = type.tid');
		$this->db->join('place','main.pid= place.pid');
		$result = $this->db->get('main')->result_array();
		return $result;
	}
	
	public function isnert_main($sqlcondition)              //新增数据方法，用于向main表插入数据    
	{
		$result = $this->db->insert('main',$sqlcondition);
		return $result;
	}

	/**
	 * [select_type 选出已经使用的所有状态]
	 * @return [type] [返回所有类型值]
	 */
	public function select_distinct_type()
	{
		$this->db->distinct();
		$this->db->where('tid in (select tid from t_main)');
		$result = $this->db->get('type')->result_array();
		return $result;
	}
	
	/**
	 * [check_main 根据搜索框筛选出特定的设备]
	 * @param  [array] $sqlcondition [判断条件，集合所有搜索框，使用like 进行模糊搜索]
	 * @return [type]               [返回查到的数据库数组]
	 */
	public function check_main($sqlcondition)
	{
		$this->db->select('main.*,pname,tname,firm');
		$this->db->where('zt !=',3);
		$this->db->order_by('pid','ASC');
		$this->db->order_by('tid','ASC');
		$this->db->order_by('xhgg','ASC');
		$this->db->join('type','main.tid = type.tid');
		$this->db->join('place','main.pid= place.pid');
		$this->db->like($sqlcondition);
		$result = $this->db->get('main')->result_array();
		return $result;
	}

/**
 * [select_edit 根据传入参数id获得该设备的主表信息]
 * @param  [type] $sqlcondition [数据库条件，使用id定位每一条信息]
 * @return [type]               [description]
 */
	public function select_edit($sqlcondition)
	{
		$this->db->select('main.*,pname,tname,firm');
		$this->db->where($sqlcondition);
		$this->db->join('type','main.tid = type.tid');
		$this->db->join('place','main.pid= place.pid');
		$result = $this->db->get('main')->result_array();
		return $result;
	}

	/**
	 * [edit_main 对设备主表进行更新]
	 * @param  [type] $mid [数据库更新条件，这里的为根据mid=$mid进行更新]
	 * @param  [type] $sqlcondition [数据库更新内容]
	 * @return [type]               [description]
	 */
	public function edit_main($mid,$sqlcondition)
	{
		$this->db->where(array('mid'=>$mid));
		$result = $this->db->update('main',$sqlcondition);
		return $result;
	}

	/**
	 * [insert_allot 向调拨表中插入数据，用于记录设备调拨信息]
	 * @return [type] [description]
	 */
	public function insert_allot($allotarray)
	{
		$result = $this->db->insert('allot',$allotarray);
		return $result;
	}
/**
 * [detailallot 根据设备mid获取设备调拨信息]
 * @param  [type] $mid [字段mid]
 * @return [array]      [返回值为一数组]
 */
	public function detailallot($mid)
	{
		$this->db->select('type.firm,type.tname,main.xhgg,main.sn,
			main.zcbh,allot.dbsj,allot.aid,allot.sh');
		$this->db->select ('(select pname from t_place where pid = t_allot.oldpid) as oldplace');
		$this->db->select ('(select pname from t_place where pid = t_allot.newpid) as newplace');	
		$this->db->join('main','main.mid = allot.mid');
		$this->db->join('type','main.tid = type.tid');
		$this->db->where(array('main.mid'=>$mid));
		$result = $this->db->get('allot')->result_array();
		return $result;
	}

	/**
	 * [show_repair 显示维修记录，在主界面点击状态后调用此方法显示设备的维修记录]
	 * @param  [type] $mid [传入参数设备编号mid]
	 * @return [array]      [description]
	 */
	public function show_repair($mid)
	{
		$this->db->select ('type.firm,type.tname,main.xhgg,main.sn,main.zcbh,place.pname,
			repair.rid,repair.rzt,repair.gzsm,repair.sxsj,repair.fhsj,repair.ghpj,repair.wxje,repair.bz');
		$this->db->join('main','main.mid = repair.mid');
		$this->db->join('type','main.tid = type.tid');
		$this->db->join('place','place.pid = main.pid');
		$this->db->where(array('repair.mid' => $mid));
		$this->db->order_by('sxsj','DESC');
		$result = $this->db->get('repair')->result_array();
		return $result;

	}

	/**
	 * [insert_repair 新增设备维修表方法，把数据直接插入维修表]
	 * @param  [array] $sqlcondition [插入表中的条件数组]
	 * @return [type]               [description]
	 */
	public function insert_repair($sqlcondition)
	{
		$result = $this->db->insert('repair',$sqlcondition);
		return $result;
	}

	public function edit_repair($rid,$sqlcondition)
	{
		$this->db->where(array('rid'=>$rid));
		$result = $this->db->update('repair',$sqlcondition);
		return $result;
	}

	/**
	 * [zt_torepair 根据mid将设备主表中的对应状态改为4：即维修中]
	 * @param  [type] $mid [description]
	 * @return [type]      [description]
	 */
	public function zt_torepair($mid)
	{
		$this->db->where(array('mid'=>$mid));
		$result = $this->db->update('main',array('zt'=>4));
		return $result;
	}

	/**
	 * [zt_touse 根据mid将设备主表中的对应状态改为0：即使用中]
	 * @param  [type] $mid [description]
	 * @return [type]      [description]
	 */
	public function zt_touse($mid)
	{
		$this->db->where(array('mid'=>$mid));
		$result = $this->db->update('main',array('zt'=>0));
		return $result;
	}

	/**
	 * [select_repair 根据rid选出所需要的维修记录，用于对单条维修记录进行修改]
	 * @param  [type] $rid [description]
	 * @return [type]      [description]
	 */
	public function select_repair($rid)
	{
		$result = $this->db->get_where('repair',array('rid'=>$rid))->result_array();
		return $result;
	}

	/**
	 * [check_repair 根据mid检查维修单中是否有在维修的单据，在修改维修单时，通过检查此项，
	 * 判断是否需要更改主设备表中的zt值]
	 * @param  [type] $mid [description]
	 * @return [type]      [description]
	 */
	public function check_repair($mid)
	{
		$this->db->where(array(
							'mid' => $mid,
							'rzt' => 4
							)
						);
		$this->db->from('repair');
		$result = $this->db->count_all_results();
		return $result;
	}

	/**
	 * [chang_zt 改变维修单的状态，用于维修单界面点击[完成]按钮后进行的数据库操作]
	 * @param  [type] $rid [description]
	 * @return [type]      [description]
	 */
	public function chang_rzt($rid)
	{
		$data['repair'] = $this->main->select_repair($rid);
		$rzt = $data['repair'][0]['rzt'];
		switch ($rzt) {             //对维修单的维修状态作判断，进行相应的操作
			case 0:					//0:表示维修单状态为已完成，需将状态切换至4
				$this->db->where(array('rid'=>$rid));
				$result = $this->db->update('repair',array('rzt'=>4));
				return $result;
				break;
			
			case 4:					//4:表示维修单状态为维修中，需将状态切换至0
				$this->db->where(array('rid'=>$rid));
				$result = $this->db->update('repair',array('rzt'=>0));
				return $result;
				break;
		}
	}

	/**
	 * [delete_repair 根据rid删除对应维修单]
	 * @return [type] [description]
	 */
	public function delete_repair($rid)
	{
		$result = $this->db->delete('repair',array('rid'=>$rid));
		return $result;
	}
	
	/**
	 * [showAllot 用于查询调拨表中所有未审核的单据]
	 * @return [type] [description]
	 */
	public function showUnshAllot()
	{
		$this->db->select('type.tname,type.firm,main.xhgg,main.sn,main.zcbh,allot.*');
		$this->db->select ('(select pname from t_place where pid = t_allot.oldpid) as oldpname');
		$this->db->select ('(select pname from t_place where pid = t_allot.newpid) as newpname');
		$this->db->join('main','main.mid = allot.mid');
		$this->db->join('type','type.tid = main.tid');
		$this->db->order_by('allot.mid');
		$result = $this->db->get_where('allot',array('sh' => 0))->result_array();
		return $result;
	}

	/**
	 * [setAllotSh 用于根据传入参数aid改变sh=1]
	 * @param [type] $aid [description]
	 */
	public function setAllotSh($aid)
	{
		$this->db->where(array('aid'=>$aid));
		$result = $this->db->update('allot',array('sh'=>1));
		return $result;
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


?>