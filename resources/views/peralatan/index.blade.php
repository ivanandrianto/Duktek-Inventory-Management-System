<!DOCTYPE html>
<html lang="en-US" ng-app="peralatanRecords">
    <head>
        <title>Peralatan</title>

        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= asset('css/style.css') ?>">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>angular.module("peralatanRecords").constant("CSRF_TOKEN", '{{ csrf_token() }}');</script>
    </head>
    <body ng-controller="peralatanController">
        <div class="mycontainer">
            @include('sidebar.sidebar1')
            <div class="content" style="width:900px;height:100%">
                <h2>Peralatan</h2>
                <form name="searchPengguna" method="GET" action="">
                    <input class="search-input" type="text" name="jenis">
                    <input class="btn btn-primary" type="submit" value="Search">
                </form>
                <div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Ketersediaan</th>
                                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Peralatan</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="peralatan in peralatans">
                                <td><% peralatan.id %></td>
                                <td><% peralatan.nama %></td>
                                <td><% peralatan.jenis %></td>
                                <td><% peralatan.lokasi %></td>
                                <td><% peralatan.status %></td>
                                <td><% peralatan.ketersediaan %></td>
                                <td>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', peralatan.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(peralatan.id)">Delete</button>
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
                                    <form name="frmPeralatan" class="form-horizontal" novalidate="">
                                        <input id="_token" name="_token" type="hidden" value="<?php echo csrf_token(); ?>"
                                        ng-model="peralatan._token">

                                        <div class="form-group error">
                                            <label for="nama" class="col-sm-3 control-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input required type="text" class="form-control has-error" id="nama" name="nama" placeholder="Nama" value="<% nama %>" 
                                                ng-model="peralatan.nama" ng-required="true">
                                                <span class="help-inline" 
                                                ng-show="frmPeralatan.nama.$invalid && frmPeralatan.nama.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error">
                                            <label for="Jenis" class="col-sm-3 control-label">Jenis</label>
                                            <div class="col-sm-9">
                                                <input required type="text" class="form-control has-error" id="jenis" name="jenis" placeholder="Jenis" value="<% jenis %>" 
                                                ng-model="peralatan.jenis" ng-required="true">
                                                <span class="help-inline" 
                                                ng-show="frmPeralatan.jenis.$invalid && frmPeralatan.jenis.$touched">Jenis field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error">
                                            <label for="lokasi" class="col-sm-3 control-label">Lokasi</label>
                                            <div class="col-sm-9">
                                                <input required type="text" class="form-control has-error" id="lokasi" name="lokasi" placeholder="Lokasi" value="<% lokasi %>" 
                                                ng-model="peralatan.lokasi" ng-required="true">
                                                <span class="help-inline" 
                                                ng-show="frmPeralatan.lokasi.$invalid && frmPeralatan.lokasi.$touched">Lokasi field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error">
                                            <label for="ketersediaan" class="col-sm-3 control-label">Ketersediaan</label>
                                            <div class="col-sm-9">
                                                <select class="form-control has-error" id="ketersediaan" name="ketersediaan" 
                                                
                                                    ng-init="peralatan.ketersediaan=ketersediaan_list[0]['value']"
                                                    ng-model="peralatan.ketersediaan"
                                                    ng-options="x.value as x.name for x in ketersediaan_list" 
                                                >
                                                </select>
                                                
                                                <span class="help-inline" 
                                                ng-show="frmPeralatan.ketersediaan.$invalid && frmPeralatan.ketersediaan.$touched">Ketersediaan field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error">
                                            <label for="status" class="col-sm-3 control-label">Status</label>
                                            <div class="col-sm-9">
                                                <select required class="form-control has-error" id="status" name="status" placeholder="Status" value="<% status %>" 
                                                ng-model="peralatan.status" ng-required="true">
                                                    <option value="1">Baik</option>
                                                    <option value="0">Rusak</option>
                                                    <option value="2">Perbaikan</option>
                                                </select>
                                                <span class="help-inline" 
                                                ng-show="frmPeralatan.status.$invalid && frmPeralatan.status.$touched">Status field is required</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id, '{{ csrf_token() }}')" ng-disabled="frmPeralatan.$invalid">Save changes</button>
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
        <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
        
        <!-- AngularJS Application Scripts -->
        <script src="<?= asset('app/app.js') ?>"></script>
        <script src="<?= asset('app/controllers/peralatan.js') ?>"></script>
    </body>
</html>