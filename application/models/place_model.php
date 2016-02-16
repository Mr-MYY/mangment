<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class place_model extends CI_Model  //类型模型，用于进行模型的相关操作
{
	public function select_all_place()  //将所有地点选择出来；
	{
		$this->db->order_by('pname','ASC');
		$result = $this->db->get('place')->result_array();
		return $result;
	}
	
	public function insert_place($data)   //插入地点数据；
	{
		$this->db->insert('place',$data);
	}
	
	public function select_one($pid)    //根据传入参数tid,获得地点名称
	{
		$result = $this->db->get_where('place',array('pid'=>$pid))->result_array();
		return $result;
	}
	
	public function del_place($data)   //删除地点方法
	{
		$this->db->delete('place',$data);
	}
	
	public function count_place($data)  //查询改地点是否已使用，如果已经使用，即返回数量大于零，则不允许用户删除
	{
		$this->db->where($data);
		$result = $this->db->count_all_results('main');
		return $result;
	}
	
	public function check($data)              //插入时的名称校验，用来查询类型库中是否已有此地点
 	{
		$this->db->where($data);
		$result = $this->db->count_all_results('place');
		return $result;
	}
	
	public function search_place($data)       //根据地点名称定位地点，采用模糊搜索
	{
		$this->db->like($data);
		$result = $this->db->get('place')->result_array();
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}






















?>