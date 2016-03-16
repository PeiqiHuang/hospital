<?php 
header("Content-type: text/html; charset=utf-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MOut extends CI_Controller {

	public function index($patientId=""){
		$data["count"] = json_encode($this->medicine_model->getAllMedicinesCount());
		$data["isMobile"] = $this->data_model->isMobile();
        $data["patientInfo"] = json_encode($this->medicine_model->getPatientInfoById($patientId));
        $data["medInfo"] = json_encode($this->medicine_model->getMOutMedInfoByPatientInfo($patientId));
        // var_dump($data["medInfo"]);return;
        $data["diagnosis"] = json_encode($this->medicine_model->getDiagnosis());
        // $data["bind"] = json_encode($this->medicine_model->getMedicineBind());
        $this->load->view('mOut.php', $data);
	}
	
	public function getMedicine($name) {
		$name = urldecode($name);
		echo json_encode($this->medicine_model->getMedicine($name));
	}
    
	public function getMedicineById($id) {
		echo json_encode($this->medicine_model->getMedicineById($id));
	}    
    
	public function getMedicineByIdArray($idArray) {
		echo json_encode($this->medicine_model->getMedicineByIdArray($idArray));
	}
    
	public function getMedicineByCode($code) {
		echo json_encode($this->medicine_model->getMedicineByCode($code));
	}     
    
    public function getMedInfoByPatientId($patientId) {
    	echo json_encode($this->medicine_model->getMedInfoByPatientId($patientId));
    }

	public function updatePatient() {
		$id=$this->input->post('id');
		$realname=$this->input->post('realname');
        $age=$this->input->post('age');
        $gender=$this->input->post('gender');
        $phone=$this->input->post('phone');
        $address=$this->input->post('address');
        $diagnosis=$this->input->post('diagnosis');
        if ("" != $id) {
			$data["flag"] = $this->medicine_model->updatePatient($id,$realname,$age,$gender,$phone,$address,$diagnosis);
			$data["id"] = $id;
        } else {
			// create a new patient
			$data = array(
	               'number' => "" ,
	               'isAfternoon' => -1 ,
	               'name' => "" ,
	               'realname' => $realname ,
	               'gender' => $gender ,
	               'age' => $age,
	               'phone' => $phone,
	               'address' => $address,
	               'diagnosis' => $diagnosis
	            );
			$data["flag"] = $this->db->insert('patient', $data); 
			$data["id"] = $this->data_model->getPatientIdByRealname($realname);
        }
        echo json_encode($data);
	}   
    
    public function delMed($patientId){
    	echo $this->medicine_model->delMedByPatientId($patientId);
    }

	public function outMed($patientId) {
		$postArray = $this->input->post('data');
		$array = json_decode($postArray,TRUE);
		$price = array();
		for ($i = 0; $i < count($array); $i++) {
	      $price[$i] = $this->medicine_model->outMed($patientId,$array[$i]['medId'],$array[$i]['countPerTime'],$array[$i]['countPerDay'],$array[$i]['days']);
       	  // $price = $price + $p;
	    }
	    echo json_encode($price);
	}

	public function getBindMedInfo($id) {
		echo json_encode($this->medicine_model->getBindMedInfo($id));
	}
    
    public function test($patientId){
    	echo $this->getPrintPageCount($patientId);
    }
    
    public function showPrintPage($patientId, $page=1, $showPrice=false) {
    	$data["page"] = $page;
    	$data["patientId"] = $patientId;
    	$data["patientInfo"] = $this->medicine_model->getPatientInfoById($patientId);
    	$medInfo = $this->medicine_model->getMedInfoByPatientId($patientId);
        $data["medInfo"] = $medInfo;
        $data["showPrice"] = $showPrice;
        // var_dump($data);
        $this->load->view('print.php', $data);
    }

    public function showPrintFrameSet($patientId, $showPrice="false") {
    	$data["page"] = $this->getPrintPageCount($patientId);
    	$data["patientId"] = $patientId;
    	$data["patientInfo"] = $this->medicine_model->getPatientInfoById($patientId);
    	$medInfo = $this->medicine_model->getMedInfoByPatientId($patientId);
        $data["medInfo"] = $medInfo;
        $data["showPrice"] = $showPrice;
        $this->load->view('print_frameset.php', $data);
    }
	
	public function getPrintPageCount($patientId) {
		$medInfo = $this->medicine_model->getMedInfoByPatientId($patientId);
		$showCount = 0;
		$pageCount = 9;
		$page = 1;
		if (null != $medInfo) {
            for ($i=0;$i<count($medInfo);$i++) {
            	$name  = $medInfo[$i]["name"];
            	$price = $medInfo[$i]["price"];
            	$contain = $medInfo[$i]["contain"];
            	// $count++;
            	if ($name == "诊金" || $name == "病历本" || strpos($name,"耗材")=== 0 || strpos($name,"检查费")=== 0) {
            	    continue;
            	} else {
            	    $showCount++;
            	}
            }
            return ceil($showCount/9);
        } else {
        	return 0;
        }
	}
}