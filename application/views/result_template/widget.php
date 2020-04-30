<div class = "row">
    <?php for($a = 0; $a<count($data); $a++):?>
    <?php $access_key = $data[$a]["value"]["header"][0]["db_field"];?>
    <?php if(array_key_exists($access_key,$data[$a]["value"]["content"][0])):?>
    <div class="col-lg-3">
        <div class="card p-30 flex-row justify-content-between">
            <div class="counter counter-md counter text-right">
                <div class="counter-number-group">
                    <span class="counter-number" style = "font-size:25px"><?php echo $data[$a]["value"]["content"][0][$access_key];?></span><br/>
                    <span class="counter-number-related text-capitalize" style = "font-size:15px"><?php echo $data[$a]["title"];?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php endfor;?>
</div>