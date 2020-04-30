<div class = "row">
    <?php for($a = 0; $a<count($data); $a++):?>
    <h5><?php echo ucwords($data[$a]["title"]);?></h5>
    <table class = "table table-striped table-hover table-bordered">
        <thead>
            <?php for($b = 0; $b<count($data[$a]["value"]["header"]); $b++):?>
            <th><?php echo $data[$a]["value"]["header"][$b]["db_field_alias"];?></th>
            <?php endfor;?>
        </thead>
        <tbody>
            <?php for($row = 0; $row<count($data[$a]["value"]["content"]); $row++):?>
            <tr>
                <?php for($col = 0; $col<count($data[$a]["value"]["header"]); $col++):?>
                <?php $access_key = $data[$a]["value"]["header"][$col]["db_field"];?>
                <?php if(array_key_exists($access_key,$data[$a]["value"]["content"][$row])):?>
                <td><?php echo $data[$a]["value"]["content"][$row][$access_key];?></td>
                <?php else:?>
                <td></td>
                <?php endif;?>
                <?php endfor;?>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <?php endfor;?>
</div>