
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

    $scope.ro_truefalse = false;
    //alert(peralatans[0][0]);
    var datetime_offset = 7*60*60000;

    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        $scope.error = "";
        switch (modalstate) {
            case 'add':
                $scope.ro_truefalse = false;
                $scope.form_title = "Buat Transaksi";
                $scope.transaksi = "";
                $scope.myDate = "";
                $scope.myDate1 = "";
                $('.waktu_pinjam').show();
                $('.waktu_rencana_kembali').show();
                $('.waktu_kembali').hide();
                break;
            case 'end':
                $scope.ro_truefalse = true;
                $scope.form_title = "Akhiri Transaksi";
                $scope.id = id;
                $scope.myDate2 = "";
                $('.waktu_pinjam').hide();
                $('.waktu_rencana_kembali').hide();
                $('.waktu_kembali').show();
                $http.get(API_URL + 'transaksi/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.transaksi = response;
                            $scope.myDate2 = "";
                        });
                break;
            case 'edit':
                $scope.ro_truefalse = false;
                $('.waktu_kembali').show();
                $('.waktu_pinjam').show();
                $scope.form_title = "Transaksi Detail";
                $scope.id = id;
                $http.get(API_URL + 'transaksi/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.transaksi    = response;
                            $scope.myDate       = $scope.transaksi.waktu_pinjam;
                            $scope.myDate1      = $scope.transaksi.waktu_rencana_kembali;
                            $scope.myDate2      = $scope.transaksi.waktu_kembali;
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
        alert(url); 
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.transaksi),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            console.log(response);
            if(response == 1){
                location.reload();
            } else {
                $scope.error = response;
            }
        }).error(function(response) {
            console.log(response);
            alert(response);
            alert('Error');
        });
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
