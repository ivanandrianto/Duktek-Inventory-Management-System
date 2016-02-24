
appStatistik.controller('statistikController', function($scope, $http, API_URL) {
    $('#pengguna').hide();
    $scope.tipe = "1";
    $http.get(API_URL + "peralatan_jenis")
            .success(function(response) {
                $scope.jeniss = response;
            });

    $scope.toggle = function(status){
        if(status != 1)
            $('#pengguna').hide();
        else if(status == 1)
            $('#pengguna').show();

    }

    $scope.submit = function() {
        if(isNaN(parseInt($scope.tahun))){
            alert("Masukan Harus Merupakan Angka pada Range 1970 - 2037");
        }
        else{
            if ($scope.tahun <= 1970 || $scope.tahun >= 2037){
                alert("Tahun harus berada pada range 1970 - 2037")
            }
            else{
                if($scope.tipe == 1){
                    var data_statistik;
                    var data_bulan=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $(document).ready(function(){
                        $.ajax({
                            type: "GET",
                          url: "http://localhost:8000/api/v1/statistik/penggunaan/"+$scope.jenis.jenis+"/"+$scope.tahun,
                          success: function(data) {
                           if(data == 0){
                                alert("Tidak ada pada tahun itu");
                                $('#canvas').hide();
                            }
                            else{
                                $('#canvas').show();
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
                                            label: "Grafik",
                                            fillColor : "rgba(220,220,220,0.2)",
                                            strokeColor : "rgba(255,255,255,1)",
                                            pointColor : "rgba(255,255,255,1)",
                                            pointStrokeColor : "#fff",
                                            pointHighlightFill : "#fff",
                                            pointHighlightStroke : "rgba(255,255,255,1)",
                                            data : [data_bulan[0],data_bulan[1],data_bulan[2],data_bulan[3],data_bulan[4],data_bulan[5],data_bulan[6],data_bulan[7],data_bulan[8],data_bulan[9],data_bulan[10],data_bulan[11]]
                                        },
                                    ]

                                }
                                var ctx = document.getElementById("canvas").getContext("2d");
                                    window.myLine = new Chart(ctx).Line(lineChartData, {
                                        responsive: true,scaleFontColor: "#FFFFFF"
                                    });
                            }
                            
                          }
                        });
                    });

                }
                else if($scope.tipe == 2){
                    var data_statistik;
                    var data_bulan=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $(document).ready(function(){
                        $.ajax({
                            type: "GET",
                          url: "http://localhost:8000/api/v1/statistik/kerusakan/"+$scope.jenis.jenis+"/"+$scope.tahun,
                          success: function(data) {
                           if(data == 0){
                                alert("Tidak ada pada tahun itu");
                                $('#canvas').hide();
                            }
                            else{
                                $('#canvas').show();                 
                                data_statistik = data;
                                for (var i = 1;i<=data_bulan.length;i++){
                                    for (var j=0;j<data_statistik.length;j++){
                                        if (data_statistik[j].Bulan == i){
                                            data_bulan[i] = data_statistik[j].Jumlah_Rusak;
                                        }
                                    }    
                                }
                                var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
                                var lineChartData = {
                                    labels : ["January","February","March","April","May","June","July","August","September","October","November","Desember"],
                                    datasets : [
                                        {
                                            label: "Grafik",
                                            fillColor : "rgba(220,220,220,0.2)",
                                            strokeColor : "rgba(255,255,255,1)",
                                            pointColor : "rgba(255,255,255,1)",
                                            pointStrokeColor : "#fff",
                                            pointHighlightFill : "#fff",
                                            pointHighlightStroke : "rgba(255,255,255,1)",
                                            data : [data_bulan[0],data_bulan[1],data_bulan[2],data_bulan[3],data_bulan[4],data_bulan[5],data_bulan[6],data_bulan[7],data_bulan[8],data_bulan[9],data_bulan[10],data_bulan[11]]
                                        },
                                    ]

                                }
                                var ctx = document.getElementById("canvas").getContext("2d");
                                window.myLine = new Chart(ctx).Line(lineChartData, {
                                    responsive: true,scaleFontColor: "#FFFFFF"
                                });
                            }
                          }
                        });
                    });
                }
                else if($scope.tipe == 3){
                    var data_statistik;
                    var data_bulan=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $(document).ready(function(){
                        $.ajax({
                            type: "GET",
                          url: "http://localhost:8000/api/v1/statistik/kelompok/"+$scope.jenis.jenis+"/"+$scope.pengguna+"/"+$scope.tahun,
                          success: function(data) {
                            if(data == 0){
                                alert("Tidak ada pada tahun itu");
                                $('#canvas').hide();
                            }
                            else{
                                $('#canvas').show();
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
                                            label: "Grafik",//data_statistik[0].Kelompok_Pengguna,
                                            fillColor : "rgba(220,220,220,0.2)",
                                            strokeColor : "rgba(255,255,255,1)",
                                            pointColor : "rgba(255,255,255,1)",
                                            pointStrokeColor : "#fff",
                                            pointHighlightFill : "#fff",
                                            pointHighlightStroke : "rgba(255,255,255,1)",
                                            data : [data_bulan[0],data_bulan[1],data_bulan[2],data_bulan[3],data_bulan[4],data_bulan[5],data_bulan[6],data_bulan[7],data_bulan[8],data_bulan[9],data_bulan[10],data_bulan[11]]
                                        },
                                    ]

                                }
                                var ctx = document.getElementById("canvas").getContext("2d");
                                window.myLine = new Chart(ctx).Line(lineChartData, {
                                    responsive: true,scaleFontColor: "#FFFFFF"
                                });
                            }
                          }
                        });
                    });
                }
            }
        }
        
        
    }

});
