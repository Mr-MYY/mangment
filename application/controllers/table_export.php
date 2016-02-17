<?php
/**
 *在CI框架中调用phpexcel导出数据库内容
 *此文件为控制器文件，需放至application\controllers文件夹中运行，在网页中输入
 *CI中此方法后，会在根目录\xls文件夹下生成相应的文件。
 *安装PHPExcel到Codeigniter：
 *A、解压压缩包里的Classes文件夹中的内容到application\libraries\目录下，目录结构如下：
 *-- application\libraries\PHPExcel.php
 *-- application\libraries\PHPExcel (文件夹)
 *B、修改application\libraries\PHPExcel\IOFactory.php 文件
 *-- 将其类名从PHPExcel_IOFactory改为IOFactory，遵从CI类命名规则。
 *-- 将其构造函数改为public
 * 
 */
class Table_export extends CI_Controller {

	function __construct()
	{ 
		parent::__construct();
		$this->load->model('main_model','main');
	}

	/**
	 * [index 导出excel方法，用来将query中的内容导出成excel并提供用户下载]
	 * @return [type] [description]
	 */
	function index()
	{
		$query = $this->db->
		query("select b.firm as '厂商',b.tname as '类型',a.xhgg as '型号规格', 
			a.sn as 'S/N',a.zcbh as '资产编号',a.zt as '状态',a.je as '金额',a.dhsj as '到货时间',
			c.pname as '地点',a.azsj as '安装时间',a.fph as '发票号',a.hth as '合同号',a.bz as '备注'
			from `t_main` a, `t_type` b,`t_place` c 
			where a.tid = b.tid and a.pid = c.pid
			order by a.pid,a.tid");


		$this->load->library('PHPExcel'); 
		$this->load->library('PHPExcel/IOFactory');

		$objPHPExcel = new PHPExcel();           //创建PHPExcel对象
		$objPHPExcel->getProperties()->setTitle("设备总表")->setDescription("none");//设置excel标题
		$objPHPExcel->setActiveSheetIndex(0);            // 设置活动表单
		$fields = $query->list_fields();                 // 获得数据库查询表头
		$col = 0;
		foreach ($fields as $field)
			{
				$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray(          //设定颜色单色
					array('fill' => array(
					'type' =>PHPExcel_Style_Fill::FILL_SOLID,         //设定表头颜色样式
					'color' => array('rgb' => 'D1EEEE')
										)
						)
																				);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
				//输出表头内容
				$col++;
			}

// Fetching the table data
		$row = 2;
		foreach($query->result() as $data) //循环输出结果
			{
				$col = 0;
					foreach ($fields as $field)
					{
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
						$col++;
					}

		$row++;

			}

		$objPHPExcel->setActiveSheetIndex(0);

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

		$excelname = 'main'.date('YmdHis',time());    //用时间定义生成的excel文档
 		$objWriter->save('xls\\'.$excelname.'.xls');

		header("Content-Type: application/force-download");//跳出下载框强制用户下载
		header("Content-Disposition: attachment; filename=".$excelname.'.xls');//设置下载框文件名
		if (readfile('xls\\'.$excelname.'.xls'))           //注意此处的文件目录应与$objWriter->save('xls\\'.$excelname.'.xls');的一致
		{
			$data['main'] = $this->main->select_main();
			$data['type'] = $this->main->select_distinct_type();
		 	// print_r($data);die;
			$this->load->view('index/main.html',$data);
		}

	

		
	}

}
?>