

appPengguna.controller('penggunaController', function($scope, $location, $http, API_URL) {

    var nama = $location.search().nama;
    if(!nama){nama = "";}
    if(nama.length>0){
        $http.get(API_URL + "pengguna/s/" + nama)
        .success(function(response) {
            $scope.penggunas = response;
        });
    } else {
        $http.get(API_URL + "pengguna")
        .success(function(response) {
            $scope.penggunas = response;
        });
    }

    $scope.jenis_list = [
        {"value":"1","name":"Mahasiswa"},
        {"value":"2","name":"Dosen"},
        {"value":"3","name":"Karyawan"}
    ];

    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        $scope.frmPengguna.$setUntouched();
        $scope.error = "";
        switch (modalstate) {
            case 'add':
                $scope.form_title = "Add New Pengguna";
                $scope.pengguna = "";
                break;
            case 'edit':
                $scope.form_title = "Pengguna Detail";
                $scope.id = id;
                $http.get(API_URL + 'pengguna/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.pengguna = response;
                            if($scope.pengguna.jenis == "Mahasiswa"){
                                $scope.pengguna.jenis = "1";
                            } else if($scope.pengguna.jenis == "Dosen") {
                                $scope.pengguna.jenis = "2";
                            } else { // Karyawan
                                $scope.pengguna.jenis = "3";
                            }
                            
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
        var url = API_URL + "pengguna";
        var data = $.param({
            '_token'    : csrf_token,
            'id'        : $scope.pengguna.id,      
            'nama'      : $scope.pengguna.nama,
            'alamat'    : $scope.pengguna.alamat,
            'no_telp'   : $scope.pengguna.no_telp,
            'jenis'     : $scope.pengguna.jenis
        });

        //append pengguna id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.pengguna),
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
                url: API_URL + 'pengguna/' + id
            }).success(function(response) {
                if(response == 1){
                    location.reload();
                } else {
                    alert("Tidak dapat menghapus pengguna");
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
