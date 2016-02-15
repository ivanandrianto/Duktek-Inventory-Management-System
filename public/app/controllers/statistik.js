
appStatistik.controller('statistikController', function($scope, $http, API_URL) {
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

    
});
