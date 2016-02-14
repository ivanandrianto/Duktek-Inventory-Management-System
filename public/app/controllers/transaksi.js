
appTransaksi.controller('transaksiController', function($scope, $http, API_URL) {
    //retrieve transaksi listing from API
    //var token = CSRF_TOKEN;
    //alert("token = " + CSRF_TOKEN);
    $http.get(API_URL + "transaksi")
            .success(function(response) {
                $scope.transaksis = response;
            });

    $http.get(API_URL + "peralatan")
            .success(function(response) {
                $scope.peralatans = response;
            });
    $scope.waktu_pinjam_required = false;
    $scope.ro_truefalse = false;
    //alert(peralatans[0][0]);
    var datetime_offset = 7*60*60000;

    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        $scope.error = "";
        switch (modalstate) {
            case 'add':
                $scope.waktu_pinjam_required = false;
                $scope.ro_truefalse = false;
                $scope.form_title = "Buat Transaksi";
                $scope.transaksi = "";
                $scope.myDate = "";
                $scope.myDate1 = "";
                $('.waktu_pinjam').hide();
                $('.waktu_rencana_kembali').show();
                $('.waktu_kembali').hide();
                break;
            case 'end':
                $scope.waktu_pinjam_required = true;
                $scope.ro_truefalse = true;
                $scope.form_title = "Tekan OK untuk mengakhiri transaksi";
                $scope.id = id;
                $scope.myDate2 = "";
                $('.waktu_pinjam').hide();
                $('.waktu_rencana_kembali').hide();
                $('.waktu_kembali').hide();
                $http.get(API_URL + 'transaksi/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.transaksi = response;
                            $scope.myDate2 = "";
                            $scope.transaksi.jenis_barang = $scope.transaksi.peralatan.jenis
                        });
                break;
            case 'edit':
                $scope.waktu_pinjam_required = true;
                $scope.ro_truefalse = false;
                $('.waktu_kembali').show();
                $('.waktu_pinjam').show();
                $scope.form_title = "Transaksi Detail";
                $scope.id = id;
                //$transaksi.jenis_barang = 
                $http.get(API_URL + 'transaksi/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.transaksi    = response;
                            $scope.myDate       = new Date(Date.parse($scope.transaksi.waktu_pinjam.replace('-','/','g')));
                            $scope.myDate1      = new Date(Date.parse($scope.transaksi.waktu_rencana_kembali.replace('-','/','g')));
                            $scope.myDate2      = new Date(Date.parse($scope.transaksi.waktu_kembali.replace('-','/','g')));
                            $scope.transaksi.jenis_barang = $scope.transaksi.peralatan.jenis
                            //alert($scope.transaksi.peralatan.jenis);
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
        var url = API_URL + "transaksi";
        var data = $.param({
            '_token' : csrf_token,
            'id_barang' : $scope.transaksi.id_barang,
            'id_peminjam' : $scope.transaksi.id_peminjam,
            'waktu_pinjam' : $scope.transaksi.waktu_pinjam,
            'waktu_rencana_kembali' : $scope.transaksi.waktu_rencana_kembali,
            'waktu_kembali' : $scope.transaksi.waktu_kembali
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
        $scope.transaksi.waktu_pinjam = date;

        var date1;
        date1 = new Date($scope.myDate1);
        date1 = new Date(date1.getTime() + datetime_offset);
        date1 = date1.getUTCFullYear() + '-' +
            ('00' + (date1.getUTCMonth()+1)).slice(-2) + '-' +
            ('00' + date1.getUTCDate()).slice(-2) + ' ' + 
            ('00' + date1.getUTCHours()).slice(-2) + ':' + 
            ('00' + date1.getUTCMinutes()).slice(-2) + ':' + 
            ('00' + date1.getUTCSeconds()).slice(-2);
        $scope.transaksi.waktu_rencana_kembali = date1;
        

        var date2;
        date2 = new Date($scope.myDate2);
        date2 = new Date(date2.getTime() + datetime_offset);
        date2 = date2.getUTCFullYear() + '-' +
            ('00' + (date2.getUTCMonth()+1)).slice(-2) + '-' +
            ('00' + date2.getUTCDate()).slice(-2) + ' ' + 
            ('00' + date2.getUTCHours()).slice(-2) + ':' + 
            ('00' + date2.getUTCMinutes()).slice(-2) + ':' + 
            ('00' + date2.getUTCSeconds()).slice(-2);
        $scope.transaksi.waktu_kembali = date2;
        
        //append transaksi id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/" + id;
        } else if(modalstate === 'end'){
            url += "/end/" + id;
        }
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.transaksi),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            console.log(response);
            alert(response);
            if(response >= 1){
                $('#myModal').modal('hide');
                if (modalstate === 'edit'){
                    $scope.successMessage = "Data berhasil diupdate";
                } else {
                    $scope.successMessage = "Data berhasil disimpan";
                }

                $http.get(API_URL + 'transaksi/' + response)
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
                //location.reload();
            } else {
                $scope.error = response;
            }
        }).error(function(response) {
            console.log(response);
            alert(response);
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
                url: API_URL + 'transaksi/' + id
            }).success(function(response) {
                console.log(response);
                location.reload();
            }).error(function(response) {
                console.log(response);
                alert(response);
                alert('Error');
            });
        } else {
            return false;
        }
    }
});
