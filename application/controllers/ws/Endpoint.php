<?php
class Endpoint extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function get_result(){
        $headers = getallheaders();
        $where = array(
            "token" => $headers["client-token"],
            "status_aktif_token" => 1
        );
        $field = array(
            "token"
        );
        $result = selectRow("tbl_token",$where,$field);
        if($result->num_rows() > 0){
            $dataset_list = strtolower($this->input->post("dataset_list"));
            
            if($dataset_list != ""){
                $result_list = json_decode($dataset_list,true);
                $widget = array();
                $chart = array();
                $table = array();
                $chart_count = 0;
                $widget_count = 0;
                $table_count = 0;

                for($a = 0; $a<count($result_list); $a++){ //nyariin tiap intent, result typenya apa
                    $where = array(
                        //eval_key (evaluation key) supaya lebih general ga terpaku pada 1 hal saja. Jadi untuk kedepannya bisa intent, bisa apapun.
                        "mapping_key" => $result_list[$a]["dataset_name"]
                    );
                    $field = array(
                        "result_type"
                    );
                    $result = selectRow("tbl_result_type_mapping",$where,$field)->result_array(); //ganti yang di db, bukan yang ini
                    if(count($result) > 0){
                        $result_list[$a]["result_type"] = $result[0]["result_type"];
                        switch(strtolower($result_list[$a]["result_type"])){
                            case "bar chart":
                            $chart["data"][$chart_count]["value"] = $result_list[$a]["value"]; 
                            $chart["data"][$chart_count]["title"] = $result_list[$a]["dataset_desc"]; 
                            $chart_count++;
                            break;
                            case "widget":
                            $widget["data"][$widget_count]["value"] = $result_list[$a]["value"]; 
                            $widget["data"][$widget_count]["title"] = $result_list[$a]["dataset_desc"]; 
                            $widget_count++;
                            break;
                            case "table":
                            $table["data"][$table_count]["value"] = $result_list[$a]["value"]; 
                            $table["data"][$table_count]["title"] = $result_list[$a]["dataset_desc"]; 
                            $table_count++;
                            break;
                        }
                    }
                }
                $string = "";
                $string .= $this->load->view("req/head","",TRUE);
                $string .= $this->load->view("req/head-close","",TRUE);
                $string .= $this->load->view("req/body-open","",TRUE);
                //$string .= $this->load->view("req/top-navbar","",TRUE);
                //$string .= $this->load->view("req/navbar","",TRUE);
                $string .= $this->load->view("req/content-open","",TRUE);
                $string .= $this->load->view("req/script","",TRUE);
                $string .= $this->load->view("plugin/chart-js/chart-js-js","",TRUE);
                if($widget_count > 0){
                    $string .= $this->load->view("result_template/widget",$widget,TRUE); 
                }
                if($chart_count > 0){
                    $string .= $this->load->view("result_template/chart",$chart,TRUE); 
                }
                if($table_count > 0){
                    $string .= $this->load->view("result_template/table",$table,TRUE); 
                }
                $string .= $this->load->view("req/content-close","",TRUE);
                $string .= $this->load->view("req/body-close","",TRUE);
                $string .= $this->load->view("req/html-close","",TRUE);
                //echo htmlentities($string);
                $respond = array(
                    "status" => "success",
                    "msg" => "Dashboard is successfully made",
                    "result_page" => htmlentities($string)
                );
            }
            else{
                $respond = array(
                    "error" => "true",
                    "status" => "error",
                    "msg" => "Body params not found",
                    "result_page" => "-"
                ); 
            }
        }
        else{
            $respond = array(
                "error" => "true",
                "status" => "error",
                "msg" => "Token is not recognized",
                "result_page" => "-"
            ); 
        }
        header("Content-type:application/json");
        echo json_encode($respond);
    }
    public function get_active_result_type_list(){
        $headers = getallheaders();
        $where = array(
            "token" => $headers["client-token"],
            "status_aktif_token" => 1
        );
        $field = array(
            "token"
        );
        $result = selectRow("tbl_token",$where,$field);
        if($result->num_rows() > 0){
            $where = array(
                "status_aktif_result_type" => 1
            );
            $field = array(
                "result_type"
            );
            $result = selectRow("tbl_result_type",$where,$field);
            if($result->num_rows() > 0){
                $data = array(
                    "status" => "SUCCESS",
                    "msg" => "Result Types are found",
                    "data" => $result->result_array()
                );
            }
            else{
                $data = array(
                    "error" => "true",
                    "status" => "ERROR",
                    "msg" => "Result Types are not found"
                );
            }
        }
        else{
            $data = array(
                "error" => "true",
                "status" => "ERROR",
                "msg" => "Token is not recognized"
            );
        }
        header("content-type:application/json");
        echo json_encode($data);
    }
}
?>