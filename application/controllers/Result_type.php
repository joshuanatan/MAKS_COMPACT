<?php
date_default_timezone_set("Asia/Bangkok");
class Result_type extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library("Page_generator");
    }   
    public function index(){
        $this->page_generator->req();
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();

        $this->load->model("m_result_type");
        $data["col"] = $this->m_result_type->columns();
        
        $this->load->view("result_type/v_result_type",$data);
        $this->page_generator->close();

    }
    public function recycle_bin(){
        $where = array(
            "status_aktif_result_type" => 2
        );
        $field = array(
            "result_type","status_aktif_result_type","tgl_result_type_last_modified"
        );
        $result = selectRow("tbl_result_type",$where,$field);
        $data["result_type"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("result_type/v_result_type_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");

    }
    public function activate($result_type){
        $where = array(
            "result_type" => rawurldecode($result_type)
        );
        $data = array(
            "status_aktif_result_type" => 1,
            "id_user_result_type_last_modified" => $this->session->id_user,
            "tgl_result_type_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type",$data,$where);
        $msg = "Data is successfully activated";
        $this->session->set_flashdata("status_result","success");
        $this->session->set_flashdata("msg_result",$msg);
        redirect("result_type");
    } 
    public function delete($result_type){
        $where = array(
            "result_type" => rawurldecode($result_type)
        );
        $data = array(
            "status_aktif_result_type" => 2,
            "id_user_result_type_last_modified" => $this->session->id_user,
            "tgl_result_type_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_result","error");
        $this->session->set_flashdata("msg_result",$msg);
        redirect("result_type");
    } 
    public function deactive($result_type){
        $where = array(
            "result_type" => rawurldecode($result_type)
        );
        $data = array(
            "status_aktif_result_type" => 0,
            "id_user_result_type_last_modified" => $this->session->id_user,
            "tgl_result_type_last_modified" => date("Y-m-d H:i:s")
        );
        updateRow("tbl_result_type",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_result","error");
        $this->session->set_flashdata("msg_result",$msg);
        redirect("result_type");
    } 
    public function insert(){
        $config = array(
            array(
                "field" => "result_type",
                "label" => "Result Type",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $where  = array(
                "result_type" => strtoupper($this->input->post("result_type"))
            );
            $field = array(
                "result_type"
            );
            $result = selectRow("tbl_result_type",$where,$field);
            if($result->num_rows() > 0){
                $this->session->set_flashdata("status_result","error");
                $this->session->set_flashdata("msg_result","Data Exists");
            }
            else{
                $data = array(
                    "result_type" => strtoupper($this->input->post("result_type")),
                    "status_aktif_result_type" => 1,
                    "id_user_result_type_last_modified" => $this->session->id_user,
                    "tgl_result_type_last_modified" => date("Y-m-d H:i:s")
                );
                insertRow("tbl_result_type",$data);
                $msg = "Result is successfully added to database";
                $this->session->set_flashdata("status_result","success");
                $this->session->set_flashdata("msg_result",$msg); 
            }  
        }
        else{
            $msg = validation_errors();
            $this->session->set_flashdata("status_result","error");
            $this->session->set_flashdata("msg_result",$msg);
        }
        redirect("result_type");
    }
    public function update(){
        $config = array(
            array(
                "field" => "result_type_control",
                "label" => "Result Control",
                "rules" => "required"
            ),
            array(
                "field" => "result_type",
                "label" => "Result Type",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $where  = array(
                "result_type" => strtoupper($this->input->post("result_type"))
            );
            $field = array(
                "result_type"
            );
            $result = selectRow("tbl_result_type",$where,$field);
            if($result->num_rows() > 0){
                $this->session->set_flashdata("status_result","error");
                $this->session->set_flashdata("msg_result","Data Exists");
            }
            else{
                $where = array(
                    "result_type" => $this->input->post("result_type_control")
                );
                $data = array(
                    "result_type" => strtoupper($this->input->post("result_type")),
                    "id_user_result_type_last_modified" => $this->session->id_user,
                    "tgl_result_type_last_modified" => date("Y-m-d H:i:s")
                );
                updateRow("tbl_result_type",$data,$where);
                $msg = "Data is successfully updated to database";
                $this->session->set_flashdata("status_result","success");
                $this->session->set_flashdata("msg_result",$msg);
            }
        }
        else{
            $msg = validation_errors();
            $this->session->set_flashdata("status_result","error");
            $this->session->set_flashdata("msg_result",$msg);
        }
        redirect("result_type");
    }
}
?>