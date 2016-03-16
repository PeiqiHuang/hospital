<?php 
header("Content-type: text/html; charset=utf-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MIn extends CI_Controller {

	public function index(){
		// $data["count"] = json_encode($this->medicine_model->getAllMedicinesCount());
		// $data["isMobile"] = $this->data_model->isMobile();
  //       $data["patientInfo"] = json_encode($this->medicine_model->getPatientInfoById($patientId));
  //       $data["medInfo"] = json_encode($this->medicine_model->getMOutMedInfoByPatientInfo($patientId));
  //       $data["diagnosis"] = json_encode($this->medicine_model->getDiagnosis());
  //       $data["bind"] = json_encode($this->medicine_model->getMedicineBind());
        $this->load->view('mIn.php');
	}

    
}