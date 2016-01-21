<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Type_model extends CI_Model  //类型模型，用于进行模型的相关操作
{
	public function select_all_type()  //将所有类型选择出来；
	{
		$result = $this->db->get('type')->result_array();
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}






















?>