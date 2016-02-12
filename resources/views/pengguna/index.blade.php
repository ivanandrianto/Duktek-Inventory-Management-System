<!DOCTYPE html>
<html lang="en-US" ng-app="penggunaRecords">
    <head>
        <title>Pengguna</title>

        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script>angular.module("penggunaRecords").constant("CSRF_TOKEN", '{{ csrf_token() }}');</script>
    </head>
    <body>
        <h2>Pengguna Database</h2>
        <div  ng-controller="penggunaController">

            <!-- Table-to-load-the-data Part -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Jenis</th>
                        <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Pengguna</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="pengguna in penggunas">
                        <td><% pengguna.id %></td>
                        <td><% pengguna.nama %></td>
                        <td><% pengguna.no_telp %></td>
                        <td><% pengguna.alamat %></td>
                        <td><% pengguna.jenis %></td>
                        <td>
                            <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', pengguna.id)">Edit</button>
                            <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(pengguna.id)">Delete</button>
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
                            <form name="frmPengguna" class="form-horizontal" novalidate="">
                                <input id="_token" name="_token" type="hidden" value="<?php echo csrf_token(); ?>"
                                ng-model="pengguna._token">

                                <div class="form-group error">
                                    <label for="id" class="col-sm-3 control-label">ID</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control has-error" id="id" name="id" placeholder="ID" value="<% id %>" 
                                        ng-model="pengguna.id" >
                                        <span class="help-inline" 
                                        ng-show="frmPengguna.id.$invalid && frmPengguna.id.$touched">Nama field is required</span>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="nama" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input required type="text" class="form-control has-error" id="nama" name="nama" placeholder="Nama" value="<% nama %>" 
                                        ng-model="pengguna.nama" ng-required="true">
                                        <span class="help-inline" 
                                        ng-show="frmPengguna.nama.$invalid && frmPengguna.nama.$touched">Nama field is required</span>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <input required type="text" class="form-control has-error" id="alamat" name="alamat" placeholder="Alamat" value="<% alamat %>" 
                                        ng-model="pengguna.alamat" ng-required="true">
                                        <span class="help-inline" 
                                        ng-show="frmPengguna.alamat.$invalid && frmPengguna.alamat.$touched">Alamat field is required</span>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="no_telp" class="col-sm-3 control-label">No_telp</label>
                                    <div class="col-sm-9">
                                        <input required type="text" class="form-control has-error" id="no_telp" name="no_telp" placeholder="No. Telp" value="<% no_telp %>" 
                                        ng-model="pengguna.no_telp" ng-required="true">
                                        <span class="help-inline" 
                                        ng-show="frmPengguna.no_telp.$invalid && frmPengguna.no_telp.$touched">Name field is required</span>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="Jenis" class="col-sm-3 control-label">Jenis</label>
                                    <div class="col-sm-9">
                                        <select class="form-control has-error" id="jenis" name="jenis" 
                                            ng-init="pengguna.jenis=jenis_list[0]['value']"
                                            ng-model="pengguna.jenis"
                                            ng-options="x.value as x.name for x in jenis_list" 
                                        >
                                        </select>
                                        <span class="help-inline" 
                                        ng-show="frmPengguna.jenis.$invalid && frmPengguna.jenis.$touched">Jenis field is required</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id, '{{ csrf_token() }}')" ng-disabled="frmPengguna.$invalid">Save changes</button>
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
        <script src="<?= asset('app/controllers/pengguna.js') ?>"></script>
    </body>
</html>