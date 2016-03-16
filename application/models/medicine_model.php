<?php
class Medicine_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    // select helper
    private function getSingleResult($sql, $field){
        $query = $this->db->query($sql);
        if($query->num_rows() < 1){
            return null;
        }
        $result = $query->result_array();
        return $result[0][$field];
    }

    // select helper
    private function getAllResultArray($sql){
        $query = $this->db->query($sql);
        if($query->num_rows() < 1){
            return null;
        }
        return $query->result_array();
    }

    // insert a new medicine
    public function insertMedicine($id, $code, $name, $unit, $contain, $basicUnit, $countPerTime, $countPerDay, $days, $company, $remark){
        $data = array(
           'id' => $id ,
           'code' => $code ,
           'name' => $name,
           'unit' => $unit ,
           'contain' => $contain,
           'basicUnit' => $basicUnit,
           'countPerTime' => $countPerTime,
           'countPerDay' => $countPerDay,
           'days' => $days,
           'company' => $company,
           'remark' => $remark
        );
        $this->db->insert('medicine', $data); 
    }

    // show all medicine
    public function getAllMedicines(){
        //$sql = "select * from `medicine` order by date";
        $sql = "select * from `medicine` left join (select a.medicine,a.price from `mprice` a where a.id=(select max(b.id) from `mprice` b where a.medicine=b.medicine)) c on  id=medicine order by id asc";
        $result = $this->getAllResultArray($sql);
        return $result;
    }
  // show count of all medicines
    public function getAllMedicinesCount(){
        $sql = "select count(*) count from `medicine`";
        return $this->getSingleResult($sql, "count");
    }       
    // show medicine by name
    public function getMedicine($name){
        $sql = "select * from `medicine` where name='$name'";
        $result = $this->getAllResultArray($sql);
        return $result[0];
    }
    // show medicine by fuzzy id
    public function getMedicineById($id){
        $sql = "select * from `medicine` where id like '$id%'";
        return $this->getAllResultArray($sql);
    }
    // show medicine by  idArray like 23,45,42
    public function getMedicineByIdArray($idArray){
        $idArray = str_replace('_', ',',$idArray);
        // SELECT * FROM `medicine` WHERE id in (6,26,14,15) order by INSTR(',46,26,14,15,',CONCAT(',',id,','))
        $sql = "select * from `medicine` where id in ($idArray) order by INSTR(',$idArray,',CONCAT(',',id,','))";
        return $this->getAllResultArray($sql);
    }    
    // show medicine by fuzzy code like KTK
    public function getMedicineByCode($code){
        $sql = "select * from `medicine` where code like '$code%'";
        return $this->getAllResultArray($sql);
    }    
    // get all unit
    public function getUnits(){
      $sql = "select unit from `unit`";
      $result = $this->getAllResultArray($sql);
      $unitString = "";
      foreach ($result as $row){
        $unitString .= $row["unit"].",";
      }
      return $unitString;
    }

    // check Medicine Id Unique
    public function checkMedicineIdUnique($id){
      $sql = "select count(*) count from `medicine` where id='$id'";
      return $this->getSingleResult($sql, "count");
    }

    // getUsedMedicineIds
    public function getUsedMedicineIds(){
      $sql = "select id from `medicine`";
      return $this->getAllResultArray($sql);
    }

    // delete a medicine
    public function delMedicine($name){
      $this->db->delete('medicine', array('name' => $name)); 
    }
    
    function getPatientInfoById($id){
        $sql = "select * from `patient` where id='$id'";
        $result = $this->getAllResultArray($sql);
        return $result[0];
    }

    function updatePatient($id,$realname,$age,$gender,$phone,$address,$diagnosis) {
      $sql = "update `patient` set age='$age', realname='$realname', gender='$gender', phone='$phone', address='$address', diagnosis='$diagnosis' where id='$id'";
        // echo $sql;
      $result = $this->db->query($sql);
      return $result;
    }
    
    function insertPrice($id,$price) {
        $data["medicine"] = $id;
        $data["price"] = $price;
        $result = $this->db->insert('mprice', $data);
        return $result;     
    }
    // in a medicine
    
    function getMedPrice($id) {
      $sql = "select price from `mprice` where medicine='$id' order by id desc limit 1";
      return $this->getSingleResult($sql, "price");
    }

    function getMedColById($medId, $col) {
      $sql = "select $col from `medicine` where id='$medId'";
      return $this->getSingleResult($sql, $col);
    }

    // out a medicine
    function outMed($patientId,$medId,$countPerTime,$countPerDay,$days) {
        $data["patient"] = $patientId;
        $data["medicine"] = $medId;
        $data["countPerTime"] = $countPerTime;
        $data["countPerDay"] = $countPerDay;
        $data["days"] = $days;
        // get price
        $price = $this->getMedPrice($medId);
        // get unit
        $unit = $this->getMedColById($medId, "unit");
        // get basicUnit
        $basicUnit = $this->getMedColById($medId, "basicUnit");
        // get contain
        $contain = $this->getMedColById($medId, "contain");
        if (($unit == "盒" && $basicUnit == "盒") || ($unit == "支" && $basicUnit == "支")) {
          $data["outPrice"] = $price*$countPerTime;
        }else if ($unit == "盒" && $basicUnit != "盒") {
          $total = $countPerTime*$countPerDay*$days;
          $data["outPrice"] = ceil($total/$contain)*$price;
        } else if ($unit == "瓶"||$unit == "套"||$unit == "人"||$unit == "本") {
          $data["outPrice"] = $price*$countPerTime;
        }else {
          $data["outPrice"] = $price*$countPerTime*$countPerDay*$days;
        }
        // var_dump($data);
        $this->db->insert('out', $data);
        return $data["outPrice"];
    }
    
    // delete all med of a patinet
    function delMedByPatientId($patientId) {
      $sql = "delete from `out` where patient='$patientId'";
        $result = $this->db->query($sql);
        return $result;
    }
    
    // get medicines of a patient for print page
    function getMedInfoByPatientId($patientId) {
      $sql = "select name,basicUnit,unit,remark,a.contain,b.countPerTime,b.countPerDay,b.days,outPrice price from `medicine` a,`out` b where a.id=b.medicine and b.patient='$patientId' order by b.id asc";
      $result = $this->getAllResultArray($sql);
      // if (null == $result) return new array();  
      return $result;
    }
    // get all medicine by patient id
    public function getMOutMedInfoByPatientInfo($patientId) {
      $sql = "select a.id,a.code,a.name,a.unit,a.contain,a.basicUnit,b.countPerTime,b.countPerDay,b.days,a.remark,b.outPrice from `medicine` a,`out` b where a.id=b.medicine and b.patient='$patientId' order by b.id asc";
      $result = $this->getAllResultArray($sql);
        return $result;
    }
    // update medicine out price

    // count a patient money

    //  
    public function getDiagnosis(){
      $sql="select name from `diagnosis` order by id asc";
      $result = $this->getAllResultArray($sql);
      $i = 1;
      $ret[0] = "";
      foreach ($result as $row){
        $ret[$i++] = $row["name"];
      }
      return $ret;
    }

    public function getDiagnosisById($id) {
      $sql="select name from `diagnosis` where id='$id'";
      return $this->getSingleResult($sql, "name");
    }

    public function getMedicineBind() {
      $sql="SELECT `药品` addMed,`捆绑` followMed FROM `药品捆绑` order by id asc";
      $result = $this->getAllResultArray($sql);
      return $result;
    }

    function getBindMedInfo($id) {
      $sql="SELECT `捆绑` followMed FROM `药品捆绑` where `药品`=$id order by id asc";
      $result = $this->getAllResultArray($sql);
      $i = 0;
      foreach ($result as $row){
        $follow = $row["followMed"];
        $infos = $this->getMedicineById($follow);
        $ret[$i++] = $infos[0];
      }
      return $ret;
    }
}