<?php 
header("Content-type: text/html; charset=utf-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicine extends CI_Controller {

	public function index(){
		$data["medicines"] = json_encode($this->medicine_model->getAllMedicines());
		$data["isMobile"] = $this->data_model->isMobile();
		// var_dump($data["bind"]);return;
		$this->load->view('medicineStore.php', $data);
	}
	public function updateMedicine($id, $index, $item){
		$item = urldecode($item);
        if($index == 11){
            echo $this->medicine_model->insertPrice($id,$item);
            // echo $item; 
            return;
        }
        if($index == 0){
        	$taken = $this->medicine_model->checkMedicineIdUnique($item);
        	if (0 != $taken) {
        		echo "编号已经被使用，请使用其他";
        		return;
        	}
        	$data["id"] = $item;
        }else if($index == 1){
        	$data["code"] = $item;
        }else if($index == 2) {
			$data["name"] = $item;
		}else if($index == 3){
			$data["unit"] = $item;
		}else if($index == 4){
			$data["contain"] = $item;
		}else if($index == 5){
			$data["basicUnit"] = $item;
		}else if($index == 6){
			$data["countPerTime"] = $item;
		}else if($index == 7){
			$data["countPerDay"] = $item;
		}else if($index == 8){
			$data["days"] = $item;
		}else if($index == 9){
			$data["company"] = $item;
		}else if($index == 10){
			$data["remark"] = $item;
		}
		$this->db->where('id', $id);
		$result = $this->db->update('medicine', $data);
		//更新价格表的id
		// if($index == 0){
		// 	$data2["medicine"] = $item;
		// 	$this->db->where('medicine', $id);
  //       	$result = $this->db->update('mprice', $data2);
  //       }
		echo $result; 
		// var_dump($data);
	}

	public function getUnits(){
		$unit = $this->medicine_model->getUnits();
		echo $unit;
		// echo json_encode($unit);
	}	
	public function checkMedicineIdUnique($id){
		echo $this->medicine_model->checkMedicineIdUnique($id);
	}	
	public function getUsedMedicineIds(){
		echo json_encode($this->medicine_model->getUsedMedicineIds());
	}
	public function insertNewMedicine($id,$code,$name,$unit,$contain,$basicUnit,$countPerTime,$countPerDay,$days,$company,$remark,$price){
		$name = urldecode($name);
		$unit = urldecode($unit);
		$basicUnit = urldecode($basicUnit);
		$company = urldecode($company);
		$remark = urldecode($remark);
		// echo $id;echo $name;echo $unit;echo $contain;echo $basicUnit;echo $countPerTime;echo $countPerDay;echo $days;echo $company;echo $remark;
		$this->medicine_model->insertMedicine($id, $code, $name, $unit, $contain, $basicUnit, $countPerTime, $countPerDay, $days, $company, $remark);
        $this->medicine_model->insertPrice($id,$price);
	}
	public function delMedicine($name){
		$name = urldecode($name);
		$this->medicine_model->delMedicine($name);
	}

	public function file($code) {
		echo "<div style='text-align:center;'>";
		echo "<img src='".base_url()."/asserts/image/$code"."1.jpg' />";
		echo "&nbsp";
		echo "<img src='".base_url()."/asserts/image/$code"."2.jpg' />";
		echo "</div>";
	}

	public function seein($id) {
		
	}

	public function test() {
		echo json_encode($this->medicine_model->getDiagnosis());
	}

	
}