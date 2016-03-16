<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guahao extends CI_Controller {

	public function index()
	{
		$data["isMobile"] = $this->data_model->isMobile();
		$this->load->view('main.php', $data);
	}
	public function name()
	{
		$data = array(
			'isAfternoon' => $this->input->post('isAfternoon')
		);		
		$data["isMobile"] = $this->data_model->isMobile();
		//var_dump($data);
		$this->load->view('name.php', $data);
	}
	public function gender()
	{
		$data = array(
			'isAfternoon' => $this->input->post('isAfternoon'),
			'name' => $this->input->post('name')
		);
		$data["isMobile"] = $this->data_model->isMobile();
		//var_dump($data);
		$this->load->view('gender.php', $data);
	}
	public function age()
	{
		$data = array(
			'isAfternoon' => $this->input->post('isAfternoon'),
			'name' => $this->input->post('name'),
			'gender' => $this->input->post('gender')
		);
		$data["isMobile"] = $this->data_model->isMobile();
		//var_dump($data);
		$this->load->view('age.php', $data);
	}
	public function phone()
	{
		$data = array(
			'isAfternoon' => $this->input->post('isAfternoon'),
			'name' => $this->input->post('name'),
			'gender' => $this->input->post('gender'),
			'age' => $this->input->post('age')
		);
		$data["isMobile"] = $this->data_model->isMobile();
		//var_dump($data);
		$this->load->view('phone.php', $data);
	}	
	public function finish()
	{
		$isAfternoon = $this->input->post('isAfternoon');
		$name = $this->input->post('name');
		$gender = $this->input->post('gender');
		$age = $this->input->post('age');
		$phone = $this->input->post('phone');
        //get its number
        date_default_timezone_set('PRC');
		$date = date("Y-m-d");
        $number = $this->data_model->getPatientNumber($date, $isAfternoon);
		//go to database
		$data = array(
               'number' => $number ,
               'isAfternoon' => $isAfternoon ,
               'name' => $name ,
               'gender' => $gender ,
               'age' => $age,
               'phone' => $phone
            );
		$result = $this->db->insert('patient', $data); 
		if($result == 1){
			//go to success
			header("Location:".site_url("guahao/success/".$number)); 
		}else{
			header("Location:".site_url("guahao/fail")); 
		}
	}
	public function test(){
		// echo $this->data_model->getPatientNumber("2015-5-1", 1);
		echo date("Y-m-d H:m:s");
	}
	public function success($number=-1){
		$data["number"] = $number;
		$this->load->view('success.php', $data);
	}
	public function fail(){
		$this->load->view('fail.php');
	}
	public function refreshMain(){
		date_default_timezone_set('PRC');
		$date = date("Y-m-d");
        //$isAfternoon = $this->compareTime(date("H:m:s"),"14:00:00");
        //echo $date."\n";
        //echo $isAfternoon;
        // $morningCount = $this->data_model->getWaitPeople($date, 0);
        // $afternoonCount = $this->data_model->getWaitPeople($date, 1);
        $morningCount = $this->data_model->getPatientCount($date, 0);
        $afternoonCount = $this->data_model->getPatientCount($date, 1);
        $morningForbidden = $this->data_model->getForbidden($date, 0);
        $afternoonForbidden = $this->data_model->getForbidden($date, 1);
		$data = array(
               'morningCount' => $morningCount ,
               'afternoonCount' => $afternoonCount,
               'morningForbidden' => $morningForbidden ,
               'afternoonForbidden' => $afternoonForbidden
            );
        echo json_encode($data);
	}
	private function compareTime($timeStr1, $timeStr2){
		if(strtotime($timeStr1)>strtotime($timeStr2)){
			return 1;
		}else{
			return -1;
		}
	}
	public function display($row=4){
        date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		$isAfternoon = $this->data_model->getDisplayHalf($date);
		// echo $isAfternoon;return;
        $data["data"] = json_encode($this->data_model->getDisplay($date, $isAfternoon));
        $data["isAfternoon"] = $isAfternoon;
        $data["row"] = $row;
        // var_dump( $data);return;
        $this->load->view('display.php', $data);
	}
    
	public function refreshDisplay($isAfternoon=0){
        date_default_timezone_set('PRC');
		$date = date("Y-m-d");
        echo json_encode($this->data_model->getDisplay($date, $isAfternoon));
	}

	public function getDisplayHalf(){
		date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		echo $this->data_model->getDisplayHalf($date);
	}

	public function call(){
		$names = $this->data_model->getUnCallPatientsName();
		echo json_encode($names);
	}
    
    public function doctor($doctorId=1){
        date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		$isAfternoon = $this->data_model->isAfternoon();
        $data["morningData"] = json_encode($this->data_model->getDoctorDisplay($date, 0));//$isAfternoon)
        $data["afternoonData"] = json_encode($this->data_model->getDoctorDisplay($date, 1));
        $data["doctors"] = $this->data_model->getDoctors();
        $data["doctorId"] = $doctorId;
        $data["isAfternoon"] = $isAfternoon;
        $data["displayNoon"] = $this->data_model->getDisplayHalf($date);
        $data["morningForbidden"] = $this->data_model->getForbidden($date, 0);
        $data["afternoonForbidden"] = $this->data_model->getForbidden($date, 1);
        $data["isMobile"] = $this->data_model->isMobile();
        // echo ($data["isMobile"]);
        if (1 == $data["isMobile"])
        	$this->load->view('doctor.php', $data);
        else
        	$this->load->view('doctor_laptop.php', $data);
    }
    
    public function getPatientTable($currentId, $isAfternoon){
        date_default_timezone_set('PRC');
		$date = date("Y-m-d");
        echo json_encode($this->data_model->getDoctorNewData($currentId, $date, $isAfternoon));
    }

    public function getPatientCount(){
    	date_default_timezone_set('PRC');
		$date = date("Y-m-d");
    	$data["morningCount"] = $this->data_model->getPatientCount($date, 0);
    	$data["afternoonCount"] = $this->data_model->getPatientCount($date, 1);
    	echo json_encode($data);
    }

    public function insertControl($isAfternoon, $forbidden){
		$data = array(
               'isAfternoon' => $isAfternoon ,
               'forbidden' => $forbidden
            );
		$result = $this->db->insert('control', $data); 
		if($result == 1){
			echo 1;
		}else{
			echo 0;
		}
    }

    public function insertDisplay($half){
		$data = array(
               'half' => $half
            );
		$result = $this->db->insert('display', $data); 
		if($result == 1){
			echo 1;
		}else{
			echo 0;
		}
    }

    public function getControl(){
    	date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		$data["morningForbidden"] = $this->data_model->getForbidden($date, 0);
    	$data["afternoonForbidden"] = $this->data_model->getForbidden($date, 1);
    	echo json_encode($data);
    }

    public function getDonePatient(){
    	date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		echo json_encode($this->data_model->getDonePatient($date));
    }
    
    public function getSeeingPatient($isAfternoon){
    	date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		echo json_encode($this->data_model->getSeeingPatient($date, $isAfternoon));
    }

    public function callNext($patientId, $doctorId){
		$data = array(
               'patient' => $patientId ,
               'doctor' => $doctorId
            ); 
		$result = $this->db->insert('see', $data); 
		$result = $this->db->insert('call', $data); 
		if($result == 1){
			echo 1;
		}else{
			echo 0;
		}
    }

	public function recall($doctorId){
		date_default_timezone_set('PRC');
		$date = date("Y-m-d");
		// echo $doctorId."|".$date;
		$patientId = $this->data_model->getlastPatientsId($date, $doctorId);
		if($patientId == -1){
			echo -1;
			return;
		}
		$data = array(
               'patient' => $patientId ,
               'doctor' => $doctorId
            ); 
		$result = $this->db->insert('call', $data);
		if($result == 1){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function keep($patientId){
		$result = $this->data_model->keep($patientId);
		if($result == 1){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function cancelKeep($patientId){
		$result = $this->data_model->cancelKeep($patientId);
		if($result == 1){
			echo 1;
		}else{
			echo 0;
		}
	}	
}
