<div class="page-header">
    <h1 class="page-title">REQUEST INTENTION - RESULT TYPE MAPPING</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Request Intention - Result Type</li>
    </ol>
</div>
<br/>
<?php if($this->session->status_mapping == "success"):?>
    <div class = "alert alert-success alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_mapping;?>
    </div>
<?php elseif($this->session->status_mapping == "error"):?>
    <div class = "alert alert-danger alert-dismissible">
        <button type = "button" class = "close" data-dismiss = "alert">&times;</button>
        <?php echo $this->session->msg_mapping;?>
    </div>
<?php endif;?>
<div class="page-body col-lg-10 offset-lg-1">
    <form action = "<?php echo base_url();?>resultmapping/update" method = "POST">
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
            <thead>
                <th style = "width:5%">#</th>
                <th>Request Intent</th>
                <th>Result Type</th>
                <th style = "width:10%">Action</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($result_mapping); $a++):?>
                <tr>
                    <td>
                        <?php echo $a+1;?>
                    </td>
                    <td><?php echo nl2br($result_mapping[$a]["mapping_key"]);?></td>
                    <td>
                        <select class = "form-control" name = "result_type<?php echo $a;?>" onchange = "autoChecklist(<?php echo $a;?>)">
                            <?php for($b = 0; $b<count($result_type); $b++):?>
                            <option value = "<?php echo $result_type[$b]["result_type"];?>"><?php echo $result_type[$b]["result_type"];?></option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <td>
                        <a href = "<?php echo base_url();?>resultmapping/activate/<?php echo $result_mapping[$a]["id_submit_result_type_mapping"];?>" class = "btn btn-primary btn-sm col-lg-12">ACTIVATE</button>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
        <a href = "<?php echo base_url();?>resultmapping" class = "btn btn-primary btn-sm">BACK</a>
    </form>
</div>