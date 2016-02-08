
app.controller('peralatanController', function($scope, $http, API_URL) {
    //retrieve peralatan listing from API
    //var token = CSRF_TOKEN;
    //alert("token = " + CSRF_TOKEN);
    $http.get(API_URL + "peralatan")
            .success(function(response) {
                $scope.peralatans = response;
            });
    
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        switch (modalstate) {
            case 'add':
                $scope.form_title = "Add New Peralatan";
                break;
            case 'edit':

                $scope.form_title = "Peralatan Detail";
                $scope.id = id;
                $http.get(API_URL + 'peralatan/' + id)
                        .success(function(response) {
                            console.log(response);
                            $scope.peralatan = response;
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
        alert(csrf_token);
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.peralatan),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            console.log(response);
            location.reload();
        }).error(function(response) {
            console.log(response);
            alert(response);
            alert('Error');
        });
    }

    //delete record
    $scope.confirmDelete = function(id) {
        var isConfirmDelete = confirm('Are you sure you want this record?');
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + 'peralatan/' + id
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
