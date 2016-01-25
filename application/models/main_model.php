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
		$this->db->join('main','main.tid = type.tid');
		$this->db->order_by('tname','ASC');
		$this->db->order_by('firm','ASC');
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


	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


?>