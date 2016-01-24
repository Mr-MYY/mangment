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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


?>