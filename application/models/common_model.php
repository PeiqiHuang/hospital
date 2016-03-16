<?php
class Common_model extends CI_Model {

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

    public function getCount($table) {
        $sql = "select count(*) count from `$table`";
        return $this->getSingleResult($sql, "count");
    }
    
    public function getRows($table,$where,$perPage,$offset) {
        if ($table == "unit") 
            $sql = "select id, unit '单位' from `$table`";
        else if ($table == "doctor") 
            $sql = "select id, name '医生' from `$table`";
        else if ($table == "medicine") 
            $sql = "select id '编号', code '拼音', name '名字', unit '单位', contain '含量', basicUnit '小单位', countPerTime '1次', countPerday '1天', days '天数', remark '备注' from `$table`";    
        else if ($table == "patient") 
            $sql = "select id, number '编号',name '名字',realname '真名',gender '性别',age '年龄',phone '电话',address '地址',date as '时间',diagnosis '诊断' from `$table`";
        else if ($table == "diagnosis") 
            $sql = "select id, name '诊断' from `$table`";
        else
    		$sql = "select * from `$table`";
    	if ("" != $where)
    		$sql .= "where ".$where;
    	$sql .= " order by id desc limit $offset,$perPage";
        return $this->getAllResultArray($sql);
    }
    
    public function getHeader($table) {
        if ($table == "unit") 
            return array("单位");
        else if ($table == "doctor") 
            return array("医生");
        else if ($table == "medicine") 
            return array("编号","拼音","名字","单位","含量","小单位","1次","1天","天数","备注");  
        else if ($table == "patient") 
            return array("编号","名字","真名","性别","年龄","电话","地址","时间","诊断");   
        else if ($table == "diagnosis") 
            return array("诊断");     
        else {
            $sql = "SHOW COLUMNS FROM `$table`";
            $result = $this->getAllResultArray($sql);
            $data = array();
            $i = 0;
            foreach($result as $row) {
                if ("id" != $row["Field"]) {
                    $data[$i] = $row["Field"];
                    $i++;
                }
            }
            return $data;
        }
    }
    
    public function getEditColumn($table){
        //if ($table == "unit") 
        //    return array(0);
        //else {
            $data = array();
            $count = count($this->getHeader($table));
            for($i=0;$i<$count;$i++) {
            	$data[$i] = $i;
            }
            return $data;
        //}
            
    }
    
    public function getTableTitle($table) {
    	if ($table == "unit") 
            return "药单位管理";
        else if ($table == "doctor") 
            return "医生管理";
        else if ($table == "medicine") 
            return "药品管理";
        else if ($table == "patient") 
            return "选择病人查看";
        else if ($table == "diagnosis") 
            return "诊断管理";
        else
            return $table;
    }
    
    public function delRow($table, $id) {
    	$result = $this->db->delete($table, array('id' => $id));
        if ($result == 1) return "删除成功";
        else return "删除失败";
    }
    
    public function replaceRow($table, $id, $array) {
        $result = array();
        if ($table == "unit") {
            if ("" == $array[0]) {
                $result["info"] = "请输入值";
                $result["id"] = "";
                return json_encode($result);
            }
            $data = array("unit" => $array[0]);
        } else if ($table == "doctor") {
            if ("" == $array[0]) {
                $result["info"] = "请输入值";
                $result["id"] = "";
                return json_encode($result);
            }
            $data = array("name" => $array[0]);
        }else if ($table == "medicine") {
            if ("" == $array[0] || "" == $array[1] || "" == $array[2] || "" == $array[3] || "" == $array[4] || "" == $array[5]) {
                $result["info"] = "请输入值";
                $result["id"] = "";
                return json_encode($result);
            }
            $data = array("id" => $array[0],"code" => $array[1],"name" => $array[2],"unit" => $array[3],"contain" => $array[4],"basicUnit" => $array[5],"countPerTime" => $array[6],"countPerDay" => $array[7], "days" => $array[8], "remark" => $array[9]);
        	$result["id"] = $array[0];
        } else if ($table == "patient") {
            if ("" == $array[0] || "" == $array[1] || "" == $array[2] ||"" == $array[3] || "" == $array[4] || "" == $array[5] || "" == $array[6]) {
                $result["info"] = "请输入值";
                $result["id"] = "";
                return json_encode($result);
            }
            $data = array("number" => $array[0],"realname" => $array[1],"gender" => $array[2],"age" => $array[3],"phone" => $array[4],"address" => $array[5],"date" => $array[6],"diagnosis" => $array[7]);    
        } else if ($table == "diagnosis") {
            if ("" == $array[0]) {
                $result["info"] = "请输入值";
                $result["id"] = "";
                return json_encode($result);
            }
            $data = array("name" => $array[0]);    
        } else{
        	$cols = $this->getHeader($table);
            $i = 0;
            foreach($cols as $col) {
                if (($col == "时间" || $col == "date") && $array[$i] == "") {
                    $i++;
                    continue;
                }
            	$data[$col] = $array[$i];
                $i++;
            }
        }
        if ("undefined" != $id && "" != $id && !array_key_exists("id", $data)) {
            $this->db->where('id', $id);
            $return = $this->db->update($table, $data);
        } else {
        	$return = $this->db->insert($table, $data);
        }
        if ($return == 1) {
            $result["info"] = "修改成功";
            if (!array_key_exists("id", $result)) {
            	$sql = "select id from `$table` order by id desc limit 1";
                $result["id"] = $this->getSingleResult($sql,"id");
            }
        }else {
            $result["info"] = "修改失败";
            $result["id"] = "";
        }
        
        return json_encode($result);
            
    }
    
    public function getLookUrl($table) {
    	if ($table == "patient")
            return site_url()."/mOut/index";
        else if ($table == "diagnosis")
            return site_url()."/common/diagnosis";
        else
            return "";
    }

    public function getNote($type, $id) {
        $sql = "select content from `note` where type='$type' and typeId = '$id'";
        return $this->getSingleResult($sql, "content");
    }

    public function updateNote($type, $id, $content) {
        $data = array(
            'type' => $type,
            'typeId'  => $id,
            'content'  => $content
        );
        $this->db->replace('note', $data);
    }

    public function search($table, $colIndex, $value) {
        $sql = "SHOW COLUMNS FROM `$table`";
        $result = $this->getAllResultArray($sql);
        $colName = $result[$colIndex]["Field"];
        $sql = "select $colName from `$table` where $colName like '$value"."%'";
        // return $this->getAllResultArray($sql);
        return $this->getRows($table, "$colName like '$value"."%'", 100, 0);
    }
}