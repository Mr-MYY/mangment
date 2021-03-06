<?php
$config = array(
			'main' => array(                             //新增、修改设备时的表单验证参数
				array(
					'field' => 'xhgg',
					'label' => '型号规格',
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
					),
				array(
					'field' => 'je',
					'label' => '金额',
					'rules' => 'numeric'
					)
				),
			'type' => array(
				array(
					'field' => 'tname',
					'label' => '设备类型',
					'rules' => 'required'
				
				),
				array(
					'field' => 'firm',
					'label' => '厂商',
					'rules' => 'required'
				
				)
				),
			'place' => array(
				array(
					'field' => 'pname',
					'label' => '位置信息',
					'rules' => 'required'
				
				)
			),
			'repair' => array(
				array(
					'field' => 'gzsm',
					'label' => '故障说明',
					'rules' => 'required'
					),
				array(
					'field' => 'sxsj',
					'label' => '送修时间',
					'rules' => 'exact_length[8]|numeric|required'
					),
				array(
					'field' => 'fhsj',
					'label' => '返回时间',
					'rules' => 'exact_length[8]|numeric'
					),
				)
		
	);
$config['error_prefix'] = '<span style="color:red">';
$config['error_suffix'] = '</span>';
				


?>