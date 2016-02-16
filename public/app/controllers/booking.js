
appBooking.controller('bookingController', function($scope, $http, API_URL) {

    $http.get(API_URL + "booking")
            .success(function(response) {
                $scope.bookings = response;
            });

    $http.get(API_URL + "peralatan")
            .success(function(response) {
                $scope.peralatans = response;
            });

    $scope.ro_truefalse = false;
    var datetime_offset = 7*60*60000;

    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        $scope.error = "";
        switch (modalstate) {
            case 'add':
                $scope.ro_truefalse = false;
                $scope.form_title = "Buat Booking";
                $scope.booking = "";
                $scope.myDate = "";
                $scope.myDate2 = "";
                break;
            case 'edit':
                $scope.ro_truefalse = false;
                $('.waktu_booking_mulai').show();
                $('.waktu_booking_selesai').show();
                $scope.form_title = "Booking Detail";
                $scope.id = id;
                $http.get(API_URL + 'booking/' + id)
                    .success(function(response) {
                        console.log(response);
                        $scope.booking      = response;
                        $scope.myDate       = new Date(Date.parse($scope.booking.waktu_booking_mulai.replace('-','/','g')));
                        $scope.myDate2      = new Date(Date.parse($scope.booking.waktu_booking_selesai.replace('-','/','g')));
                        $scope.booking.jenis_barang = $scope.booking.peralatan.jenis
                    });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id, csrf_token) {
        var url = API_URL + "booking";
        var data = $.param({
            '_token' : csrf_token,
            'id_barang' : $scope.booking.id_barang,
            'id_pembooking' : $scope.booking.id_pembooking,
            'waktu_booking_mulai' : $scope.booking.waktu_booking_mulai,
            'waktu_booking_selesai' : $scope.booking.waktu_booking_selesai
        });
        
        var date;
        date = new Date($scope.myDate);
        date = new Date(date.getTime() + datetime_offset);
        date = date.getUTCFullYear() + '-' +
            ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
            ('00' + date.getUTCDate()).slice(-2) + ' ' + 
            ('00' + date.getUTCHours()).slice(-2) + ':' + 
            ('00' + date.getUTCMinutes()).slice(-2) + ':' + 
            ('00' + date.getUTCSeconds()).slice(-2);
        $scope.booking.waktu_booking_mulai = date;
     

        var date2;
        date2 = new Date($scope.myDate2);
        date2 = new Date(date2.getTime() + datetime_offset);
        date2 = date2.getUTCFullYear() + '-' +
            ('00' + (date2.getUTCMonth()+1)).slice(-2) + '-' +
            ('00' + date2.getUTCDate()).slice(-2) + ' ' + 
            ('00' + date2.getUTCHours()).slice(-2) + ':' + 
            ('00' + date2.getUTCMinutes()).slice(-2) + ':' + 
            ('00' + date2.getUTCSeconds()).slice(-2);
        $scope.booking.waktu_booking_selesai = date2;
        
        //append booking id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/" + id;
        } else if(modalstate === 'end'){
            url += "/end/" + id;
        }
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.booking),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            if(response >= 1){
                $('#myModal').modal('hide');
                if (modalstate === 'edit'){
                    $scope.successMessage = "Data berhasil diupdate";
                } else {
                    $scope.successMessage = "Data berhasil disimpan";
                }

                $http.get(API_URL + 'booking/' + response)
                .success(function(response) {
                    $scope.saved_transaksi    = response;
                });

                $('#successModal').modal({
                    backdrop: 'static',
                    keyboard: false  // to prevent closing with Esc button (if you want this too)
                })
                $('#successModal').on('hidden.bs.modal', function () {
                    location.reload();
                })
                $('#successModal').modal('show');
            } else {
                $scope.error = response;
            }
        }).error(function(response) {
            console.log(response);
            alert('Error');
        });
    }

    $scope.ok = function() {
        location.reload();
    }

    //delete record
    $scope.confirmDelete = function(id) {
        var isConfirmDelete = confirm('Apakah Anda yakin ingin menghapus record ini?');
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + 'booking/' + id
            }).success(function(response) {
                if(response == 1){
                    location.reload();
                } else {
                    alert("Tidak dapat menghapus");
                }
            }).error(function(response) {
                console.log(response);
                alert('Error');
            });
        } else {
            return false;
        }
    }
});
