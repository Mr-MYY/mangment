<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index_login extends CI_Controller //前台主界面控制器，控制所有主界面操作
{
	public function index()
	{
		$this->load->view('index/login_index.html');
	}
}


/* End of file index_login.php */
/* Location: ./application/controllers/index_login.php */
?>	