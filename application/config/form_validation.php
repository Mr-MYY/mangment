<?php
$config = array(
			'main' => array(                             //新增、修改设备时的表单验证参数
				array(
					'field' => 'xhgg',
					'label' => '型号规格',
					'rules' => 'required'
					),
				array(
					'field' => 'dd',
					'label' => '安装地点',
					'rules' => 'required'
					),
				array(
					'field' => 'dhsj',
					'label' => '到货时间',
					'rules' => 'exact_length[8]|numeric'
					),
				array(
					'field' => 'azsj',
					'label' => '安装时间',
					'rules' => 'exact_length[8]|numeric'
					)
				),
			'type' => array(
				array(
					'field' => 'tname',
					'label' => '设备类型',
					'rules' => 'required'
				
				)
				),
			'place' => array(
				array(
					'field' => 'pname',
					'label' => '位置信息',
					'rules' => 'required'
				
				)
			)
				
		
	);
				


?>