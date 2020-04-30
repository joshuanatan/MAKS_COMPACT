<div class="page-header">
    <h1 class="page-title">MASTER USER</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">User</li>
    </ol>
</div>
<br/>
<?php if($this->session->status == "success"):?>
<div class = "alert alert-success alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo $this->session->msg;?>
</div>
<?php elseif($this->session->status == "error"):?>
<div class = "alert alert-danger alert-dismissible">
    <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
    <?php echo $this->session->msg;?>
</div>
<?php endif;?>
<div class="page-body">
    <div class = "col-lg-12">
        <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#register_modal" style = "margin-right:10px">Add User</button>
        <div class = "align-middle text-center">
            <i style = "cursor:pointer;font-size:large;margin-left:10px" class = "text-primary md-edit"></i><b> - Edit </b>   
            <i style = "cursor:pointer;font-size:large;margin-left:10px" class = "text-danger md-delete"></i><b> - Delete </b>
            <i style = "cursor:pointer;font-size:large;margin-left:10px" class = "text-success md-eye-off"></i><b> - Change Password </b>
        </div>
        <br/>
        <div class = "table-responsive ">
            <div class = "form-group">
                <h5>Search Data Here</h5>
                <input id = "search_box" placeholder = "Search data here..." type = "text" class = "form-control form-control-sm col-lg-3 col-sm-12" onkeyup = "search()">
            </div>
            <table class = "table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <?php for($a = 0; $a<count($col); $a++):?>
                        <th id = "col<?php echo $a;?>" style = "cursor:pointer" onclick = "sort(<?php echo $a;?>)" class = "text-center align-middle"><?php echo $col[$a]["col_disp"];?> 
                        <?php if($a == 0):?>
                        <span class="badge badge-light align-top" id = "orderDirection">ASC</span>
                        <?php endif;?>
                        </th>
                        <?php endfor;?>
                        <th class = "text-center align-middle">Action</th>
                    </tr>
                </thead>
                <tbody id = "content_container">
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center" id = "pagination_container">
            </ul>
        </nav>
    </div>
</div>
<div class = "modal fade" id = "register_modal">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Add User</h4>
            </div>
            <div class = "modal-body">
                <form id = "register_form" method = "POST">
                    <div class = "form-group">
                        <h5>Nama User</h5>
                        <input required type = "text" class = "form-control" name = "nama_user">
                    </div>
                    <div class = "form-group">
                        <h5>Email User</h5>
                        <input required type = "text" class = "form-control" name = "email_user">
                    </div>
                    <div class = "form-group">
                        <h5>Password User</h5>
                        <input required type = "password" class = "form-control" name = "password_user">
                    </div>
                    <div class = "form-group">
                        <button type = "button" data-dismiss = "modal" class = "btn btn-danger btn-sm">CANCEL</button>
                        <button type = "button" onclick = "register()" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "update_modal">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Edit User</h4>
            </div>
            <div class = "modal-body">
                <form id = "edit_form" method = "POST">
                    <input type = "hidden" id = "id_submit_user_edit" name = "id_submit_user" >
                    <div class = "form-group">
                        <h5>Nama User</h5>
                        <input required type = "text" class = "form-control" id = "nama_user_edit" name = "nama_user">
                    </div>
                    <div class = "form-group">
                        <h5>Email User</h5>
                        <input required type = "text" class = "form-control" id = "email_user_edit" name = "email_user">
                    </div>
                    <div class = "form-group">
                        <button type = "button" data-dismiss = "modal" class = "btn btn-danger btn-sm">CANCEL</button>
                        <button type = "button" onclick = "update()" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "update_pwd_modal">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Edit PASSWORD</h4>
            </div>
            <div class = "modal-body">
                <form id = "edit_pwd_form" method = "POST">
                    <input type = "hidden" name = "id_submit_user" id = "id_submit_user_pwd" >
                    <div class = "form-group">
                        <h5>Password User</h5>
                        <input required type = "password" class = "form-control" name = "password_user" id = "password_user_pwd">
                    </div>
                    <div class = "form-group">
                        <button type = "button" data-dismiss = "modal" class = "btn btn-danger btn-sm">CANCEL</button>
                        <button type = "button" onclick = "update_pwd()" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "delete_modal">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Delete Confirmation</h4>
            </div>
            <div class = "modal-body">
            <input type = "hidden" value = "" id = "id_submit_user_delete">
                <h4 align = "center">Are you sure want to delete this user?</h4>
                <table class = "table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>User Name</td>
                            <td id = "user_name_delete"></td>
                        </tr>
                        <tr>
                            <td>User Email</td>
                            <td id = "user_email_delete"></td>
                        </tr>
                    </tbody>
                </table>
                <div class = "row">
                    <button type = "button" class = "btn btn-sm btn-primary col-lg-3 col-sm-12 offset-lg-3" data-dismiss = "modal">Cancel</button>
                    <button type = "button" onclick = "remove()" class = "btn btn-sm btn-danger col-lg-3">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var orderBy = 0;
    var orderDirection = "ASC";
    var searchKey = "";
    var page = 1;
    function refresh(req_page = 1) {
        page = req_page;
        $.ajax({
            url: "<?php echo base_url();?>ws/user/content?orderBy="+orderBy+"&orderDirection="+orderDirection+"&page="+page+"&searchKey="+searchKey,
            type: "GET",
            dataType: "JSON",
            success: function(respond) {
                var html = "";
                if(respond["status"] == "SUCCESS"){
                    for(var a = 0; a<respond["content"].length; a++){
                        html += "<tr>";
                        html += "<td class = 'align-middle text-center' id = 'nama"+respond["content"][a]["id"]+"'>"+respond["content"][a]["nama"]+"</td>";
                        html += "<td class = 'align-middle text-center' id = 'email"+respond["content"][a]["id"]+"'>"+respond["content"][a]["email"]+"</td>";
                        html += "<td class = 'align-middle text-center' id = 'status"+respond["content"][a]["id"]+"'>"+respond["content"][a]["status"]+"</td>";
                        html += "<td class = 'align-middle text-center' id = 'last_modified"+respond["content"][a]["id"]+"'>"+respond["content"][a]["last_modified"]+"</td>";
                        if(respond["content"][a]["id"] == <?php echo $this->session->id_user;?>){
                            html += "<td></td>";
                        }
                        else{
                            html += "<td class = 'align-middle text-center'><i style = 'cursor:pointer;font-size:large' data-toggle = 'modal' class = 'text-primary md-edit' data-target = '#update_modal' onclick = 'load_content("+respond["content"][a]["id"]+")'></i> | <i style = 'cursor:pointer;font-size:large' data-toggle = 'modal' class = 'text-danger md-delete' data-target = '#delete_modal' onclick = 'load_delete_content("+respond["content"][a]["id"]+")'></i> | <i style = 'cursor:pointer;font-size:large' data-toggle = 'modal' class = 'text-success md-eye-off' data-target = '#update_pwd_modal' onclick = 'load_update_pwd_content("+respond["content"][a]["id"]+")'></i></td>";
                        }
                        html += "</tr>";
                    }
                }
                else{
                    html += "<tr>";
                    html += "<td colspan = 6 class = 'align-middle text-center'>No Records Found</td>";
                    html += "</tr>";
                }
                $("#content_container").html(html);
                pagination(respond["page"]);
                
            },
            error: function(){
                var html = "";
                html += "<tr>";
                html += "<td colspan = 6 class = 'align-middle text-center'>No Records Found</td>";
                html += "</tr>";
                $("#content_container").html(html);
                
                html = "";
                html += '<li class="page-item"><a class="page-link" style = "cursor:not-allowed"><</a></li>';
                html += '<li class="page-item"><a class="page-link" style = "cursor:not-allowed">></a></li>';
                $("#pagination_container").html(html);
            }
        });
        function pagination(page_rules){
            html = "";
            if(page_rules["previous"]){
                html += '<li class="page-item"><a class="page-link" onclick = "refresh('+(page_rules["before"])+')"><</a></li>';
            }
            else{
                html += '<li class="page-item"><a class="page-link" style = "cursor:not-allowed"><</a></li>';
            }
            if(page_rules["first"]){
                html += '<li class="page-item"><a class="page-link" onclick = "refresh('+(page_rules["first"])+')">'+(page_rules["first"])+'</a></li>';
                html += '<li class="page-item"><a class="page-link">...</a></li>';
            }
            if(page_rules["before"]){
                html += '<li class="page-item"><a class="page-link" onclick = "refresh('+(page_rules["before"])+')">'+page_rules["before"]+'</a></li>';
            }
            html += '<li class="page-item active"><a class="page-link" onclick = "refresh('+(page_rules["current"])+')">'+page_rules["current"]+'</a></li>';
            if(page_rules["after"]){
                html += '<li class="page-item"><a class="page-link" onclick = "refresh('+(page_rules["after"])+')">'+page_rules["after"]+'</a></li>';
            }
            if(page_rules["last"]){
                html += '<li class="page-item"><a class="page-link">...</a></li>';
                html += '<li class="page-item"><a class="page-link" onclick = "refresh('+(page_rules["last"])+')">'+page_rules["last"]+'</a></li>';
            }
            if(page_rules["next"]){
                html += '<li class="page-item"><a class="page-link" onclick = "refresh('+(page_rules["after"])+')">></a></li>';
            }
            else{
                html += '<li class="page-item"><a class="page-link" style = "cursor:not-allowed">></a></li>';
            }
            $("#pagination_container").html(html);
        }
    }
    function sort(colNum){
        if(parseInt(colNum) != orderBy){
            orderBy = colNum; 
            orderDirection = "ASC";
            var orderDirectionHtml = '<span class="badge badge-light align-top" id = "orderDirection">ASC</span>';
            $("#orderDirection").remove();
            $("#col"+colNum).append(orderDirectionHtml);
        }
        else{
            var direction = $("#orderDirection").text();
            if(direction == "ASC"){
                orderDirection = "DESC";
            }
            else{
                orderDirection = "ASC";
            }
            $("#orderDirection").text(orderDirection);
        }
        refresh();
    }
    function search(){
        searchKey = $("#search_box").val();
        refresh();
    }
    window.onload = function(){
        refresh();
    }
</script>
<script>
    function register(){
        var form = $("#register_form")[0];
        var data = new FormData(form);
        $.ajax({
            url:"<?php echo base_url();?>ws/user/insert",
            type:"POST",
            dataType:"JSON",
            data:data,
            processData:false,
            contentType:false,
            success:function(respond){
                if(respond["status"] == "SUCCESS"){
                    $("#register_modal").modal("hide");
                    refresh(page);
                }
            }
        });
    }
    function update(){
        var form = $("#edit_form")[0];
        var data = new FormData(form);
        $.ajax({
            url:"<?php echo base_url();?>ws/user/update",
            type:"POST",
            dataType:"JSON",
            data:data,
            processData: false,
            contentType: false,
            success:function(respond){
                if(respond["status"] == "SUCCESS"){
                    $("#update_modal").modal("hide");
                    refresh(page);
                }
            }
        });
    }
    function update_pwd(){
        var form = $("#edit_pwd_form")[0];
        var data = new FormData(form);
        $.ajax({
            url:"<?php echo base_url();?>ws/user/update_password",
            type:"POST",
            dataType:"JSON",
            data:data,
            processData: false,
            contentType: false,
            success:function(respond){
                if(respond["status"] == "SUCCESS"){
                    $("#update_pwd_modal").modal("hide");
                    refresh(page);
                }
            }
        });
    }
    function remove(){
        var id = $("#id_submit_user_delete").val();
        $.ajax({
            url:"<?php echo base_url();?>ws/user/delete/"+id,
            type:"DELETE",
            dataType:"JSON",
            success:function(respond){
                $("#delete_modal").modal("hide");
                refresh(page);
            }
        });
    }
</script>
<script>
    function load_content(id){
        var id_user = id;
        var nama_user = $("#nama"+id).text();
        var email_user = $("#email"+id).text();

        $("#id_submit_user_edit").val(id_user);
        $("#nama_user_edit").val(nama_user);
        $("#email_user_edit").val(email_user);
    }
    function load_delete_content(id){
        var nama_user = $("#nama"+id).text();
        var email_user = $("#email"+id).text();
        
        $("#id_submit_user_delete").val(id);
        $("#user_name_delete").html(nama_user);
        $("#user_email_delete").html(email_user);
    }
    function load_update_pwd_content(id){
        $("#id_submit_user_pwd").val(id);
    }   
</script>