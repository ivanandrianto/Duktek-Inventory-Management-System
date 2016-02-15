<!DOCTYPE html>
<html lang="en-US" ng-app="transaksiRecords">
    <head>
        <title>Transaksi</title>

        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= asset('css/ng-quick-date-plus-default-theme.css') ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= asset('css/angularjs-datetime-picker.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?= asset('css/style.css') ?>">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <style type="text/css">
            form.ng-dirty .ng-invalid .quickdate-button {
                border: solid 1px red;
            }
        </style>
    </head>
    <body ng-controller="transaksiController">
        <div class="mycontainer">
            @include('sidebar.sidebar1')
            <div class="content" style="width:900px;height:100%">
                <h2>Transaksi Database</h2>
                <div>

                    <!-- Table-to-load-the-data Part -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Barang</th>
                                <th>ID Peminjam</th>
                                <th>Waktu Pinjam</th>
                                <th>Waktu Rencana Kembali</th>
                                <th>Waktu Kembali</th>
                                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Transaksi</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="transaksi in transaksis">
                                <td><% transaksi.id %></td>
                                <td><% transaksi.id_barang %></td>
                                <td><% transaksi.id_peminjam %></td>
                                <td><% transaksi.waktu_pinjam %></td>
                                <td><% transaksi.waktu_rencana_kembali %></td>
                                <td><% transaksi.waktu_kembali %></td>
                                <td>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', transaksi.id)">Edit</button>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('end', transaksi.id)">Akhiri</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(transaksi.id)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End of Table-to-load-the-data Part -->
                    <!-- Modal (Pop up when detail button clicked) -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><% form_title %></h4>
                                </div>
                                <div class="modal-body">
                                    <% error %>
                                    <form name="frmTransaksi" class="form-horizontal" novalidate="">
                                        <input id="_token" name="_token" type="hidden" value="<?php echo csrf_token(); ?>"
                                        ng-model="transaksi._token">

                                        <div class="form-group error">
                                            <label for="id_peminjam" class="col-sm-3 control-label">ID Peminjam</label>
                                            <div class="col-sm-9">
                                                <input ng-readonly="ro_truefalse" required type="number" class="form-control has-error" id="id_peminjam" name="id_peminjam" placeholder="ID Peminjam" value="<% id_peminjam %>" 
                                                ng-model="transaksi.id_peminjam" ng-required="true">
                                                <span class="help-inline" 
                                                ng-show="frmTransaksi.id_peminjam.$invalid && frmTransaksi.id_peminjam.$touched">Nama field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error jenis_barang">
                                            <label for="jenis_barang" class="col-sm-3 control-label">Jenis Barang</label>
                                            <div class="col-sm-9">
                                                <select ng-disabled="ro_truefalse" class="form-control has-error" id="jenis_barang" name="jenis_barang"  

                                                    ng-init="transaksi.jenis_barang=transaksi.peralatan.jenis"
                                                    ng-model="transaksi.jenis_barang"
                                                    ng-options="peralatan.jenis as peralatan.jenis for peralatan in peralatans" 
                                                    ng-required="true"></select>
                                                <span class="help-inline" 
                                                ng-show="frmTransaksi.jenis_barang.$invalid && frmTransaksi.jenis_barang.$touched">Field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_pinjam">
                                            <label for="waktu_pinjam" class="col-sm-3 control-label">Waktu Pinjam</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_pinjam" id="waktu_pinjam" init-value="waktu_pinjam" ng-model="myDate" ng-required="<% waktu_pinjam_required %>"></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmTransaksi.waktu_pinjam.$invalid && frmTransaksi.waktu_pinjam.$touched">Waktu field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_rencana_kembali">
                                            <label for="waktu_rencana_kembali" class="col-sm-3 control-label">Waktu Rencana Kembali</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_rencana_kembali" id="waktu_rencana_kembali" init-value="waktu_rencana_kembali" ng-model="myDate1" required></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmTransaksi.waktu_rencana_kembali.$invalid && frmTransaksi.waktu_rencana_kembali.$touched">Waktu field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_kembali">
                                            <label for="waktu_kembali" class="col-sm-3 control-label">Waktu Kembali</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_kembali" id="waktu_kembali" init-value="waktu_kembali" ng-model="myDate2"></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmTransaksi.waktu_kembali.$invalid && frmTransaksi.waktu_kembali.$touched">Waktu field is required</span>
                                            </div>
                                        </div>



                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id, '{{ csrf_token() }}')" ng-disabled="frmTransaksi.$invalid">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <% successMessage %>
                                    ID Transaksi: <% saved_transaksi.id %><br>
                                    ID Peralatan: <% saved_transaksi.peralatan.id %><br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-ok" ng-click="ok()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
        <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
        <script src="<?= asset('js/jquery.min.js') ?>"></script>
        <script src="<?= asset('js/jquery-migrate.min.js') ?>"></script>
        <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
        
        <!-- AngularJS Application Scripts -->
        <script src="<?= asset('app/app.js') ?>"></script>
        <script src="<?= asset('app/controllers/transaksi.js') ?>"></script>
        <script src="<?= asset('js/angularjs-datetime-picker.js') ?>"></script>
        <script type="text/javascript" src="<?= asset('js/ng-quick-date.js') ?>"></script>
        <script type='text/javascript'>
            app.config(function(ngQuickDateDefaultsProvider) {
                return ngQuickDateDefaultsProvider.set({
                });
            });
            app.controller("transaksiController", function($scope) {
                $scope.myDate = null;
                $scope.myDate1 = null;
                $scope.myDate2 = null;
                //$scope.setToToday = function() { $scope.myDate = new Date(); }
            });

        </script>

    </body>
</html>