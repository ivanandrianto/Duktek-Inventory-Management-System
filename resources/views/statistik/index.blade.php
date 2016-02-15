
<!DOCTYPE html>
<html lang="en-US" ng-app="statistikRecords">
<link rel="stylesheet" type="text/css" href="<?= asset('css/style.css') ?>">
    <head>
        <title>Statistik</title>

        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">

        
    </head>
    <body ng-controller="statistikController">
        
        <div class="mycontainer">
            @include('sidebar.sidebar1')
            <div>
                <h2 class="title">Statistik</h2>
            </div>
            <div class="content" style="width:900px;height:100%">                
                <form name="frmStatistik" class="form-horizontal" novalidate="">
                <div class="form-group error">
                    <label for="tipe" class="col-sm-3 control-label">Tipe Statistik</label>
                    <label>
                        <input type="radio" name="tipe"
                               value="1" ng-model="tipe" ng-click="toggle(0)" />
                        Frekuensi Penggunaan
                    </label>
                    <label>
                        <input type="radio" name="tipe"
                               value="2" ng-model="tipe" ng-click="toggle(0)" />
                        Frekuensi Kerusakan
                    </label>
                    <label>
                        <input type="radio" name="tipe"
                               value="3" ng-model="tipe" ng-click="toggle(1)" />
                        Frekuensi Penggunaan oleh Kelompok
                    </label>
                </div>    
                <div class="form-group error">
                    <label for="jenis_barang" class="col-sm-3 control-label">Jenis Barang</label>
                    <div class="col-sm-9">
                        <select ng-disabled="ro_truefalse" class="form-control has-error" id="jenis_barang" name="jenis_barang"  
                            ng-model="jenis.jenis"
                            ng-options="jenis.jenis as jenis.jenis for jenis in jeniss" 
                            ng-required="true">
                        </select>
                    </div>
                </div>
                <div class="form-group error">
                    <label for="tahun" class="col-sm-3 control-label">Tahun</label>
                    <div class="col-sm-9" style="color:black">
                        <input type="text" ng-model="tahun"/>
                    </div>
                </div>
                <div class="form-group error" id="pengguna">
                    <label for="jenis_pengguna" class="col-sm-3 control-label">Jenis Pengguna</label>
                    <label>
                        <input type="radio" name="jenis_pengguna"
                               value="Mahasiswa" ng-model="pengguna" />
                        Mahasiswa
                    </label>
                    <label>
                        <input type="radio" name="jenis_pengguna"
                               value="Dosen" ng-model="pengguna" />
                        Dosen
                    </label>
                    <label>
                        <input type="radio" name="jenis_pengguna"
                               value="Karyawan" ng-model="pengguna" />
                        Karyawan
                    </label>
                </div>
                <div align="right">
                    <button type="button" class="btn btn-primary" id="btn-sub" ng-click="submit()">
                        Submit
                    </button>
                </div> 
                </form>
                <canvas id="canvas" style="margin-left:50px"></canvas>
            </div>
        <div>

        <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
        <script src="<?= asset('js/Chart.js') ?>"></script>
        <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.min.js') ?>"></script>
        <script src="<?= asset('js/jquery-migrate.min.js') ?>"></script>
        <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
       
        <!-- AngularJS Application Scripts -->
        <script src="<?= asset('app/app.js') ?>"></script>
        <script src="<?= asset('app/controllers/statistik.js') ?>"></script>
    </body>
</html>