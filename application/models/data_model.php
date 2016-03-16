<?php
class Data_model extends CI_Model {

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

    function getWaitPeople($date, $isAfternoon){
        //$sql = "SELECT count(*) wait FROM `patient` WHERE id>(select max(patient) from `see` where date>='$date') and isAfternoon=$isAfternoon";
        $sql = "select count(*) patient from `patient` where date>='$date' and isAfternoon=$isAfternoon";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $patient = $result[0]['patient'];
        $sql = "select count(*) saw from `see` a,`patient` b where a.patient=b.id and a.date>='$date' and isAfternoon=$isAfternoon";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $saw = $result[0]['saw'];        
        return $patient - $saw;
    }

    function getForbidden($date, $isAfternoon){
        $sql = "select forbidden from `control` where date>='$date' and isAfternoon=$isAfternoon order by date desc limit 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($query->num_rows() < 1){
            $forbidden = 0;
        }else{
            $forbidden = $result[0]['forbidden'];
        }
        return $forbidden;
    }

    function getDisplay($date, $isAfternoon){

        // get current see id
        $currentId = $this->getCurrentSee($date, $isAfternoon);

        // haven't begin to see
        if($currentId == null){
            $sql = "select id, number, name from `patient`  where date>='$date' and isAfternoon=$isAfternoon order by number asc";
        }else{
            $sql = "select id, number, name from `patient`  where date>='$date' and isAfternoon=$isAfternoon and (id >= $currentId or number like '0%') order by number asc";
        }
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($query->num_rows() > 0){
            $i = 0;
            $j = 0;
            foreach ($query->result() as $row){
                // 过号的病人
                if(substr($result[$i]['number'], 0, 1) == "0"){
                    // delete prefix 0
                    $result[$i]['number'] = substr($result[$i]['number'], 1, strlen($result[$i]['number'])-1);
                    $result[$i]['waitTime'] = "已过号，前来咨询";
                    $result[$i]['waitCount'] = "-";
                    $i++;
                    continue;
                }
                // wait time
                $waitTime = $this->getWaitTime($date)*($j);
                $result[$i]['waitTime'] = "约等待".$waitTime."分钟";
                if($currentId == $result[$i]['id'] && $j == 0){
                    $result[$i]['waitTime'] = "正在就诊";
                }else if($currentId == null){
                    if($j == 0){
                        $result[$i]['waitTime'] = "请等待医生叫号";
                    }else{
                        $result[$i]['waitTime'] = "-";
                    }
                    
                }
                // wait count
                $result[$i]['waitCount'] = "前面还有".$j."人";
                $i++;
                $j++;
            }
        }else{
            $result = null;
        }
        return $result;
    }

    function getDisplayHalf($date){
        $sql = "select half from `display` where date>='$date' order by date desc limit 1";
        $result = $this->getSingleResult($sql, "half");
        if($result == null){
            $half = $this->isAfternoon();
            $data = array('half' => $half);
            $result = $this->db->insert('display', $data); 
            return $isAfternoon;
        }
        return $result;
    }

    function getDoctorDisplay($date, $isAfternoon){

        $sql = "select id, number, name, gender, age, phone from `patient` where date>='$date' and isAfternoon=$isAfternoon order by id asc";
        $result = $this->getAllResultArray($sql);
        return $result;
    }
    
    function getDoctorNewData($currentId, $date, $isAfternoon){
        if($currentId < 0){
            $sql = "select id, number, name, gender, age, phone from `patient` where date>='$date' and isAfternoon=$isAfternoon";
        }else{
            $sql = "select id, number, name, gender, age, phone from `patient` where date>='$date' and isAfternoon=$isAfternoon and id>'$currentId'";
        }
        $result = $this->getAllResultArray($sql);
        return $result;
    }
    
    function getCurrentSee($date, $isAfternoon){
        $sql = "select patient from `see` b,`patient` c where b.patient=c.id and c.date>='$date' and c.isAfternoon=$isAfternoon order by b.patient desc limit 1";
        return $this->getSingleResult($sql, "patient");
    }

    private function getWaitTime($date){
        // $sql = "select date from `see` where date>='$date' order by date desc";
        // $result = $this->getAllResultArray($sql);
        // if($result == null || count($result) == 1){
        //     // can't get data, default 10 min
        //     return 10;
        // }
        // $length = count($result)-1;
        // $lastTime = $result[0]['date'];
        // $firstTime = $result[$length]['date'];
        // $waitTime = floor((strtotime($lastTime) - strtotime($firstTime))/$length/60);
        // if($waitTime < 10){
        //     return 10;
        // }else{
        //     return $waitTime;
        // }
        return 3;
    }

    private function getPatientName($patientId){
        $sql = "select name from `patient` where id = $patientId";
        $nameData = $this->getSingleResult($sql, "name");
        return $nameData;
    }

    function getUnCallPatientsName(){
        $sql = "select a.patient id,name,number from `call` a,`patient` b where a.patient = b.id and state = 0 order by id asc";
        $result = $this->getAllResultArray($sql);
        if($result == null){
            return null;
        }
        $i = 0;
        foreach ($result as $row){
            $ids[$i] = $row["id"];
            $names[$i] = $row["name"];
            $i++;
        }
        //before return data, update state
        $sql = "update `call` set state = 1 where patient in (";
        $i = 0;
        foreach ($ids as $id) {
            $sql.= $id.",";
        }
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql.= ")";
        $updateCount = $this->db->query($sql);
        // if($updateCount < count($names)){
        //     return array_slice($names, 0, $updateCount);
        // }else{
        //     return $names;
        // }
        return $result;
    }

    function getlastPatientsId($date, $doctorId){
        $sql = "select patient from `call` where date>='$date' and doctor = '$doctorId' order by date desc limit 1";
        $result = $this->getSingleResult($sql, "patient");
        if($result == null){
            return -1;
        }
        return $result;
    }

    function getPatientNumber($date, $isAfternoon){
        $sql = "select count(*) number from `patient` where date>='$date' and isAfternoon=$isAfternoon";
        $number = $this->getSingleResult($sql, "number");
        if($number == null){
            if($isAfternoon == 0){
                $number = "A001";
            }else{
                $number = "B001";
            }
        }else{
            $number = $number + 1;
            $count = 3-strlen($number);
            for ($i = 0; $i < $count; $i++) {
                $number = "0".$number;
            }
            if($isAfternoon == 0){
                $number = "A".$number;
            }else{
                $number = "B".$number;
            }
            return $number;
        }
    }
    
    function getDoctors(){
        $sql = "select id, name from `doctor` order by id asc";
        return $this->getAllResultArray($sql);
    }

    function getPatientCount($date, $isAfternoon){
        // get current see id
        $currentId = $this->getCurrentSee($date, $isAfternoon);

        // haven't begin to see
        if($currentId == null){
            $sql = "select count(*) count from `patient`  where date>='$date' and isAfternoon=$isAfternoon";
        }else{
            $sql = "select count(*) count from `patient`  where date>='$date' and isAfternoon=$isAfternoon and id > $currentId";
        }
        $count = $this->getSingleResult($sql, "count");
        if($count == null){
            return 0;
        }else{
            return $count;
        }
    }

    function getDonePatient($date){
        $sql = "select doctor,patient from `see` where date>='$date' order by patient asc";
        return $this->getAllResultArray($sql);
    }

    function getSeeingPatient($date, $isAfternoon){
        $sql = "select c.doctor doctor,max(c.patient) patient, c.isAfternoon isAfternoon from (select doctor,patient, isAfternoon from `see` a,`patient` b where a.patient=b.id and a.date>='$date' and b.isAfternoon=$isAfternoon) c group by doctor";
        $result = $this->getAllResultArray($sql);
        return $result;
    }
    //判断是否属手机
    function isMobile() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
        $is_mobile = 0;
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = 1;
                break;
            }
        }
        return $is_mobile;
    }

    function isAfternoon(){
        date_default_timezone_set('PRC');
        if(date("H" ,time()) < 14) 
          return 0; 
        else 
          return 1;
    }

    function keep($patientId){
        $sql = "update `patient` set number = concat('0',number) where id='$patientId'";
        return $this->db->query($sql);
    }

    function cancelKeep($patientId){
        $sql = "update `patient` set number = right(number, 4) where id='$patientId'";
        return $this->db->query($sql); 
    }

    function getPatientIdByRealname($realname) {
        $sql = "select max(id) as id from `patient` where realname='$realname'";
        return $this->getSingleResult($sql, "id");
    }
}