<div class="page-header">
    <h1 class="page-title">RESULT TYPE MAPPING</h1>
    <br/>
    <ol class="breadcrumb breadcrumb-arrow">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item">Result Type</li>
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
<div class="page-body">
    <button type = "button" class = "btn btn-primary btn-sm" data-toggle = "modal" data-target = "#tambahResultMapping">+ ADD NEW MAPPING</button>
    <a href = "<?php echo base_url();?>resultmapping/mapped_result_recycle_bin" class = "btn btn-light btn-sm"><i class = "icon wb-trash"></i></a>
    <br/><br/>
    <form action = "<?php echo base_url();?>resultmapping/update" method = "POST">
        <table class = "table table-striped table-hover table-bordered" id = "table_driver" data-plugin = "dataTable">
            <thead>
                <th style = "width:5%">#</th>
                <th>Dataset Key</th>
                <th>Result Type</th>
                <th>Last Modified</th>
                <th style = "width:10%">Status Intent</th>
                <th style = "width:10%">Action</th>
            </thead>
            <tbody>
                <?php for($a = 0; $a<count($result_mapping); $a++):?>
                <tr>
                    <td>
                        <div class = "checkbox-custom checkbox-primary">
                            <input type = "hidden" name = "id_submit_result_type_mapping<?php echo $a;?>" value = "<?php echo $result_mapping[$a]["id_submit_result_type_mapping"];?>">
                            <input id = "checkbox<?php echo $a;?>" type = "checkbox" name = "checks[]" value = "<?php echo $a;?>">
                            <label></label>
                        </div>
                    </td>
                    <td><?php echo nl2br($result_mapping[$a]["mapping_key"]);?></td>
                    <td>
                        <select class = "form-control" name = "result_type<?php echo $a;?>" onchange = "autoChecklist(<?php echo $a;?>)">
                            <option value = '' selected disabled>Select Result Type</option>
                            <?php for($b = 0; $b<count($result_type); $b++):?>
                            <option value = "<?php echo $result_type[$b]["result_type"];?>"<?php if($result_type[$b]["result_type"] == $result_mapping[$a]["result_type"]) echo "selected";?>><?php echo $result_type[$b]["result_type"];?></option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <td><?php echo $result_mapping[$a]["tgl_result_type_mapping_last_modified"];?></td>
                    <td>
                        <?php if($result_mapping[$a]["status_aktif_result_type_mapping"] == 1):?>
                        <button type = "button" class = "btn btn-primary btn-sm col-lg-12">ACTIVE</button>
                        <?php else:?>
                        <button type = "button" class = "btn btn-danger btn-sm col-lg-12">NOT ACTIVE</button>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if($result_mapping[$a]["status_aktif_result_type_mapping"] == 0):?>
                        <a href = "<?php echo base_url();?>resultmapping/activate_mapped/<?php echo $result_mapping[$a]["id_submit_result_type_mapping"];?>" class = "btn btn-light btn-sm col-lg-12">ACTIVATE</button>
                        <?php elseif($result_mapping[$a]["status_aktif_result_type_mapping"] == 1):?>
                        <a href = "<?php echo base_url();?>resultmapping/deactive_mapped/<?php echo $result_mapping[$a]["id_submit_result_type_mapping"];?>" class = "btn btn-danger btn-sm col-lg-12">DEACTIVE</button>
                        <?php endif;?>
                        <a href = "<?php echo base_url();?>resultmapping/delete_mapped/<?php echo $result_mapping[$a]["id_submit_result_type_mapping"];?>" class = "btn btn-dark btn-sm col-lg-12">DELETE</button>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
    </form>
</div>
<div class = "modal fade" id = "tambahResultMapping">
    <div class = "modal-dialog modal-center">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4>Result Type Mapping</h4>
            </div>
            <div class = "modal-body">
                <form action = "<?php echo base_url();?>resultmapping/insert_mapping" method = "POST">
                    <div class = "form-group">
                        <h5>Mapping Key</h5>
                        <input type = "text" class = "form-control" id = "new_key" name = "new_key" onkeyup = "checkExistingKey()">
                        <br/>
                        <select class = "form-control" name = "key" id = "option_container">
                            <option value = "new_key">New Mapping Key</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <h5>Result Type</h5>
                        <select class = "form-control" name = "result_type">
                            <?php for($b = 0; $b<count($result_type); $b++):?>
                            <option value = "<?php echo $result_type[$b]["result_type"];?>"><?php echo $result_type[$b]["result_type"];?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>