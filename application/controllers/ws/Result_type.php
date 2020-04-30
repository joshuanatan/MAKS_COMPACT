<?php
class Result_type extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library("Page_generator");
    }   
    public function content(){
        $respond["status"] = "SUCCESS";
        $respond["content"] = array();

        $order_by = $this->input->get("orderBy");
        $order_direction = $this->input->get("orderDirection");
        $page = $this->input->get("page");
        $search_key = $this->input->get("searchKey");
        $data_per_page = 20;
        
        $this->load->model("m_result_type");
        $result = $this->m_result_type->content($page,$order_by,$order_direction,$search_key,$data_per_page);

        if($result["data"]->num_rows() > 0){
            $result["data"] = $result["data"]->result_array();
            for($a = 0; $a<count($result["data"]); $a++){
                $respond["content"][$a]["id"] = $result["data"][$a]["id_submit_result_type"];
                $respond["content"][$a]["result_type"] = $result["data"][$a]["result_type"];
                $respond["content"][$a]["status"] = $result["data"][$a]["status_result_type"];
                $respond["content"][$a]["last_modified"] = $result["data"][$a]["result_type_last_modified"];
            }
        }
        else{
            $respond["status"] = "ERROR";
        }
        $respond["page"] = $this->pagination->generate_pagination_rules($page,$result["total_data"],$data_per_page);

        echo json_encode($respond);
    }
    public function insert(){
        $response["status"] = "SUCCESS";
        $config = array(
            array(
                "field" => "result_type",
                "label" => "Result Type",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $result_type = strtoupper($this->input->post("result_type"));
            $id_last_modified = $this->session->id_user;

            $this->load->model("m_result_type");
            if($this->m_result_type->set_insert($result_type,"ACTIVE",$id_last_modified)){
                if($this->m_result_type->insert()){
                    $respond["msg"] = "Data is recorded to database";
                }
                else{
                    $respond["status"] = "ERROR";
                    $respond["msg"] = "Insert function error";
                }
            }
            else{
                $respond["status"] = "ERROR";
                $respond["msg"] = "Setter function error";
            }
        }
        else{
            $response["status"] = "ERROR";
            $response["msg"] = validation_errors();
        }
        echo json_encode($response);
    }
    public function update(){
        $respond["status"] = "SUCCESS";
        $config = array(
            array(
                "field" => "id_result_type",
                "label" => "ID Result Type",
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
            $id_result_type = $this->input->post("id_result_type");
            $result_type = strtoupper($this->input->post("result_type"));
            $id_last_modified = $this->session->id_user;
            $this->load->model("m_result_type");
            if($this->m_result_type->set_update($id_result_type,$result_type,$id_last_modified)){
                if($this->m_result_type->update()){
                    $respond["msg"] = "Data is updated";
                }
                else{
                    $respond["status"] = "ERROR";
                    $respond["msg"] = "Update function error";
                }
            }
            else{
                $respond["status"] = "ERROR";
                $respond["msg"] = "Setter function error";
            }
        }
        else{
            $respond["status"] = "ERROR";
            $respond["msg"] = validation_errors();
        }
        echo json_encode($respond);
    }
    public function delete($id){
        $respond["status"] = "SUCCESS";
        if($id != "" && is_numeric($id)){
            $id_last_modified = $this->session->id_user;
            $this->load->model("m_result_type");
            if($this->m_result_type->set_delete($id,$id_last_modified)){
                if($this->m_result_type->delete()){
                    $respond["msg"] = "Result type is removed from database";
                }
                else{
                    $respond["status"] = "ERROR";
                    $respond["msg"] = "Delete function error";
                }
            }
            else{
                $respond["status"] = "ERROR";
                $respond["msg"] = "Setter function error";
            }
        }
        else{
            $respond["status"] = "ERROR";
            $respond["msg"] = "Invalid ID";
        }
        echo json_encode($respond);
    } 
}
?>