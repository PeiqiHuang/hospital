<?php 
header("Content-type: text/html; charset=utf-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller {

	public function index($name="", $gender="", $age="", $phone=""){
		$data["medicines"] = json_encode($this->medicine_model->getAllMedicines());
		$data["isMobile"] = $this->data_model->isMobile();
		$data["name"] = $name;
		$data["gender"] = $gender;
		$data["age"] = $age;
		$data["phone"] = $phone;
		$this->load->view('recipe.php', $data);
	}
	
	public function getMedicine($name) {
		$name = urldecode($name);
		echo json_encode($this->medicine_model->getMedicine($name));
	}
}