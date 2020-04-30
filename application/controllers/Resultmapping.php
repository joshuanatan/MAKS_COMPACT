<?php
date_default_timezone_set("Asia/Bangkok");
class Resultmapping extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function recycle_bin(){
        $where = array(
            "status_aktif_result_type_mapping" => 2,
            "result_type" => null
        );
        $field = array(
            "id_submit_result_type_mapping","mapping_key","result_type","status_aktif_result_type_mapping"
        );
        $result = selectRow("tbl_result_type_mapping",$where,$field);
        $data["result_mapping"] = $result->result_array();

        $where = array(
            "status_aktif_result_type" => 1
        );
        $field = array(
            "result_type"
        );
        $result = selectRow("tbl_result_type",$where,$field);
        $data["result_type"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("result_mapping/v_resultmapping_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("result_mapping/v_resultmapping_js");
    }
    public function update(){
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $a){
                $where = array(
                    "id_submit_result_type_mapping" => $this->input->post("id_submit_result_type_mapping".$a)
                );
                $data = array(
                    "result_type" => $this->input->post("result_type".$a)
                );
                updateRow("tbl_result_type_mapping",$data,$where);
            }
        }
        $msg = "Data is successfully updated to database";
        $this->session->set_flashdata("status_mapping","success");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");
    }
    public function activate($id_submit_result_type_mapping){
        $where = array(
            "id_submit_result_type_mapping" => $id_submit_result_type_mapping
        );
        $data = array(
            "status_aktif_result_type_mapping" => 1,
            "id_user_result_type_mapping_last_modified"=> $this->session->id_user,
            "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type_mapping",$data,$where);
        $msg = "Data is successfully activated";
        $this->session->set_flashdata("status_mapping","success");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");

    } 
    public function delete($id_submit_result_type_mapping){
        $where = array(
            "id_submit_result_type_mapping" => $id_submit_result_type_mapping
        );
        $data = array(
            "status_aktif_result_type_mapping" => 2,
            "id_user_result_type_mapping_last_modified"=> $this->session->id_user,
            "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type_mapping",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_mapping","error");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");
    }
    public function deactive($id_submit_result_type_mapping){
        $where = array(
            "id_submit_result_type_mapping" => $id_submit_result_type_mapping
        );
        $data = array(
            "status_aktif_result_type_mapping" => 0,
            "id_user_result_type_mapping_last_modified"=> $this->session->id_user,
            "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type_mapping",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_mapping","error");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");
    }
    public function activate_mapped($id_submit_result_type_mapping){
        $where = array(
            "id_submit_result_type_mapping" => $id_submit_result_type_mapping
        );
        $data = array(
            "status_aktif_result_type_mapping" => 1,
            "id_user_result_type_mapping_last_modified"=> $this->session->id_user,
            "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type_mapping",$data,$where);
        $msg = "Data is successfully activated";
        $this->session->set_flashdata("status_mapping","success");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");

    } 
    public function delete_mapped($id_submit_result_type_mapping){
        $where = array(
            "id_submit_result_type_mapping" => $id_submit_result_type_mapping
        );
        $data = array(
            "status_aktif_result_type_mapping" => 2,
            "id_user_result_type_mapping_last_modified"=> $this->session->id_user,
            "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type_mapping",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_mapping","error");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");
    }
    public function deactive_mapped($id_submit_result_type_mapping){
        $where = array(
            "id_submit_result_type_mapping" => $id_submit_result_type_mapping
        );
        $data = array(
            "status_aktif_result_type_mapping" => 0,
            "id_user_result_type_mapping_last_modified"=> $this->session->id_user,
            "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type_mapping",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_mapping","error");
        $this->session->set_flashdata("msg_mapping",$msg);
        redirect("resultmapping");
    }
    public function insert_mapping(){
        $key = "";
        if(strtolower($this->input->post("key")) == "new_key"){
            $config = array(
                array(
                    "field" => "new_key",
                    "label" => "Request Mapping Key",
                    "rules" => "required"
                )
            );
            $this->form_validation->set_rules($config);
            if($this->form_validation->run()){
                $key = $this->input->post("new_key");
                $data = array(
                    "mapping_key" => $key,
                    "result_type" => $this->input->post("result_type"),
                    "status_aktif_result_type_mapping" => 1,
                    "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s"),
                    "id_user_result_type_mapping_last_modified" => $this->session->id_user
                );
                insertRow("tbl_result_type_mapping",$data);
                $msg = "Data is successfully added to database";
                $this->session->set_flashdata("status_mapping","success");
                $this->session->set_flashdata("msg_mapping",$msg);
            }
            else{
                $msg = validation_errors();
                $this->session->set_flashdata("status_mapping","error");
                $this->session->set_flashdata("msg_mapping",$msg);
                redirect("resultmapping");
            }
        }
        else{
            $key = $this->input->post("key");
            $where = array(
                "mapping_key" => $key,
            );
            $data = array(
                "result_type" => $this->input->post("result_type"),
                "tgl_result_type_mapping_last_modified" => date("Y-m-d H:i:s"),
                "id_user_result_type_mapping_last_modified" => $this->session->id_user
            );
            updateRow("tbl_result_type_mapping",$data,$where);
            $msg = "Data is successfully updated to database. Click 'Checked Mapped Intent' button to review";
            $this->session->set_flashdata("status_mapping","success");
            $this->session->set_flashdata("msg_mapping",$msg);
        }
        redirect("resultmapping");
    }
    public function index(){
        $where = array(
            "status_aktif_result_type_mapping <" => 2,
            "result_type !=" => null
        );
        $field = array(
            "id_submit_result_type_mapping","mapping_key","result_type","status_aktif_result_type_mapping","tgl_result_type_mapping_last_modified"
        );
        $result = selectRow("tbl_result_type_mapping",$where,$field);
        $data["result_mapping"] = $result->result_array();

        $where = array(
            "status_aktif_result_type" => 1
        );
        $field = array(
            "result_type"
        );
        $result = selectRow("tbl_result_type",$where,$field);
        $data["result_type"] = $result->result_array();
        
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("result_mapping/v_resultmapping_mapped",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("result_mapping/v_resultmapping_js");
    }
    public function mapped_result_recycle_bin(){
        $where = array(
            "result_type is not " => null,
            "status_aktif_result_type_mapping" => 2
        );
        $field = array(
            "id_submit_result_type_mapping","mapping_key","result_type","status_aktif_result_type_mapping","tgl_result_type_mapping_last_modified"
        );
        $result = selectRow("tbl_result_type_mapping",$where,$field);
        $data["result_list"] = $result->result_array();

        $where = array(
            "status_aktif_result_type" => 1
        );
        $field = array(
            "result_type"
        );
        $result = selectRow("tbl_result_type",$where,$field);
        $data["result_type"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("result_mapping/v_resultmapping_mapped_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("result_mapping/v_resultmapping_js");
    }
}
?>