<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Statistik</title>

        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        
      
    </head>
    <body>
        <h2>Statistik</h2>
        <div style="width:30%">
            <div>
                <canvas id="canvas" height="600" width="1000"></canvas>
            </div>
        </div>

        <form name="frmStatistik" class="form-horizontal" novalidate="">
                                <input id="_token" name="_token" type="hidden" value="<?php echo csrf_token(); ?>">

                                <div class="form-group error jenis_barang">
                                        <label for="jenis_barang" class="col-sm-3 control-label">Jenis Barang</label>
                                        <div class="col-sm-9">
                                            <select class="form-control has-error" id="jenis_barang" name="jenis_barang"></select>
                                            <span class="help-inline">Field is required</span>
                                        </div>
                                </div>
                            </form>

<!-- ..............................Penggunaan................................................... -->
<!--
        <script>
            var data_statistik;

            var data_bulan=[0,0,0,0,0,0,0,0,0,0,0,0];
            
            

            $(document).ready(function(){
                // alert("aaaaa");
                $.ajax({
                    type: "GET",
                  url: "http://localhost:8000/api/v1/statistik/penggunaan/Tools/2016",
                  success: function(data) {
                    // alert(data);
                    
                    data_statistik = data;
                    for (var i = 1;i<=data_bulan.length;i++){
                        for (var j=0;j<data_statistik.length;j++){
                            if (data_statistik[j].Bulan == i){
                                data_bulan[i] = data_statistik[j].Jumlah_Pakai;
                            }
                        }    
                    }
                    // for (var i = 0;i<data_bulan.length;i++){
                    //     console.log(data_bulan.length);
                    // }
                    
                    // alert(data_statistik[0].Jumlah_Pakai);
                    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
                    var lineChartData = {
                        labels : ["January","February","March","April","May","June","July","August","September","October","November","Desember"],
                        datasets : [
                            {
                                label: "My First dataset",
                                fillColor : "rgba(220,220,220,0.2)",
                                strokeColor : "rgba(220,220,220,1)",
                                pointColor : "rgba(220,220,220,1)",
                                pointStrokeColor : "#fff",
                                pointHighlightFill : "#fff",
                                pointHighlightStroke : "rgba(220,220,220,1)",
                                data : [data_bulan[0],data_bulan[1],data_bulan[2],data_bulan[3],data_bulan[4],data_bulan[5],data_bulan[6],data_bulan[7],data_bulan[8],data_bulan[9],data_bulan[10],data_bulan[11],]
                            },
                        ]

                    }
                    var ctx = document.getElementById("canvas").getContext("2d");
                        window.myLine = new Chart(ctx).Line(lineChartData, {
                            responsive: true
                        });
                  }
                });
            });
                // alert(data_statistik[0].Jumlah_Pakai);
            


        </script>

-->
<!-- ..............................KERUSAKAN................................................... -->

<!--
        <script>
            var data_statistik;

            var data_bulan=[0,0,0,0,0,0,0,0,0,0,0,0];
            
            

            $(document).ready(function(){
                // alert("aaaaa");
                $.ajax({
                    type: "GET",
                  url: "http://localhost:8000/api/v1/statistik/kerusakan/Tools/2016",
                  success: function(data) {
                    // alert(data);
                    
                    data_statistik = data;
                    for (var i = 1;i<=data_bulan.length;i++){
                        for (var j=0;j<data_statistik.length;j++){
                            if (data_statistik[j].Bulan == i){
                                data_bulan[i] = data_statistik[j].Jumlah_Rusak;
                            }
                        }    
                    }
                    // for (var i = 0;i<data_bulan.length;i++){
                    //     console.log(data_bulan.length);
                    // }
                    
                    // alert(data_statistik[0].Jumlah_Pakai);
                    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
                    var lineChartData = {
                        labels : ["January","February","March","April","May","June","July","August","September","October","November","Desember"],
                        datasets : [
                            {
                                label: "My First dataset",
                                fillColor : "rgba(220,220,220,0.2)",
                                strokeColor : "rgba(220,220,220,1)",
                                pointColor : "rgba(220,220,220,1)",
                                pointStrokeColor : "#fff",
                                pointHighlightFill : "#fff",
                                pointHighlightStroke : "rgba(220,220,220,1)",
                                data : [data_bulan[0],data_bulan[1],data_bulan[2],data_bulan[3],data_bulan[4],data_bulan[5],data_bulan[6],data_bulan[7],data_bulan[8],data_bulan[9],data_bulan[10],data_bulan[11],]
                            },
                        ]

                    }
                    var ctx = document.getElementById("canvas").getContext("2d");
                        window.myLine = new Chart(ctx).Line(lineChartData, {
                            responsive: true
                        });
                  }
                });
            });
                // alert(data_statistik[0].Jumlah_Pakai);
            


        </script> -->
<!-- ..............................JENIS PENGGUNA................................................... -->

<!--        <script>
            var data_statistik;

            var data_bulan=[0,0,0,0,0,0,0,0,0,0,0,0];


            $(document).ready(function(){
                $.ajax({
                    type: "GET",
                  url: "http://localhost:8000/api/v1/statistik/kelompok/Tools/Mahasiswa/2016",
                  success: function(data) {
                    
                    data_statistik = data;
                    for (var i = 1;i<=data_bulan.length;i++){
                        for (var j=0;j<data_statistik.length;j++){
                            if (data_statistik[j].Bulan == i){
                                data_bulan[i] = data_statistik[j].Jumlah_Pakai;
                            }
                        }    
                    }
                    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
                    var lineChartData = {
                        labels : ["January","February","March","April","May","June","July","August","September","October","November","Desember"],
                        datasets : [
                            {
                                label: data_statistik[0].Kelompok_Pengguna,
                                fillColor : "rgba(220,220,220,0.2)",
                                strokeColor : "rgba(220,220,220,1)",
                                pointColor : "rgba(220,220,220,1)",
                                pointStrokeColor : "#fff",
                                pointHighlightFill : "#fff",
                                pointHighlightStroke : "rgba(220,220,220,1)",
                                data : [data_bulan[0],data_bulan[1],data_bulan[2],data_bulan[3],data_bulan[4],data_bulan[5],data_bulan[6],data_bulan[7],data_bulan[8],data_bulan[9],data_bulan[10],data_bulan[11],]
                            },
                        ]

                    }
                    var ctx = document.getElementById("canvas").getContext("2d");
                        window.myLine = new Chart(ctx).Line(lineChartData, {
                            responsive: true
                        });
                  }
                });
            });
        </script>

-->
        <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
        <script src="<?= asset('js/Chart.js') ?>"></script>
        <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.min.js') ?>"></script>
        <script src="<?= asset('js/jquery-migrate.min.js') ?>"></script>
        <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
       
        <!-- AngularJS Application Scripts -->
        <script src="<?= asset('app/app.js') ?>"></script>
        <script src="<?= asset('app/controllers/pengguna.js') ?>"></script>
    </body>
</html>