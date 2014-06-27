<?php

//Added Here After Initialize

//

//Comment added and updated and deleted


// Start Validation For Login
session_start();
if(isset($_SESSION['LOGIN'])==false)
{
    header("Location: login.php");
}
else
{
    if($_SESSION['LOGIN']=="NO")
    {
        header("Location: login.php");
    }
}
// End Validation For Login

$name = 0;
if ( !empty($_POST))
{
    // keep track validation errors
    $nameError = null;

    // keep track post values
    $name = $_POST['name'];
    $_SESSION['INPUTNAME'] = $name;
//    if(!empty($_POST['name']))
//    {
//        $name = $_POST['name'];
//    }

    // validate input
    $valid = true;
    if (empty($name)) {
    $nameError = 'Please enter Name';
    $valid = false;
    }
}
else
{
    if(isset($_SESSION['INPUTNAME'])==true)
    {
        $name = $_SESSION['INPUTNAME'];
    }
//    if ( !empty($_GET['name']))
//    {
//        $name = $_REQUEST['name'];
//    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container-fluid">

    <form class="form-horizontal" action="index.php" method="post">
        <p>

        </p>
        <div class="row pull-right">
            <a href="logout.php" class="btn btn-danger">[  Log Out  ]</a>
        </div>
        <div class="row">
            <h3>Information</h3>
        </div>
        <div class="row">
            <p>

            </p>
            <p>
                <a href="create.php" class="btn btn-success">[  Add New  ]</a>
            </p>

            <p>
                <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                    <input id="name" name="name" placeholder="Enter Name" class="input-xlarge" required="" type="text">
                </div>
            </div>

            <!-- Button -->
            <div class="control-group">
                <label class="control-label" for="search"></label>
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>

            </p>
<!--            <table class="table table-striped table-bordered">-->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Name</th>
                    <th>Established</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Company Nature</th>
                    <th>Business Type</th>
                    <th>Size</th>
                    <th>Specialities</th>
                    <th>Review</th>
                    <th>URL</th>

                </tr>
                </thead>
                <tbody>
                <?php
                include 'database.php';
                $pdo = Database::connect();




                $sql = 'SELECT * FROM global WHERE name like ' . '\'%'. $name .'%\'';


                foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td width=250>';
//                    echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
//                    echo ' ';
                    echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
                    echo '</td>';
                    echo '<td>'. $row['name'] . '</td>';
                    echo '<td>'. $row['founded'] . '</td>';
                    echo '<td>'. $row['address'] . '</td>';
                    echo '<td>'. $row['city'] . '</td>';
                    echo '<td>'. $row['country'] . '</td>';
                    echo '<td>'. $row['lat'] . '</td>';
                    echo '<td>'. $row['lng'] . '</td>';
                    echo '<td>'. $row['type'] . '</td>';
                    echo '<td>'. $row['industry'] . '</td>';
                    echo '<td>'. $row['size'] . '</td>';
                    echo '<td>'. $row['specialities'] . '</td>';
                    echo '<td>'. $row['review'] . '</td>';
                    echo '<td>'. $row['website_url'] . '</td>';
                    echo '</tr>';
                }
                Database::disconnect();
                ?>
                </tbody>
            </table>
            </div>
        </div>
    </form>
</div> <!-- /container -->
</body>
</html>