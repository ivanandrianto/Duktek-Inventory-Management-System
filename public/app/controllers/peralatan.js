
appPeralatan.controller('peralatanController', function($scope, $location, $http, API_URL) {

    var jenis = $location.search().jenis;
    if(!jenis){jenis = "";}
    if(jenis.length>0){
        $http.get(API_URL + "peralatan/s/" + jenis)
        .success(function(response) {
            $scope.peralatans = response;
        });
    } else {
        $http.get(API_URL + "peralatan")
        .success(function(response) {
            $scope.peralatans = response;
        });
    }
    
    $scope.ketersediaan_list = [
        {"value":"1","name":"Tersedia"},
        {"value":"0","name":"Sedang Digunakan"}
    ];

    $scope.status_list = [
        {"value":"1","name":"Baik"},
        {"value":"0","name":"Rusak"},
        {"value":"2","name":"Perbaikan"}
    ];

    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        $scope.error = "";
        switch (modalstate) {
            case 'add':
                $scope.form_title = "Add New Peralatan";
                $scope.peralatan = "";
                break;
            case 'edit':

                $scope.form_title = "Peralatan Detail";
                $scope.id = id;
                $http.get(API_URL + 'peralatan/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.peralatan = response;
                            if($scope.peralatan.ketersediaan == "Tersedia"){
                                $scope.peralatan.ketersediaan = "1";
                            } else {
                                $scope.peralatan.ketersediaan = "0";
                            }
                            if($scope.peralatan.status == "Rusak"){
                                $scope.peralatan.status = "0";
                            } else if($scope.peralatan.status == "Baik") {
                                $scope.peralatan.status = "1";
                            } else {
                                $scope.peralatan.status = "2";
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
        var url = API_URL + "peralatan";
        var data = $.param({
            '_token' : csrf_token,
            'nama' : $scope.peralatan.nama,
            'jenis' : $scope.peralatan.jenis,
            'lokasi' : $scope.peralatan.lokasi,
            'ketersediaan' : $scope.peralatan.ketersediaan,
            'status' : $scope.peralatan.status
        });

        //append peralatan id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/" + id;
        }
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.peralatan),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
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
                url: API_URL + 'peralatan/' + id
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
