<?php
class Mapping extends CI_Controller{
    public function check_existing(){
        $key = $this->input->post("key");
        $where = array(
            "mapping_key" => $key
        );
        $field = array(
            "mapping_key"
        );
        $result = selectRow("tbl_result_type_mapping",$where,$field);
        $result_array = $result->result_array();
        echo json_encode($result_array);
    }
}
?>