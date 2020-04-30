<div class = "row">
    <?php
    $control = array(); 
    for($a = 0; $a<count($data); $a++):
    ?>
    <?php if(count($data[$a]["value"]["content"]) > 0):?>
    
    <div class="col-lg-6 col-xl-6">
    <!-- Example Bar -->
        <h5><?php echo $data[$a]["title"];?></h5>
        <div class="example-wrap">
            <h4 class="example-title"></h4>
            <div class="example text-center">
                <canvas id="chart<?php echo $a;?>" style = "width:100%"></canvas>
            </div>
        </div>
    <!-- End Example Bar -->
    </div>
    <?php endif;?>
    <?php endfor;?>
</div>
<?php /* Ini script untuk initiate */?>
<script>
    (function (global, factory) {
        if (typeof define === "function" && define.amd) {
            //define("/charts/chartjs", ["jquery", "Site"], factory);
        } 
        else if (typeof exports !== "undefined") {
            factory(require("jquery"), require("Site"));
        } 
        else {
            var mod = {
                exports: {}
            };
            factory(global.jQuery, global.Site);
            global.chartsChartjs = mod.exports;
        }
    })
    (this, function (_jquery, _Site) {
        "use strict";
        _jquery = babelHelpers.interopRequireDefault(_jquery);
        (0, _jquery.default)(document).ready(function ($$$1) {
            (0, _Site.run)();
        });
        Chart.defaults.global.responsive = true; 
    });
</script>
<script>
    <?php
    $control = array(); 
    $result = array();
    $label = array();
    $result_counter = 0; 
    $label_counter = 0;
    for($a = 0; $a<count($data); $a++){ //ngeloop datasetnya
        
        for($c = 0; $c<count($data[$a]["value"]["content"]); $c++){ //ngeloop isinya bakal ada berapa bar di chart
            for($d = 0; $d<count($data[$a]["value"]["header"]); $d++){ //ambil accesskey nya (harusnya cuman 2)
                $key = $data[$a]["value"]["header"][$d]["db_field"]; //ambil bagian yang dbfield bukan alias
                if(array_key_exists($key,$data[$a]["value"]["content"][$c])){
                    if(is_numeric($data[$a]["value"]["content"][$c][$key])){ //kalau value-content-ke 0 dengan key dbfield = ambil value
                        $result[$a][$c] = $data[$a]["value"]["content"][$c][$key];
                    }
                    else{
                        $label[$a][$c] = $data[$a]["value"]["content"][$c][$key];
                    }
                }
            }
        }
    }
    ?>
    <?php for($a = 0; $a<count($data); $a++):?>
        <?php //echo "counter a:".$a;?>
    <?php if(count($data[$a]["value"]["content"]) > 0):?>
    (function () {
        var barChartData = {
            labels: [
                <?php
                for($b = 0; $b<count($label[$a]); $b++){
                    echo "'".$label[$a][$b]."'";
                    if($b+1 != count($label[$a])){
                        echo ",";
                    }
                }
                ?>
            ],
            datasets: [
                {
                    label: '',
                    backgroundColor: "rgba(204, 213, 219, .2)",
                    borderColor: Config.colors("blue-grey", 300),
                    hoverBackgroundColor: "rgba(204, 213, 219, .3)",
                    borderWidth: 2,
                    data: [
                        <?php 
                        for($b = 0; $b<count($result[$a]); $b++){
                            echo $result[$a][$b];
                            if($b+1 != count($result[$a])){
                                echo ",";
                            }
                        }
                        ?>
                    ]
                },
            ]
        };
        var myBar = new Chart(document.getElementById("chart<?php echo $a;?>").getContext("2d"), {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                        display: true
                    }],
                    yAxes: [{
                        display: true
                    }]
                }
            }
        });
    })(); 
    <?php endif;?>
    <?php endfor;?>
</script>

