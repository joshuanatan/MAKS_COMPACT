<div class="page-header">
    <h1 class="page-title">RESULT TYPE</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Result Type</li>
    </ol>
</div>
<br/>
<?php if($this->session->status_result == "success"):?>
    <div class = "alert alert-success alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_result;?>
    </div>
<?php elseif($this->session->status_result == "error"):?>
    <div class = "alert alert-danger alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_result;?>
    </div>
<?php endif;?>
<div class="page-body">
    <div class = "col-lg-12">
        <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#register_modal" style = "margin-right:10px">Add Result Type</button>
        <div class = "align-middle text-center">
            <i style = "cursor:pointer;font-size:large;margin-left:10px" class = "text-primary md-edit"></i><b> - Edit </b>   
            <i style = "cursor:pointer;font-size:large;margin-left:10px" class = "text-danger md-delete"></i><b> - Delete </b>
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
                <h4>ADD RESULT TYPE</h4>
            </div>
            <form id = "register_form" method = "POST">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5>Result Type Name</h5>
                        <input type = "text" class = "form-control" name = "result_type">
                    </div>
                    <button type = "button" data-dismiss = "modal" class = "btn btn-danger btn-sm">CANCEL</button>
                    <button type = "button" onclick = "register()" class = "btn btn-primary btn-sm">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class = "modal fade" id = "update_modal">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>EDIT RESULT TYPE</h4>
            </div>
            <form id = "update_form" method = "POST">
                <div class = "modal-body">
                    <div class = "form-group">
                        <h5>Result Type Name</h5>
                        <input type = "hidden" name = "id_result_type" id = "id_result_type_edit">
                        <input type = "text" class = "form-control" name = "result_type" id = "result_type_edit">
                    </div>
                    <button type = "button" data-dismiss = "modal" class = "btn btn-danger btn-sm">CANCEL</button>
                    <button type = "button" onclick = "update()" class = "btn btn-primary btn-sm">SUBMIT</button>
                </div>
            </form>
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
            <input type = "hidden" value = "" id = "id_result_type_delete">
                <h4 align = "center">Are you sure want to delete this result type?</h4>
                <table class = "table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Result Type</td>
                            <td id = "result_type_delete"></td>
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
            url: "<?php echo base_url();?>ws/result_type/content?orderBy="+orderBy+"&orderDirection="+orderDirection+"&page="+page+"&searchKey="+searchKey,
            type: "GET",
            dataType: "JSON",
            success: function(respond) {
                var html = "";
                if(respond["status"] == "SUCCESS"){
                    for(var a = 0; a<respond["content"].length; a++){
                        html += "<tr>";
                        html += "<td class = 'align-middle text-center' id = 'result_type"+respond["content"][a]["id"]+"'>"+respond["content"][a]["result_type"]+"</td>";
                        html += "<td class = 'align-middle text-center' id = 'status"+respond["content"][a]["id"]+"'>"+respond["content"][a]["status"]+"</td>";
                        html += "<td class = 'align-middle text-center' id = 'last_modified"+respond["content"][a]["id"]+"'>"+respond["content"][a]["last_modified"]+"</td>";
                        html += "<td class = 'align-middle text-center'><i style = 'cursor:pointer;font-size:large' data-toggle = 'modal' class = 'text-primary md-edit' data-target = '#update_modal' onclick = 'load_content("+respond["content"][a]["id"]+")'></i> | <i style = 'cursor:pointer;font-size:large' data-toggle = 'modal' class = 'text-danger md-delete' data-target = '#delete_modal' onclick = 'load_delete_content("+respond["content"][a]["id"]+")'></i></td>";
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
</script>
<script>
    window.onload = function(){
        refresh();
    }
</script>
<script>
    function register(){
        var form = $("#register_form")[0];
        var data = new FormData(form);
        $.ajax({
            url:"<?php echo base_url();?>ws/result_type/insert",
            type:"POST",
            dataType:"JSON",
            data:data,
            processData:false,
            contentType:false,
            success:function(respond){
                if(respond["status"] == "SUCCESS"){
                    $("#register_modal").modal("hide");
                    $("#register_modal input").val("");
                    refresh(page);
                }
            }
        });
    }
    function update(){
        var form = $("#update_form")[0];
        var data = new FormData(form);
        $.ajax({
            url:"<?php echo base_url();?>ws/result_type/update",
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
    function remove(){
        var id = $("#id_result_type_delete").val();
        $.ajax({
            url:"<?php echo base_url();?>ws/result_type/delete/"+id,
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
        var result_type = $("#result_type"+id).text();
        $("#id_result_type_edit").val("");
        $("#result_type_edit").val("");
        $("#id_result_type_edit").val(id);
        $("#result_type_edit").val(result_type);
    }
    function load_delete_content(id){
        var result_type = $("#result_type"+id).text();
        $("#id_result_type_delete").val(id);
        $("#result_type_delete").text(result_type);
    }
</script>