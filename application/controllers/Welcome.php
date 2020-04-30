<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
		$this->check_root_user();
		$this->login();
	}
	public function check_root_user(){
		$this->load->model("m_user");
		$result = $this->m_user->list();
		if(!$result->num_rows() > 0){
			$this->m_user->set_insert("Admin","admin","admin@example.com","ACTIVE","0");
			$this->m_user->insert();
			$msg = "Root User Created. Login with email:admin@example.com password:admin";
			$this->session->set_flashdata("status_login","success");
			$this->session->set_flashdata("msg_login",$msg);
		}
	}
	public function login(){
		$userdata = array(
			"nama_user",
			"id_user",
			"email",
		);
		$this->session->unset_userdata($userdata);
		$this->page_generator->req();
		$this->load->view("plugin/fontawesome/fontawesome-css");
		$this->page_generator->head_close();
		$this->page_generator->content_open();
		$this->load->view("login/v_content_login");
		$this->page_generator->close();
		$this->load->view("req/script");
	}
	public function auth(){
		$config = array(
			array(
				"field" => "email_user",
				"label" => "Email",
				"rules" => "required"
			),
			array(
				"field" => "password_user",
				"label" => "password",
				"rules" => "required"
			)
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run()){
			$email_user = $this->input->post("email_user");
			$password_user = $this->input->post("password_user");
			$this->load->model("m_user");
			$this->m_user->set_login($email_user,$password_user);
			$data = $this->m_user->login();
			if($data){
				$userdata = array(
					"id_user" => $data["id"],
					"nama_user" => $data["name"],
					"email" => $data["email"],
				);
				$this->session->set_userdata($userdata);
				$msg = "User Authenticated";
				$this->session->set_flashdata("status_login","success");
				$this->session->set_flashdata("msg_login",$msg);
				redirect("welcome/dashboard");
			}
			else{
				$msg = "Combination Not Found";
				$this->session->set_flashdata("status_login","danger");
				$this->session->set_flashdata("msg_login",$msg);
				redirect("welcome");
			}
		}	
		else{
			$msg = validation_errors();
			$this->session->set_flashdata("status_login","danger");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}	
	}
	public function dashboard(){	
		$this->check_session();
		$this->page_generator->req();
		$this->page_generator->head_close();
		$this->page_generator->navbar();
		$this->page_generator->content_open();
		$this->load->view("welcome_message");
		$this->page_generator->close();
	}
	public function logout(){
		redirect("welcome");
	}
	private function check_session(){
		if($this->session->id_user == ""){
			$msg = "Session Expired";	
			$this->session->set_flashdata("status_login","danger");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}
	}
	public function change_password(){
		$config = array(
			array(
				"field" => "password",
				"label" => "Password",
				"rules" => "required"
			)
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run()){
			$where = array(
				"id_submit_user" => $this->session->id_user
			);
			$data = array(
				"password_user" => md5($this->input->post("password"))
			);
			updateRow("tbl_user",$data,$where);
			$msg = "Password updated. Session Expired";
			$this->session->set_flashdata("status_login","danger");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}
		else{
			$msg = validation_errors();
			$this->session->set_flashdata("status_login","danger");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome/dashboard");
		}
	}
}
