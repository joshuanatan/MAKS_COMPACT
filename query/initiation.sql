drop database maks_rb;
create database maks_rb;
use maks_rb;
CREATE TABLE `mstr_result_type` (
  `id_submit_result_type` INT PRIMARY KEY AUTO_INCREMENT,
  `result_type` varchar(400) NOT NULL,
  `status_aktif_result_type` varchar(1) DEFAULT NULL,
  `id_user_result_type_last_modified` int(11) DEFAULT NULL,
  `tgl_result_type_last_modified` datetime DEFAULT NULL
);
CREATE TABLE `tbl_result_type_mapping` (
  `id_submit_result_type_mapping` int(11) NOT NULL primary key auto_increment,
  `mapping_key` varchar(400) DEFAULT NULL,
  `result_type` varchar(400) DEFAULT NULL,
  `status_aktif_result_type_mapping` varchar(1) DEFAULT NULL,
  `tgl_result_type_mapping_last_modified` datetime DEFAULT NULL,
  `id_user_result_type_mapping_last_modified` int(11) DEFAULT NULL
);
CREATE TABLE `tbl_token` (
  `id_submit_token` int(11) NOT NULL primary key auto_increment,
  `token` varchar(255) DEFAULT NULL,
  `nama_client` varchar(300) DEFAULT NULL,
  `status_aktif_token` varchar(1) DEFAULT NULL,
  `tgl_token_last_modified` datetime DEFAULT NULL,
  `id_user_token_last_modified` int(11) DEFAULT NULL
);
CREATE TABLE `tbl_user` (
  `id_submit_user` int(11) NOT NULL primary key auto_increment,
  `nama_user` varchar(200) DEFAULT NULL,
  `password_user` varchar(300) DEFAULT NULL,
  `email_user` varchar(200) DEFAULT NULL,	
  `status_aktif_user` varchar(1) DEFAULT NULL,
  `tgl_user_last_modified` datetime DEFAULT NULL,
  `id_user_user_last_modified` int(11) DEFAULT NULL
) ;
INSERT INTO `tbl_user`VALUES
(1, 'Joshua Natan', 'e10adc3949ba59abbe56e057f20f883e', 'joshuanatan.jn@gmail.com', '1', '2019-11-12 12:50:40', 0)