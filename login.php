<?php
require 'database.php';

session_start();
if(isset($_REQUEST['user']) && isset($_REQUEST['pass']))
{

    $inputuser = $_REQUEST['user'];
    $inputpass = $_REQUEST['pass'];

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM adminuser where user = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($inputuser));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $passfromdb = $data['pass'];
    Database::disconnect();


    if($inputpass==$passfromdb)
    {
        $_SESSION['user'] = $inputuser;
        $_SESSION['pass'] = $passfromdb;
        $_SESSION['LOGIN'] = "YES";
        header("Location: index.php");
    }


//    if($_REQUEST['user']=="shohel" && $_REQUEST['pass']=="1234")
//    {
//        $_SESSION['user'] = "shohel";
//        $_SESSION['pass'] = "1234";
//        $_SESSION['LOGIN'] = "YES";
//        header("Location: index.php");
//    }
}
else{
    //header("Location: logout.php");
    session_destroy();
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
<div class="container">

    <form class="form-horizontal" action="login.php" method="post">

        <div class="row">
            <legend>Log In</legend>
        </div>

        <div class="row">
            <p>

            </p>
        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="textinput">User</label>
            <div class="controls">
                <input id="user" name="user" placeholder="user" class="input-xlarge" required="" type="text">

            </div>
        </div>

        <!-- Password input-->
        <div class="control-group">
            <label class="control-label" for="pass">Password</label>
            <div class="controls">
                <input id="pass" name="pass" placeholder="password" class="input-xlarge" required="" type="password">

            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton"></label>
            <div class="controls">
                <button type="submit" name="login" class="btn btn-primary">Log In</button>
            </div>
        </div>

            </div>
    </form>


</div> <!-- /container -->
</body>
</html>