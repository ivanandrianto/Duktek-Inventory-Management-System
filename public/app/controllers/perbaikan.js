
appPerbaikan.controller('perbaikanController', function($scope, $http, API_URL) {
    //retrieve perbaikan listing from API
    //var token = CSRF_TOKEN;
    //alert("token = " + CSRF_TOKEN);
    $http.get(API_URL + "perbaikan")
            .success(function(response) {
                $scope.perbaikans = response;
            });

    $http.get(API_URL + "peralatan")
            .success(function(response) {
                $scope.peralatans = response;
            });

    var datetime_offset = 7*60*60000;
    $scope.gila = "2016-01-01 01:02:03";
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        $scope.frmPerbaikan.$setUntouched();
        $scope.error = "";
        switch (modalstate) {
            case 'add':
                $scope.form_title = "Buat Perbaikan";
                $scope.perbaikan = "";
                $scope.myDate = "";
                $('.waktu_mulai').show();
                $('.waktu_selesai').hide();
                break;
            case 'end':
                $scope.form_title = "Akhiri Perbaikan";
                $scope.id = id;
                $scope.myDate2 = "";
                $('.waktu_mulai').hide();
                $('.waktu_selesai').show();
                $http.get(API_URL + 'perbaikan/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.perbaikan = response;
                            $scope.myDate2 = new Date(Date.parse($scope.perbaikan.waktu_selesai.replace('-','/','g')));
                        });
                break;
            case 'edit':
                alert();
                $('.waktu_selesai').show();
                $('.waktu_mulai').show();
                $scope.form_title = "Perbaikan Detail";
                $scope.id = id;
                $http.get(API_URL + 'perbaikan/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.perbaikan = response;
                            $scope.myDate = new Date(Date.parse($scope.perbaikan.waktu_mulai.replace('-','/','g')));
                            $scope.myDate2 = new Date(Date.parse($scope.perbaikan.waktu_selesai.replace('-','/','g')));
                        });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
    }

    $scope.ok = function() {
        location.reload();
    }

    //save new record / update existing record
    $scope.save = function(modalstate, id, csrf_token) {
        var url = API_URL + "perbaikan";
        var data = $.param({
            '_token' : csrf_token,
            'id_barang' : $scope.perbaikan.id_barang,
            'waktu_mulai' : $scope.perbaikan.waktu_mulai,
            'waktu_selesai' : $scope.perbaikan.waktu_selesai,
        });
        alert($scope.perbaikan.id_barang);
        var date;
        date = new Date($scope.myDate);
        date = new Date(date.getTime() + datetime_offset);
        date = date.getUTCFullYear() + '-' +
            ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
            ('00' + date.getUTCDate()).slice(-2) + ' ' + 
            ('00' + date.getUTCHours()).slice(-2) + ':' + 
            ('00' + date.getUTCMinutes()).slice(-2) + ':' + 
            ('00' + date.getUTCSeconds()).slice(-2);
        $scope.perbaikan.waktu_mulai = date;

        var date2;
        date2 = new Date($scope.myDate2);
        date2 = new Date(date2.getTime() + datetime_offset);
        date2 = date2.getUTCFullYear() + '-' +
            ('00' + (date2.getUTCMonth()+1)).slice(-2) + '-' +
            ('00' + date2.getUTCDate()).slice(-2) + ' ' + 
            ('00' + date2.getUTCHours()).slice(-2) + ':' + 
            ('00' + date2.getUTCMinutes()).slice(-2) + ':' + 
            ('00' + date2.getUTCSeconds()).slice(-2);
        $scope.perbaikan.waktu_selesai = date2;
        //append perbaikan id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/" + id;
        } else if(modalstate === 'end'){
            url += "/end/" + id;
        }
        alert(csrf_token);
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.perbaikan),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            console.log(response);
            if(response == 1){
                $('#myModal').modal('hide');
                if (modalstate === 'edit'){
                    $scope.successMessage = "Data berhasil diupdate";
                } else {
                    $scope.successMessage = "Data berhasil disimpan";
                }
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

    //delete record
    $scope.confirmDelete = function(id) {
        var isConfirmDelete = confirm('Apakah Anda yakin ingin menghapus record ini?');
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + 'perbaikan/' + id
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
