<?php
/**
 * Class ini bertujuan untuk standarisasi interaksi dengan nlp adapter.
 */
class Qb_adapter{
    private $uri;
    private $token;
    private $log_id;
    private $id_user;
    protected $CI;

    public function __construct($config){
        $this->CI =& get_instance();
        $this->CI->load->helper("standardquery_helper");
        $this->CI->load->library("Curl");
        $where = array(
            "module_connetion_category" => "query_builder_adapter",
            "status_aktif_module_connection" =>  1
        );
        $field = array(
            "module_connection_token","module_connection_uri","id_submit_module_connection"
        );
        $result = selectRow("tbl_module_connection",$where,$field);
        $result_array = $result->result_array();
        $this->id_user = $config["id_user"];
        $this->uri = $result_array[0]["module_connection_uri"];
        $this->token = $result_array[0]["module_connection_token"];
        $this->log_id = $result_array[0]["id_submit_module_connection"];
    }
    private function get_log($category){
        $where = array(
            "module_log_id" => $this->log_id,
            "category_loaded" => $category,
            "connection_status" => "success"
        );
        $field = array(
            "tgl_module_connetion_log"
        );
        $result = selectRow("tbl_module_connection_log",$where,$field);
        $result_array = $result->result_array();

        if($result->num_rows() > 0){
            $last_log_time = $result_array[0]["tgl_module_connetion_log"];
        }
        else{
            $last_log_time = '0000-00-00 00:00:00';
        }
        return $last_log_time;
    }
    private function log_request($status,$msg,$log_category){
        $data = array(
            "module_log_id" => $this->log_id,
            "connection_status"  => strtoupper($status),
            "connection_msg" => strtoupper($msg),
            "tgl_module_connetion_log" => date("Y-m-d H:i:s"),
            "category_loaded" => strtoupper($log_category)
        );
        return insertRow("tbl_module_connection_log",$data);
    }
    private function update_repository($result,$id_log){
        for($a =0; $a<count($result); $a++){
            $data = array(
                "id_origin_entity_group" => $result[$a]["id_entity_combination"],
                "entity_group_component" => $result[$a]["combination_detail"],
                "data_origin" => $result[$a]["data_origin"],
                "id_log" => $id_log,
                "status_aktif_entity_group" => 1 
            );
            insertRow("tbl_entity_group",$data);
        }
    }
    public function get_entity_combination(){
        $category = "entity_combination";
        
        $last_log = $this->get_log($category);

        $url = $this->uri."endpoint/get_entity_combination/".rawurlencode($last_log);
        $header = array(
            "client-token:".$this->token
        );
        if($url == ""){
            return false;
        }
        $response = $this->CI->curl->get($url,$header);
        if($response["status"] == "success"){
            $this->update_repository($response["result"],$this->log_id,$category);
        }
        $this->log_request($response["status"],$response["msg"],$category);
    }
}