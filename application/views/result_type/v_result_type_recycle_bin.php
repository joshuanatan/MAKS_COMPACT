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
    <div class = "col-lg-8 offset-lg-2 col-sm-12">
        <h4>Result Type Recycle Bin</h4>
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
            <thead>
                <th>Result Type</th>
                <th>Last Modified</th>
                <th style = "width:15%">Action</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($result_type); $a++):?>
                <tr>
                    <td><?php echo $result_type[$a]["result_type"];?></td>
                    <td><?php echo $result_type[$a]["tgl_result_type_last_modified"];?></td>
                    <td>
                        <a href = "<?php echo base_url();?>result_type/activate/<?php echo rawurlencode($result_type[$a]["result_type"]);?>" class = "btn btn-primary btn-sm col-lg-12">ACTIVATE</a>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
        <a href = "<?php echo base_url();?>result_type" class = "btn btn-primary btn-sm">BACK</a>
    </div>
</div>