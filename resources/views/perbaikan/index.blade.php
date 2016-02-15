<!DOCTYPE html>
<html lang="en-US" ng-app="perbaikanRecords">
    <head>
        <title>Perbaikan</title>

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
    <body>
        <div class="mycontainer">
            @include('sidebar.sidebar1')
            <div class="content" style="width:900px;height:100%">
                <h2>Perbaikan Database</h2>
                <div  ng-controller="perbaikanController">

                    <!-- Table-to-load-the-data Part -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Barang</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Perbaikan</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="perbaikan in perbaikans">
                                <td><% perbaikan.id %></td>
                                <td><% perbaikan.peralatan.nama %></td>
                                <td><% perbaikan.waktu_mulai %></td>
                                <td><% perbaikan.waktu_selesai %></td>
                                <td>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', perbaikan.id)">Edit</button>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('end', perbaikan.id)">Akhiri</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(perbaikan.id)">Delete</button>
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
                                    <form name="frmPerbaikan" class="form-horizontal" novalidate="">
                                        <input id="_token" name="_token" type="hidden" value="<?php echo csrf_token(); ?>"
                                        ng-model="perbaikan._token">

                                        <div class="form-group error">
                                            <label for="id_barang" class="col-sm-3 control-label">Nama Barang</label>
                                            <div class="col-sm-9">
                                                
                                                <select class="form-control has-error" id="id_barang" name="id_barang"  
                                                    ng-model="perbaikan.id_barang"
                                                    ng-options="peralatan.id as peralatan.nama for peralatan in peralatans" 
                                                    ng-required="true"></select>
                                                <span class="help-inline" 
                                                ng-show="frmPerbaikan.id_barang.$invalid && frmPerbaikan.id_barang.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_mulai">
                                            <label for="waktu_mulai" class="col-sm-3 control-label">Waktu Mulai</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_mulai" id="waktu_mulai" init-value="waktu_mulai" ng-model="myDate" required></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmPerbaikan.waktu_mulai.$invalid && frmPerbaikan.waktu_mulai.$touched">Waktu field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_selesai">
                                            <label for="waktu_selesai" class="col-sm-3 control-label">Waktu Selesai</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_selesai" id="waktu_selesai" init-value="waktu_selesai" ng-model="myDate2" required></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmPerbaikan.waktu_selesai.$invalid && frmPerbaikan.waktu_selesai.$touched">Waktu field is required</span>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id, '{{ csrf_token() }}')" ng-disabled="frmPerbaikan.$invalid">Save changes</button>
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
        <script src="<?= asset('app/controllers/perbaikan.js') ?>"></script>
        <script src="<?= asset('js/angularjs-datetime-picker.js') ?>"></script>
        <script type="text/javascript" src="<?= asset('js/ng-quick-date.js') ?>"></script>
        <script type='text/javascript'>
            app.config(function(ngQuickDateDefaultsProvider) {
                return ngQuickDateDefaultsProvider.set({
                });
            });
            app.controller("perbaikanController", function($scope) {
                $scope.myDate = null;
                $scope.myDate2 = null;
                $scope.gila = "2016-01-01 01:02:03";
                //$scope.setToToday = function() { $scope.myDate = new Date(); }
            });

        </script>

    </body>
</html>