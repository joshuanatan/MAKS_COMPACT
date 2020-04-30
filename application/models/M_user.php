<?php
date_default_timezone_set("Asia/Jakarta");
class M_user extends CI_Model{
    private $columns = array();
    private $tbl_name = "mstr_user";
    private $id_submit_user;
    private $nama_user;
    private $password_user;
    private $email_user;
    private $status_aktif_user;
    private $id_last_modified;
    private $user_last_modified;
    
    public function __construct(){
        parent::__construct();
        $this->columns = array(
            array(
                "col_name" => "nama_user",
                "col_disp" => "Name",
                "order_by" => true
            ),
            array(
                "col_name" => "email_user",
                "col_disp" => "User Email",
                "order_by" => false
            ),
            array(
                "col_name" => "status_aktif_user",
                "col_disp" => "User Status",
                "order_by" => false
            ),
            array(
                "col_name" => "user_last_modified",
                "col_disp" => "Last Modified",
                "order_by" => false
            ),
        );
        $this->user_last_modified = date("Y-m-d H:i:s");
    }
    public function install(){
        $sql = "
        DROP TABLE IF EXISTS mstr_user;
        CREATE TABLE mstr_user(
            id_submit_user INT PRIMARY KEY AUTO_INCREMENT,
            nama_user varchar(200),
            password_user varchar(300),
            email_user varchar(200),	
            status_aktif_user varchar(10),
            user_last_modified datetime,
            id_last_modified int(11)
        );
        DROP TABLE IF EXISTS mstr_user_log;
        CREATE TABLE mstr_user_log(
            id_submit_user_log INT PRIMARY KEY AUTO_INCREMENT,
            executed_function varchar(30),
            id_submit_user int,
            nama_user varchar(200),
            password_user varchar(300),
            email_user varchar(200),	
            status_aktif_user varchar(10),
            user_last_modified datetime,
            id_last_modified int(11)
        );
        DROP TRIGGER IF EXISTS TRG_BEFORE_UPDATE;
        DELIMITER $$
        CREATE TRIGGER TRG_BEFORE_UPDATE
        BEFORE UPDATE ON mstr_user 
        FOR EACH ROW
        BEGIN
            INSERT INTO mstr_user_log(executed_function,id_submit_user,nama_user,password_user,email_user,status_aktif_user,id_last_modified,user_last_modified) VALUES ('BEFORE UPDATE',OLD.id_submit_user,OLD.nama_user,OLD.password_user,OLD.email_user,OLD.status_aktif_user,OLD.id_last_modified,OLD.user_last_modified);
        END$$
        DELIMITER ;

        DROP TRIGGER IF EXISTS TRG_BEFORE_DELETE;
        DELIMITER $$
        CREATE TRIGGER TRG_BEFORE_DELETE
        BEFORE DELETE ON mstr_user 
        FOR EACH ROW
        BEGIN
            INSERT INTO mstr_user_log(executed_function,id_submit_user,nama_user,password_user,email_user,status_aktif_user,id_last_modified,user_last_modified) VALUES ('BEFORE DELETE',OLD.id_submit_user,OLD.nama_user,OLD.password_user,OLD.email_user,OLD.status_aktif_user,OLD.id_last_modified,OLD.user_last_modified);
        END$$
        DELIMITER ;
        ";
        executeSql($sql);
    }
    public function columns(){
        return $this->columns;
    }
    public function content($page = 1,$order_by = 0, $order_direction = "ASC", $search_key = "",$data_per_page = ""){
        $order_by = $this->columns[$order_by]["col_name"];
        $search_query = "";
        if($search_key != ""){
            $search_query .= "AND
            ( 
                id_submit_user LIKE '%".$search_key."%' OR
                nama_user LIKE '%".$search_key."%' OR
                email_user LIKE '%".$search_key."%' OR
                status_aktif_user LIKE '%".$search_key."%' OR
                id_last_modified LIKE '%".$search_key."%' OR
                user_last_modified LIKE '%".$search_key."%'
            )";
        }
        $query = "
        SELECT id_submit_user,nama_user,email_user,status_aktif_user,user_last_modified
        FROM ".$this->tbl_name." 
        WHERE (status_aktif_user = ? OR status_aktif_user = ? )".$search_query."  
        ORDER BY ".$order_by." ".$order_direction." 
        LIMIT 20 OFFSET ".($page-1)*$data_per_page;
        $args = array(
            "ACTIVE","NOT ACTIVE"
        );
        $result["data"] = executeQuery($query,$args);
        
        $query = "
        SELECT id_submit_user
        FROM ".$this->tbl_name." 
        WHERE (status_aktif_user = ? OR status_aktif_user = ? )".$search_query."  
        ORDER BY ".$order_by." ".$order_direction;
        $result["total_data"] = executeQuery($query,$args)->num_rows();
        return $result;
    }
    public function list(){
        $where = array(
            "status_aktif_user" => "ACTIVE"
        );
        $field = array(
            "id_submit_user","nama_user","email_user","status_aktif_user","user_last_modified"
        );
        $result = selectRow($this->tbl_name,$where,$field);
        return $result;
    }
    public function recycle_bin(){
        $where = array(
            "status_formula_attr" => "DELETED"
        );
        $field = array(
            "id_submit_user","nama_user","email_user","status_aktif_user","user_last_modified"
        );
        $result = selectRow($this->tbl_name,$where,$field);
        return $result;
    }
    public function insert(){
        if($this->check_insert()){
            $data = array(
                "nama_user" => $this->nama_user,
                "password_user" => password_hash($this->password_user,PASSWORD_DEFAULT),
                "email_user" => $this->email_user,
                "status_aktif_user" => $this->status_aktif_user,
                "id_last_modified" => $this->id_last_modified,
                "user_last_modified" => $this->user_last_modified
            );
            return insertRow($this->tbl_name,$data);
        }
        else{
            return false;
        }
    }
    public function update(){
        if($this->check_update()){
            $where = array(
                "id_submit_user != " => $this->id_submit_user,
                "email_user" => $this->email_user
            );
            if(!isExistsInTable($this->tbl_name,$where)){
                $where = array(
                    "id_submit_user" => $this->id_submit_user
                );
                $data = array(
                    "nama_user" => $this->nama_user,
                    "email_user" => $this->email_user,
                    "id_last_modified" => $this->id_last_modified,
                    "user_last_modified" => $this->user_last_modified
                );
                updateRow($this->tbl_name,$data,$where);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function update_password(){
        if($this->check_update_password()){
            $where = array(
                "id_submit_user" => $this->id_submit_user
            );
            $data = array(
                "password_user" => password_hash($this->password_user,PASSWORD_DEFAULT),
                "id_last_modified" => $this->id_last_modified,
                "user_last_modified" => $this->user_last_modified
            );
            updateRow($this->tbl_name,$data,$where);
            return true;
        }
        else{
            return false;
        }
    }
    public function delete(){
        if($this->check_delete()){
            $where = array(
                "id_submit_user" => $this->id_submit_user
            );
            $data = array(
                "status_aktif_user" => "DELETED",
                "id_last_modified" => $this->id_last_modified,
                "user_last_modified" => $this->user_last_modified
            );
            updateRow($this->tbl_name,$data,$where);
            return true;
        }
        else{
            return false;
        }
    }
    public function login(){
        if($this->check_login()){
            $where = array(
                "email_user" => $this->email_user,
                "status_aktif_user" => "ACTIVE"
            );
            $field = array(
                "id_submit_user","nama_user", "password_user"
            );
            $result = selectRow($this->tbl_name,$where,$field);
            if($result->num_rows() > 0){
                $result = $result->result_array();
                if (password_verify($this->password_user, $result[0]["password_user"])){
                    $data = array(
                        "id" => $result[0]["id_submit_user"],
                        "name" => $result[0]["nama_user"],
                        "email" => $this->email 
                    );
                    return $data;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function check_update_password(){
        if($this->id_submit_user != "" && $this->password_user != "" && $this->user_last_modified != ""){
            return true;
        }
        else{
            return false;
        }
    }   
    public function check_login(){
        if($this->email_user != "" && $this->password_user != ""){
            return true;
        }
        else{
            return false;
        }
    }
    public function check_insert(){
        if($this->nama_user  != "" && $this->password_user  != "" && $this->email_user  != "" && $this->status_aktif_user  != "" && $this->user_last_modified != "" && $this->id_last_modified != ""){
            return true;
        }
        else{
            return false;
        }
    }
    public function check_update(){
        if($this->id_submit_user != "" &&  $this->nama_user  != "" && $this->email_user  != "" && $this->user_last_modified != "" && $this->id_last_modified != ""){
            return true;
        }
        else{
            return false;
        }
    }
    public function check_delete(){
        if($this->id_submit_user != "" && $this->user_last_modified != "" && $this->id_last_modified != ""){
            return true;
        }
        else{
            return false;
        }
    }
    public function set_update_password($id_submit_user,$password_user,$id_last_modified){
        if(!$this->set_id_submit_user($id_submit_user)){
            return false;
        }
        if(!$this->set_password_user($password_user)){
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){
            return false;
        }
        return true;
    }
    public function set_login($email_user,$password_user){
        if(!$this->set_email_user($email_user)){
            return false;
        }
        if(!$this->set_password_user($password_user)){
            return false;
        }
        return true;
    }
    public function set_insert($nama_user,$password_user,$email_user,$status_aktif_user,$id_last_modified){
        if(!$this->set_nama_user($nama_user)){ 
            return false;
        }
        if(!$this->set_password_user($password_user)){ 
            return false;
        }
        if(!$this->set_email_user($email_user)){ 
            return false;
        }
        if(!$this->set_status_aktif_user($status_aktif_user)){ 
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){ 
            return false;
        }
        return true;
    }
    public function set_update($id_submit_user,$nama_user,$email_user,$id_last_modified){
        if(!$this->set_id_submit_user($id_submit_user)){ 
            return false;
        }
        if(!$this->set_nama_user($nama_user)){ 
            return false;
        }
        if(!$this->set_email_user($email_user)){ 
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){ 
            return false;
        }
        return true;
    }
    public function set_delete($id_submit_user,$id_last_modified){
        if(!$this->set_id_submit_user($id_submit_user)){ 
            return false;
        }
        if(!$this->set_id_last_modified($id_last_modified)){ 
            return false;
        }
        return true;
    }
    public function set_id_submit_user($id_submit_user){
        
        if($id_submit_user != ""){
            $this->id_submit_user = $id_submit_user;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_nama_user($nama_user){
        
        if($nama_user != ""){
            $this->nama_user = $nama_user;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_password_user($password_user){
        
        if($password_user != ""){
            $this->password_user = $password_user;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_email_user($email_user){
        
        if($email_user != ""){
            $this->email_user = $email_user;
            return true;
        }
        else{
            return false;
        }
    }
    public function set_status_aktif_user($status_aktif_user){
        
        if($status_aktif_user != ""){
            $this->status_aktif_user = $status_aktif_user;
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
    public function get_id_submit_user(){
        return $this->id_submit_user;
    }
    public function get_nama_user(){
        return $this->nama_user;
    }
    public function get_password_user(){
        return $this->password_user;
    }
    public function get_email_user(){
        return $this->email_user;
    }
    public function get_status_aktif_user(){
        return $this->status_aktif_user;
    }
    public function get_id_last_modified(){
        return $this->id_last_modified;
    }
}