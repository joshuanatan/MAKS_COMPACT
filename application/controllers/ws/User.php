<?php
date_default_timezone_set("Asia/Bangkok");
class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function content(){
        $respond["status"] = "SUCCESS";
        $respond["content"] = array();

        $order_by = $this->input->get("orderBy");
        $order_direction = $this->input->get("orderDirection");
        $page = $this->input->get("page");
        $search_key = $this->input->get("searchKey");
        $data_per_page = 20;
        
        $this->load->model("m_user");
        $result = $this->m_user->content($page,$order_by,$order_direction,$search_key,$data_per_page);

        if($result["data"]->num_rows() > 0){
            $result["data"] = $result["data"]->result_array();
            for($a = 0; $a<count($result["data"]); $a++){
                $respond["content"][$a]["id"] = $result["data"][$a]["id_submit_user"];
                $respond["content"][$a]["nama"] = $result["data"][$a]["nama_user"];
                $respond["content"][$a]["email"] = $result["data"][$a]["email_user"];
                $respond["content"][$a]["status"] = $result["data"][$a]["status_aktif_user"];
                $respond["content"][$a]["last_modified"] = $result["data"][$a]["user_last_modified"];
            }
        }
        else{
            $respond["status"] = "ERROR";
        }
        $respond["page"] = $this->pagination->generate_pagination_rules($page,$result["total_data"],$data_per_page);

        echo json_encode($respond);
    }
    public function insert(){
        $respond["status"] = "SUCCESS";
        $config = array(
            array(
                "field" => "nama_user",
                "label" => ucwords(str_replace("_"," ","nama_user")),
                "rules" => "required"
            ),
            array(
                "field" => "password_user",
                "label" => ucwords(str_replace("_"," ","password_user")),
                "rules" => "required"
            ),
            array(
                "field" => "email_user",
                "label" => ucwords(str_replace("_"," ","email_user")),
                "rules" => "required|is_unique[mstr_user.email_user]|valid_email"
            ),
        );
        $this->form_validation->set_rules($config);    
        if($this->form_validation->run()){
            $this->load->model("m_user");
            $nama_user = $this->input->post("nama_user");
            $password_user = $this->input->post("password_user");
            $status_aktif_user = "ACTIVE";
            $id_last_modified = $this->session->id_user;
            $email_user = $this->input->post("email_user");
            if($this->m_user->set_insert($nama_user,$password_user,$email_user,$status_aktif_user,$id_last_modified)){
                if($this->m_user->insert()){
                    $respond["msg"] = "Data is recorded to database";
                }
                else{
                    $respond["status"] = "ERROR";
                    $respond["msg"] = "Insert Function Error";
                }
            }
            else{
                $respond["status"] = "ERROR";
                $respond["msg"] = "Setter Function Error";
            }
        }
        else{
            $respond["status"] = "ERROR";
            $respond["msg"] = validation_errors();
        }
        echo json_encode($respond);
    }
    public function update(){
        $config = array(
            array(
                "field" => "id_submit_user",
                "label" => ucwords(str_replace("_"," ","id_submit_user")),
                "rules" => "required"
            ),
            array(
                "field" => "nama_user",
                "label" => ucwords(str_replace("_"," ","nama_user")),
                "rules" => "required"
            ),
            array(
                "field" => "email_user",
                "label" => ucwords(str_replace("_"," ","email_user")),
                "rules" => "required|valid_email"
            ),
        );
        $this->form_validation->set_rules($config);    
        if($this->form_validation->run()){
            $id_submit_user = $this->input->post("id_submit_user");
            $nama_user = $this->input->post("nama_user");
            $email_user = $this->input->post("email_user");
            $id_last_modified = $this->session->id_user;
            $this->load->model("m_user");
            if($this->m_user->set_update($id_submit_user,$nama_user,$email_user,$id_last_modified)){
                if($this->m_user->update()){
                    $respond["msg"] = "Data is updated to database";
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
    public function update_password(){
        $respond["status"] = "SUCCESS";
        $config = array(
            array(
                "field" => "id_submit_user",
                "label" => ucwords(str_replace("_"," ","id_submit_user")),
                "rules" => "required"
            ),
            array(
                "field" => "password_user",
                "label" => "Password User",
                "rules" => "required" 
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $id_submit_user = $this->input->post("id_submit_user");
            $password_user = $this->input->post("password_user");
            $id_last_modified = $this->session->id_user;
            $this->load->model("m_user");
            if($this->m_user->set_update_password($id_submit_user,$password_user,$id_last_modified)){
                if($this->m_user->update_password()){
                    $respond["msg"] = "Password is updated";
                }
                else{
                    $respond["status"] = "ERROR";
                    $respond["msg"] = "Update Password function error";
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
    public function delete($id_submit_user){
        $respond["status"] = "SUCCESS";
        if($id_submit_user != "" && is_numeric($id_submit_user)){
            $this->load->model("m_user");
            $id_last_modified = $this->session->id_user;
            if($this->m_user->set_delete($id_submit_user,$id_last_modified)){
                if($this->m_user->delete()){
                    $respond["msg"] = "Data is deleted";
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
            $respond["msg"] = "ID User Invalid";
        }
        echo json_encode($respond);
    }   
}
?>