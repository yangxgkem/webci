<?php

require_once APPPATH.'/3rd/phpexcel/PHPExcel.php';

class Xls_service extends CI_Service {

	public function __construct()
	{
		parent::__construct();
	}

	//读取xls数据
	public function read_data($filename, $sheetname=NULL) 
	{
		//文件不存在直接返回
		if ( ! file_exists($filename)) return;
		
		$readertype = 'Excel5';
		if(strstr($filename, ".xlsx")) {
			$readertype = 'Excel2007';
		}
		$reader = PHPExcel_IOFactory::createReader($readertype);
		$reader->setReadDataOnly(true);//设置为只读模式
		$excel = $reader->load($filename);
		$allsheet = $excel->getSheetNames();
		$data = array();
		foreach ($allsheet as $key => $name) {
			if ( ! $sheetname OR $name==$sheetname) {
				$sheet = $excel->getSheetByName($name);
				$sheetdata = $sheet->toArray();
				if ($sheetname) return $sheetdata;
				$data[$name] = $sheetdata;
			}
		}
		return $data;
	}

	//数据写入xls
	public function write_data($filename, $data, $sheetname) 
	{
		$readertype = 'Excel5';
		if(strstr($filename, ".xlsx")) {
			$readertype = 'Excel2007';
		}

		if(file_exists($filename)) {
			$reader = PHPExcel_IOFactory::createReader($readertype);
			$excel = $reader->load($filename);
			$sheet = $excel->getSheetByName($sheetname); //工作表存在,则直接把数据写入该工作表
			if ( ! $sheet) {
				$sheet = $excel->createSheet(); //工作表不存在创建一个
			}
		}
		else {
			$excel = new PHPExcel();
			$sheet = $excel->getActiveSheet();
		}

		//行数据 单元格使用数据[1,65535]
		foreach($data as $row => $rowdata) {
            //列数据 单元格使用字母A-Z,第27列为AA, 28列AB, 以此类推
            foreach ($rowdata as $col => $value) {
            	//组装单元格:列+行
            	$columnName = PHPExcel_Cell::stringFromColumnIndex($col); //将列数字转换为字母 27==AA1
            	$cell = $columnName . ($row+1);
            	$sheet->setCellValue($cell, $value);
            }
        }
        //写入数据方法2
        //$sheet->fromArray($data);

        $sheet->setTitle($sheetname);
		$writer = PHPExcel_IOFactory::createWriter($excel, $readertype);
		$filename = iconv("utf-8", "gb2312", $filename);
		$writer->save($filename);
	}

	//将本地xls文件返回给浏览器
	public function send_xls($filename, $sendname) 
	{
		//文件不存在直接返回
		if ( ! file_exists($filename)) return;

		$readertype = 'Excel5';
		if(strstr($filename, ".xlsx")) {
			$readertype = 'Excel2007';
		}
		
		$reader = PHPExcel_IOFactory::createReader($readertype);
		$reader->setReadDataOnly(true);//设置为只读模式
		$excel = $reader->load($filename);

		//设置头信息
		header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment;filename="'.$sendname.'"');
	    header('Cache-Control: max-age=0');
	 
	    $writer = PHPExcel_IOFactory::createWriter($excel, $readertype);
	    $writer->save('php://output');
	}
}