show triggers;
delimiter $$
create trigger after_update_result_type
after update on tbl_result_type
for each row
begin
update tbl_result_type_mapping set result_type = new.result_type where result_type = old.result_type;
end $$
delimiter ;

