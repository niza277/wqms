<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		require_once("assets/Classes/PHPExcel.php");
	}

	public function index() {
		$this->load->view('layouts/header');
		$this->load->view('home/reading');
		$this->load->view('layouts/footer');
	}

	public function viewExcel() {
		$this->load->view('layouts/header');
		$this->load->view('home/view_excel');
		$this->load->view('layouts/footer');
	}
	
	public function historical() {
		if (empty($_GET['year']) && empty($_GET['year']) && empty($_GET['date'])) {
			$this->load->view('layouts/header');
			$this->load->view('home/historical');
			$this->load->view('layouts/footer');
		} else {
			$data["year"] = $_GET['year'];
			$data["month"] = $_GET['month'];
			$data["date"] = $_GET['date'];
			$this->load->view('layouts/header');
			$this->load->view('home/view_historical', $data);
			$this->load->view('layouts/footer');
		}
	}

	public function historicalDatetime() {
		if (empty($_GET['year']) && empty($_GET['year']) && empty($_GET['date']) && empty($_GET['start']) && empty($_GET['end'])) {
			$this->load->view('layouts/header');
			$this->load->view('home/historical');
			$this->load->view('layouts/footer');
		} else {
			$data["year"] = $_GET['year'];
			$data["month"] = $_GET['month'];
			$data["date"] = $_GET['date'];
			$data["start"] = $_GET['start'];
			$data["end"] = $_GET['end'];
			$this->load->view('layouts/header');
			$this->load->view('home/view_historical_datetime', $data);
			$this->load->view('layouts/footer');
		}
	}

	public function excel() {
		if (empty($_GET['year']) && empty($_GET['year']) && empty($_GET['date'])) {
			$this->load->view('layouts/header');
			$this->load->view('home/view_excel');
			$this->load->view('layouts/footer');
		} else {
			$data["year"] = $_GET['year'];
			$data["month"] = $_GET['month'];
			$data["date"] = $_GET['date'];
			$this->load->view('layouts/header');
			$this->load->view('home/view_excel');
			$this->load->view('layouts/footer');
		}
	}

	public function json() {
		$this->load->view('json/reading.json');
	}

	public function getExcelData() {
		$objPHPExcel = new PHPExcel();

		//Set document properties
		$objPHPExcel->getProperties()->setCreator("Mitrajit Samanta")
									 ->setLastModifiedBy("Mitrajit Samanta")
									 ->setTitle("User's Information")
									 ->setSubject("User's Personal Data")
									 ->setDescription("Description of User's")
									 ->setKeywords("")
									 ->setCategory("");

		// Set default font
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
		                                          ->setSize(10);

		//Set the first row as the header row
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID')
									  ->setCellValue('B1', 'DATE')
									  ->setCellValue('C1', 'PHREADING')
									  ->setCellValue('D1', 'TURBIDITYREADING');
									  
		//Rename the worksheet
		$objPHPExcel->getActiveSheet()->setTitle('USER INFO');

		//Set active worksheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$data = $this->db->get('reading')->result_array();

		for ($i = 0; $i < count($data); $i++) {
			$j = $i+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data[$i]['reading_id'])
									  ->setCellValue('B'.$j, $data[$i]['datetime'])
									  ->setCellValue('C'.$j, $data[$i]['phReading'])
									  ->setCellValue('D'.$j, $data[$i]['turbidityReading']);	
		}

		$filename = date('d-m-Y_H-i-s').".xlsx";

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		//if you want to save the file on the server instead of downloading, 
		//comment the last 3 lines and remove the comment from the next line
		//$objWriter->save(str_replace('.php', '.xlsx', $filename));
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		$objWriter->save("php://output");
	}

}
