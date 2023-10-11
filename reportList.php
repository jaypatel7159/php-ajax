<?php 
include("connection.php");

$sql = "SELECT user.user_name, address.address
FROM user
INNER JOIN address ON user.user_id = address.user_id
WHERE address.default = '1' AND user.active = '1'";

$result = $conn->query($sql);

?>
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
        <h1 style="text-align: center;">Report List</h1>
        <div class="main">
            <table class="table" id="userTable">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        var table = $('#userTable').DataTable({
    ajax: {
        url: 'fetchUser.php',
        type: 'GET',
        dataSrc: '',
        error: function(xhr, error, thrown) {
            console.error('DataTables error:', error, thrown);
        }
    },
    columns: [
        { data: 'user_id' },
        { data: 'user_name' },
        { data: 'address' }
    ]
});

    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>