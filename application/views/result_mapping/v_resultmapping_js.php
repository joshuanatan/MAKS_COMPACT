<script>
function autoChecklist(a){
    $("#checkbox"+a).attr("checked",true);
}
</script>
<script>
function checkExistingKey(){
    var search = $("#new_key").val();
    $.ajax({
        url:"<?php echo base_url();?>interface/mapping/check_existing",
        type:"POST",
        dataType:"JSON",
        data:{
            key:search
        },
        success:function(respond){
            var html = "<option value = 'new_key'>New Mapping Key</option>";
            if(respond.length > 0){
                var html = "";
                for(var a = 0; a<respond.length; a++){
                    html += "<option value = '"+respond[a]["mapping_key"]+"'>"+respond[a]["mapping_key"]+" [ DATA EXISTS ]</option>";
                }
            }
            $("#option_container").html(html);
        }
    });
}
</script>