<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reportList.php">List</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 style="text-align: center;">User List</h1>
        <div class="main">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">Add
                User</button>
            <table id="userTable" class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Address</th>
                        <th>Active</th>
                        <th>Default</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="insertUserForm" method="post">
                            <input type="hidden" class="editUserId" id="editUserId" name="editUserId">
                            <div class="form-group">
                                <label for="userName">User Name:</label>
                                <input type="text" class="form-control userName" id="userName" name="user_name"
                                    placeholder="Enter User Name" required>
                            </div>
                            <div class="form-group">
                                <label for="userAddress">User Address:</label>
                                <textarea class="form-control address" id="address" name="address" rows="3"
                                    placeholder="Enter User Address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="active">Active:</label>
                                <select class="form-control active" id="active" name="active">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="default">Default:</label>
                                <select class="form-control default" id="default" name="default">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
    $(document).ready(function() {
        var table = $('#userTable').DataTable({
            ajax: {
                url: 'fetchUserAll.php',
                type: 'POST',
                dataSrc: ''
            },
            columns: [{
                    data: 'user_id'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'address'
                },
                {
                    data: 'active',
                    render: function(data, type, row) {
                        return data == 1 ? 'Yes' : 'No';
                    }
                },
                {
                    data: 'default',
                    render: function(data, type, row) {
                        return data == 1 ? 'Yes' : 'No';
                    }
                },
                {
                    render: function(data, type, row) {
                        return '<button class="btn btn-info btn-edit mr-2" data-toggle="modal" data-target="#addUserModal" data-id="' +
                            row.user_id + '">Edit</button>' +
                            '<button class="btn btn-danger btn-delete" data-id="' + row
                            .user_id + '">Delete</button>';
                    }
                }
            ]
        });

        // Add User button
        $('#addUserModal').on('show.bs.modal', function() {
            $('#insertUserForm')[0].reset();
        });

        // edit button click
        $('#userTable tbody').on('click', '.btn-edit', function() {
            var userId = $(this).data('id');

            $.ajax({
                url: 'fetchUser.php',
                type: 'GET',
                data: {
                    userId: userId
                },
                success: function(response) {
                    var userData = JSON.parse(response);
                    $('#addUserModal').modal('show');
                    $('#addUserModalLabel').text('Edit User');
                    $('#submit').text('Update').val('Update');
                    $('.editUserId').val(userData.user_id);
                    $('.userName').val(userData.user_name);
                    $('.address').val(userData.address);
                    $('.active').val(userData.active);
                    $('.default').val(userData.default);
                }
            });
        });


        // delete button click
        $('#userTable tbody').on('click', '.btn-delete', function() {
            var userId = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'deleteUser.php',
                    type: 'POST',
                    data: {
                        userId: userId
                    },
                    success: function(response) {
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('An error occurred while deleting the user.');
                    }
                });
            }
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <?php
include("connection.php");

if(isset($_POST['submit'])) {
    $editUserId = $_POST['editUserId']; 
    $user_name = $_POST['user_name'];
    $address = $_POST['address'];
    $active = $_POST['active'];
    $default = $_POST['default'];

    if($editUserId == ''){
        $insertUser = "INSERT INTO user (user_name, active) VALUES ('$user_name', '$active')";
        $ress = mysqli_query($conn, $insertUser);
        $user_id = mysqli_insert_id($conn);

        $insertAddress = "INSERT INTO address (user_id, address, `default`) VALUES ('$user_id', '$address', '$default')";
        $res = mysqli_query($conn, $insertAddress);
        
    } else {
        $updateUser = "UPDATE user SET user_name = '$user_name', active = '$active' WHERE user_id = '$editUserId'";
        $ress = mysqli_query($conn, $updateUser);

        $updateAddress = "UPDATE address SET address = '$address', `default` = '$default' WHERE user_id = '$editUserId'";
        $res = mysqli_query($conn, $updateAddress);
    }
}
?>

</body>

</html>