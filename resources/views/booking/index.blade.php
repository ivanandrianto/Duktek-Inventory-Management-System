<!DOCTYPE html>
<html lang="en-US" ng-app="bookingRecords">
    <head>
        <!-- Load Bootstrap CSS -->
        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= asset('css/ng-quick-date-plus-default-theme.css') ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= asset('css/angularjs-datetime-picker.css') ?>"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <style type="text/css">
            form.ng-dirty .ng-invalid .quickdate-button {
border: solid 1px red;
            }
        </style>
    </head>
    <body ng-controller="bookingController">
        <div class="mycontainer">
            @include('sidebar.sidebar1')
            <div class="content" style="width:900px;height:100%">
                <h2>Booking Database</h2>
                <div>

                    <!-- Table-to-load-the-data Part -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Barang</th>
                                <th>ID Pembooking</th>
                                <th>Waktu Booking Mulai</th>
                                <th>Waktu Booking Selesai</th>
                                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Booking</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="booking in bookings">
                                <td><% booking.id %></td>
                                <td><% booking.id_barang %></td>
                                <td><% booking.id_pembooking %></td>
                                <td><% booking.waktu_booking_mulai %></td>
                                <td><% booking.waktu_booking_selesai %></td>
                                <td>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', booking.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(booking.id)">Delete</button>
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
                                    <form name="frmBooking" class="form-horizontal" novalidate="">
                                        <input id="_token" name="_token" type="hidden" value="<?php echo csrf_token(); ?>"
                                        ng-model="booking._token">

                                        <div class="form-group error">
                                            <label for="id_pembooking" class="col-sm-3 control-label">ID Pembooking</label>
                                            <div class="col-sm-9">
                                                <input ng-readonly="ro_truefalse" required type="number" class="form-control has-error" id="id_pembooking" name="id_pembooking" placeholder="ID Pembooking" value="<% id_peminjam %>" 
                                                ng-model="booking.id_pembooking" ng-required="true">
                                                <span class="help-inline" 
                                                ng-show="frmBooking.id_pembooking.$invalid && frmBooking.id_pembooking.$touched">Nama field is required</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group error jenis_barang">
                                            <label for="jenis_barang" class="col-sm-3 control-label">Jenis Barang</label>
                                            <div class="col-sm-9">
                                                <select ng-disabled="ro_truefalse" class="form-control has-error" id="jenis_barang" name="jenis_barang"
                                                    ng-init="booking.jenis_barang=booking.peralatan.jenis"
                                                    ng-model="booking.jenis_barang"
                                                    ng-options="peralatan.jenis as peralatan.jenis for peralatan in peralatans" 
                                                    ng-required="true"></select>
                                                <span class="help-inline" 
                                                ng-show="frmBooking.jenis_barang.$invalid && frmBooking.jenis_barang.$touched">Field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_booking_mulai">
                                            <label for="waktu_booking_mulai" class="col-sm-3 control-label">Waktu Booking Mulai</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_mulai" id="waktu_booking_mulai" init-value="waktu_booking_mulai" ng-model="myDate" required></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmBooking.waktu_booking_mulai.$invalid && frmBooking.waktu_booking_mulai.$touched">Waktu field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group error waktu_booking_selesai">
                                            <label for="waktu_booking_selesai" class="col-sm-3 control-label">Waktu Booking Selesai</label>
                                            <div class="col-sm-9">
                                                <quick-datepicker type="text" name="waktu_booking_selesai" id="waktu_booking_selesai" init-value="waktu_booking_selesai" ng-model="myDate2" required></quick-datepicker>
                                                <span class="help-inline" 
                                                ng-show="frmBooking.waktu_booking_selesai.$invalid && frmBooking.waktu_booking_selesai.$touched">Waktu field is required</span>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id, '{{ csrf_token() }}')" ng-disabled="frmBooking.$invalid">Save changes</button>
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
                                    ID Booking: <% saved_booking.id %><br>
                                    ID Peralatan: <% saved_booking.peralatan.id %><br>
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
        <script src="<?= asset('app/controllers/booking.js') ?>"></script>
        <script src="<?= asset('js/angularjs-datetime-picker.js') ?>"></script>
        <script type="text/javascript" src="<?= asset('js/ng-quick-date.js') ?>"></script>
        <script type='text/javascript'>
            app.config(function(ngQuickDateDefaultsProvider) {
                return ngQuickDateDefaultsProvider.set({
                });
            });
            app.controller("bookingController", function($scope) {
                $scope.myDate = null;
                $scope.myDate2 = null;
                //$scope.setToToday = function() { $scope.myDate = new Date(); }
            });

        </script>

    </body>
</html>