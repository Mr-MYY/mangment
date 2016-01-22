<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class place_model extends CI_Model  //类型模型，用于进行模型的相关操作
{
	public function select_all_place()  //将所有类型选择出来；
	{
		$result = $this->db->get('place')->result_array();
		return $result;
	}
	
	public function insert_place($data)   //插入类型数据；
	{
		$this->db->insert('place',$data);
	}
	
	public function select_one($pid)    //根据传入参数tid,获得类型名称
	{
		$result = $this->db->get_where('place',array('pid'=>$pid))->result_array();
		return $result;
	}
	
	public function del_place($data)   //删除类型方法
	{
		$this->db->delete('place',$data);
	}
	
	public function count_place($data)  //查询改类型是否已使用，如果已经使用，即返回数量大于零，则不允许用户删除
	{
		$this->db->where($data);
		$result = $this->db->count_all_results('main');
		return $result;
	}
	
	public function check($data)              //插入时的名称校验，用来查询类型库中是否已有此类型
 	{
		$this->db->where($data);
		$result = $this->db->count_all_results('place');
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}






















?>