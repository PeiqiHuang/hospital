<?php 
header("Content-type: text/html; charset=utf-8");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {
    
    public function entrance(){
    	$this->load->view('entrance.php');
    }

    public function test(){
	   $this->load->library('pagination');

       $config['base_url'] = base_url()."/common/table";
       $config['total_rows'] = 200;
       $config['per_page'] = 20;

       $this->pagination->initialize($config);

       echo $this->pagination->create_links();
    }

    public function table($table="", $editable="false", $offset=0){
        // 分页
       $this->load->library('pagination');
       $config['base_url'] = site_url()."/common/table/".$table."/".$editable;
       $config['total_rows'] = $this->common_model->getCount($table);
       $config['per_page'] = 8;
       $config['num_links']=20;
       $config['uri_segment'] = 5;  
       $config['first_link'] = '首页'; // 第一页显示  
       $config['last_link'] = '末页'; // 最后一页显示  
       $config['next_link'] = '下一页 >'; // 下一页显示  
       $config['prev_link'] = '< 上一页'; // 上一页显示  
       // $config['cur_tag_open'] = "<span style='text-decoration:underline;'>"; // 当前页开始样式  
       // $config['cur_tag_close'] = '</span>';
       $this->pagination->initialize($config);

        $table = urldecode($table);
        $where=$this->input->post('where');
        $data["headerInfo"] = json_encode($this->common_model->getHeader($table));
        $data["rowsInfo"] = json_encode($this->common_model->getRows($table,$where,$config['per_page'],$offset));
        $data["editColumnInfo"] = json_encode($this->common_model->getEditColumn($table));
        $data["editable"]=$editable;
        $data["title"]=$this->common_model->getTableTitle($table);
        $data["table"]=$table;
        $data["offset"]=$offset + 1;
        $data["lookUrl"]=$this->common_model->getLookUrl($table);
        // echo ($data["offset"]);return;

        $this->load->view('common.php', $data);
  }
    
    public function delRow($table, $id) {
        $table = urldecode($table);
    	echo $this->common_model->delRow($table, $id);
    }
    
    public function addRow() {
        $table=$this->input->post('table');
        //$id=$this->input->post('id');
        $postArray = $this->input->post('data');
		$array = json_decode($postArray,TRUE);
        echo $this->common_model->addRow($table, $array);
    }
    
    public function replaceRow() {
        $table=$this->input->post('table');
        $id=$this->input->post('id');
        $postArray = $this->input->post('data');
		    $array = json_decode($postArray,TRUE);
        echo $this->common_model->replaceRow($table, $id, $array);
    }    

    public function note($type, $id, $header) {
        $data["type"]=$type;
        $data["id"]=$id;
        $data["header"]=$header;
        $this->load->view('note.php', $data);
    }

    public function getNote($type, $id) {
        echo $this->common_model->getNote($type, $id);
    }

    public function updateNote() {
        $type = $this->input->post('type');
        $id = $this->input->post('typeId');
        $content = $this->input->post('content');
        echo $this->common_model->updateNote($type, $id, $content);
    }    

    public function diagnosis($id) {
        $name = $this->medicine_model->getDiagnosisById($id);
        $this->note("diagnosis", $id, $name);
    }

    public function search() {
      $table = $this->input->post('table');
      $colIndex = $this->input->post('colIndex');
      $value = $this->input->post('value');
      echo json_encode($this->common_model->search($table, $colIndex, $value));
    }
}