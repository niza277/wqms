<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reading extends CI_Controller {

	public function __construct() {
		parent::__construct();
		header('content-type: application/json; charset=utf-8');
	}


	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function select_all() {
		$readings = $this->db->get('reading')->result();
		echo json_encode($readings);
	}

	public function select() {
		$reading = $this->db->get_where('reading', array("reading_id" => $_GET['reading_id']))->row();
		echo json_encode($reading);
	}

	public function selectHistory($year, $month, $date) {
		$tomorrow = $date + 1;
		$reading = $this->db->get_where('reading', "datetime > '$year-$month-$date 00:00:00' AND datetime < '$year-$month-$tomorrow 00:00:00'")->result();
		echo json_encode($reading);
	}

	public function selectHistoryDatetime($year, $month, $date, $start, $end) {
		$reading = $this->db->get_where('reading', "datetime > '$year-$month-$date $start:00:00' AND datetime < '$year-$month-$date $end:00:00'")->result();
		echo json_encode($reading);
	}

	public function add() {
		$data['phReading'] = $_GET['ph'];
		$data['turbidityReading'] = $_GET['turbidity'];
		$success = $this->db->insert("reading", $data);
		if ($success) {
			$message = "add readings successfully";
		} else {
			$message = "fail to add readings";
		}
		echo json_encode(array("success" => $success, "message" => $message));
	}

	public function delete() {
		$success = $this->db->where(array('reading_id' => $_GET['reading_id']))->delete('reading');
		if ($success) {
			$message = "delete readings successfully";
		} else {
			$message = "fail to delete readings";
		}
		echo json_encode(array("success" => $success, "message" => $message));
	}

	public function update() {
		$data['phReading'] = $_GET['ph'];
		$data['turbidityReading'] = $_GET['turbidity'];
		$success = $this->db->where(array('reading_id' => $_GET['reading_id']))->update('reading', $data);
		if ($success) {
			$message = "update readings successfully";
		} else {
			$message = "fail to update readings";
		}
		echo json_encode(array("success" => $success, "message" => $message));
	}

	public function getDateTimeReading() {
		$readings = $this->db
			->order_by('datetime', 'asc')
			->get('reading')->result_array();
		$reading = array();
		for ($i = 0; $i < count($readings); $i++) {
			$reading[$i] = array($readings[$i]['reading_id'], $readings[$i]['datetime'], $readings[$i]['phReading'], $readings[$i]['turbidityReading']);
		}
		$data['draw'] = 1;
		$data['recordsTotal'] = count($reading);
		$data['recordsFiltered'] = count($reading);
		$data['data'] = $reading;

		header('Content-Type: application/json');
		echo json_encode($data);
	}
}
