<?php
use Twilio\Rest\Client;
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {
	private $sid = "AC568f93c0699dde97eb1fd4e10badace4";
	private $token = "d32cc3570c8905bd4a27a1510edc3fea";
	private $twilio_number = "+18557418954";

	public function send_sms() {
		$client = new Client($this->sid, $this->token);
		$client->messages->create(
		    // Where to send a text message (your cell phone?)
		    '+6738649788',
		    array(
		        'from' => $this->twilio_number,
		        'body' => $this->input->post('message')
		    )
		);
	}
}