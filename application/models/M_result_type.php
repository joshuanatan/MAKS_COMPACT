<?php
date_default_timezone_set("Asia/Jakarta");
class M_result_type extends CI_Model{
    private $tbl_name = "mstr_result_type";
    private $columns = array();
    private $id_submit_result_type;
    private $result_type;
    private $status_result_type;
    private $id_last_modified;
    private $result_type_last_modified;

    public function __construct(){
        parent::__construct();
        $this->result_type_last_modified = date("Y-m-d H:i:s");
        $this->columns = array(
            array(
                "col_name" => "result_type",
                "col_disp" => "Result Type",
                "order_by" => true
            ),
            array(
                "col_name" => "status_result_type",
                "col_disp" => "Status",
                "order_by" => false
            ),
            array(
                "col_name" => "result_type_last_modified",
                "col_disp" => "Last Modified",
                "order_by" => false
            ),
        );
    }
    public function columns(){
        return $this->columns;
    }
    public function install(){
        $sql = "
        DROP TABLE IF EXISTS mstr_result_type;
        CREATE TABLE mstr_result_type (
            id_submit_result_type INT PRIMARY KEY AUTO_INCREMENT,
            result_type varchar(400),
            status_result_type varchar(10),
            id_last_modified int(11),
            result_type_last_modified datetime
        );
        DROP TABLE IF EXISTS mstr_result_type_log;
        CREATE TABLE mstr_result_type_log(
            id_submit_result_type_log INT PRIMARY KEY AUTO_INCREMENT,
            executed_action VARCHAR(30),
            id_submit_result_type INT,
            result_type varchar(400),
            status_result_type varchar(10),
            id_last_modified int(11),
            result_type_last_modified datetime
        );
        DROP TRIGGER IF EXISTS TRG_BEFORE_UPDATE;
        DELIMITER $$
        CREATE TRIGGER TRG_BEFORE_UPDATE
        BEFORE UPDATE ON mstr_result_type
        FOR EACH ROW
        BEGIN 
            INSERT INTO mstr_result_type_log(executed_action,id_submit_result_type,result_type,status_result_type,id_last_modified,result_type_last_modified) values ('BEFORE UPDATE',OLD.id_submit_result_type,OLD.result_type,OLD.status_result_type,OLD.id_last_modified,OLD.result_type_last_modified);
        END$$
        DELIMITER ;

        DROP TRIGGER IF EXISTS TRG_BEFORE_DELETE;
        DELIMITER $$
        CREATE TRIGGER TRG_BEFORE_DELETE
        BEFORE DELETE ON mstr_result_type
        FOR EACH ROW
        BEGIN 
            INSERT INTO mstr_result_type_log(executed_action,id_submit_result_type,result_type,status_result_type,id_last_modified,result_type_last_modified) values ('BEFORE DELETE',OLD.id_submit_result_type,OLD.result_type,OLD.status_result_type,OLD.id_last_modified,OLD.result_type_last_modified);
        END$$
        DELIMITER ;";
        executeQuery($sql);
    }
    public function content($page = 1,$order_by = 0, $order_direction = "ASC", $search_key = "",$data_per_page = ""){
        $order_by = $this->columns[$order_by]["col_name"];
        $search_query = "";
        if($search_key != ""){
            $search_query .= "AND
            ( 
                id_submit_result_type LIKE '%".$search_key."%' OR
                result_type LIKE '%".$search_key."%' OR
                status_result_type LIKE '%".$search_key."%' OR
                id_last_modified LIKE '%".$search_key."%' OR
                result_type_last_modified LIKE '%".$search_key."%'
            )";
        }
        $query = "
        SELECT id_submit_result_type,result_type,status_result_type,id_last_modified,result_type_last_modified
        FROM ".$this->tbl_name." 
        WHERE (status_result_type = ? OR status_result_type = ?)".$search_query."  
        ORDER BY ".$order_by." ".$order_direction." 
        LIMIT 20 OFFSET ".($page-1)*$data_per_page;
        $args = array(
            "ACTIVE","NOT ACTIVE"
        );
        $result["data"] = executeQuery($query,$args);
        
        $query = "
        SELECT id_submit_result_type
        FROM ".$this->tbl_name." 
        WHERE (status_result_type = ? OR status_result_type = ?)".$search_query."  
        ORDER BY ".$order_by." ".$order_direction;
        $result["total_data"] = executeQuery($query,$args)->num_rows();
        return $result;
    }
    public function list(){
        $where = array(
            "status_formula_attr" => "ACTIVE"
        );
        $field = array(
            "result_type","status_result_type","result_type_last_modified"
        );
        $result = selectRow($this->tbl_name,$where,$field);
        return $result;
    }
    public function recycle_bin(){
        $where = array(
            "status_formula_attr" => "DELETED"
        );
        $field = array(
            "result_type","status_result_type","result_type_last_modified"
        );
        $result = selectRow($this->tbl_name,$where,$field);
        return $result;
    }
    public function insert(){
        if($this->check_insert_variable()){
            $data = array(
                "result_type" => $this->result_type,
                "status_result_type" => $this->status_result_type,
                "id_last_modified" => $this->id_last_modified,
                "result_type_last_modified" => $this->result_type_last_modified,
            );
            return insertRow($this->tbl_name,$data);
        }
        else{
            return false;
        }
    }
    public function update(){
        if($this->check_update_variable()){
            $where = array(
                "id_submit_result_type" => $this->id_submit_result_type
            );
            $data = array(
                "result_type" => $this->result_type,
                "id_last_modified" => $this->id_last_modified,
                "result_type_last_modified" => $this->result_type_last_modified,
            );
            updateRow($this->tbl_name,$data,$where);
            return true;
        }
        else{
            return false;
        }
    }
    public function delete(){
        if($this->check_delete_variable()){
            $where = array(
                "id_submit_result_type" => $this->id_submit_result_type
            );
            $data = array(
                "status_result_type" => "DELETED",
                "id_last_modified" => $this->id_last_modified,
                "result_type_last_modified" => $this->result_type_last_modified,
            );
            updateRow($this->tbl_name,$data,$where);
            return true;
        }
        else{
            return false;
        }
    }
    public function deactive(){
        if($this->check_deactive_variable()){
            $where = array(
                "id_submit_result_type" => $this->id_submit_result_type
            );
            $data = array(
                "status_result_type" => "NOT ACTIVE",
                "id_last_modified" => $this->id_last_modified,
                "result_type_last_modified" => $this->result_type_last_modified,
            );
            updateRow($this->tbl_name,$data,$where);
            return true;
        }
        else{
            return false;
        }
    }
    public function reactive(){
        if($this->check_reactive_variable()){
            $where = array(
                "id_submit_result_type" => $this->id_submit_result_type
            );
            $data = array(
                "status_result_type" => "ACTIVE",
                "id_last_modified" => $this->id_last_modified,
                "result_type_last_modified" => $this->result_type_last_modified,
            );
            updateRow($this->tbl_name,$data,$where);
            return true;
        }
        else{
            return false;
        }
    }
    public function check_insert_variable(){
        if($this->result_type != "" && $this->status_result_type != "" && $this->id_last_modified != "" && $this->result_type_last_modified != ""){
            return true;
        }
        else{
            return false;
        }
    }
    public function check_update_variable(){
        if($this->id_submit_result_type != "" && $this->result_type != "" && $this->id_last_modified != "" && $this->result_type_last_modified != ""){
            return true;
        }   
        else{
            return false;
        }
    }
    public function check_delete_variable(){
        if($this->id_submit_result_type != "" && $this->id_last_modified != "" && $this->result_type_last_modified != ""){
            return true;
        }
        else{
            return false;
        }
    }
    public function set_insert($result_type,$status_result_type,$id_last_modified){
        if(!$this->set_result_type($result_type)){
            return false;
        }
        if(!$this->set_status_result_type($status_result_type)){
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){
            return false;
        }
        return true;
    }
    public function set_update($id_submit_result_type,$result_type,$id_last_modified){
        if(!$this->set_id_submit_result_type($id_submit_result_type)){
            return false;
        }
        if(!$this->set_result_type($result_type)){
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){
            return false;
        }
        return true;
    }
    public function set_delete($id_submit_result_type,$id_last_modified){
        if(!$this->set_id_submit_result_type($id_submit_result_type)){
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){
            return false;
        }
        return true;
    }
    public function set_id_submit_result_type($id_submit_result_type){
        if($id_submit_result_type != ""){
            $this->id_submit_result_type = $id_submit_result_type;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_result_type($result_type){
        if($result_type != ""){
            $this->result_type = $result_type;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_status_result_type($status_result_type){
        if($status_result_type != ""){
            $this->status_result_type = $status_result_type;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_id_last_modified($id_last_modified){
        if($id_last_modified != ""){
            $this->id_last_modified = $id_last_modified;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_result_type_last_modified($result_type_last_modified){
        if($result_type_last_modified != ""){
            $this->result_type_last_modified = $result_type_last_modified;
            return true;
        }
        else{
            return false;
        }
    }
    public function get_id_submit_result_type(){
        return $this->id_submit_result_type;
    }
    public function get_result_type(){
        return $this->result_type;
    }
    public function get_status_result_type(){
        return $this->status_result_type;
    }
    public function get_id_last_modified(){
        return $this->id_last_modified;
    }
    public function get_result_type_last_modified(){
        return $this->result_type_last_modified;
    }    
}
?>