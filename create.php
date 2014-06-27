<?php

require 'database.php';


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

if ( !empty($_POST)) {
    // keep track validation errors
    $nameError = null;


    // keep track post values
    $name = $_POST['name'];
    $founded = $_POST['founded'];
    $address = $_POST['address'];
    $city = $_POST['state'];
    $country = $_POST['country'];
    $lat = floatval($_POST['lat']);
    $lng = floatval($_POST['lng']);
    $type = $_POST['type'];
    $industry = $_POST['industry'];
    $size = $_POST['size'];
    $specialities = $_POST['specialities'];
    $review = $_POST['review'];
    $website_url = $_POST['website_url'];

    // validate input
    $valid = true;
    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    }



    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO global (name,founded,address,city,country,lat,lng,type,industry,size,specialities,review,website_url) values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($name,$founded,$address,$city,$country,$lat,$lng,$type,$industry,$size,$specialities,$review,$website_url));
        Database::disconnect();

        $_SESSION['INPUTNAME'] = $name;
        header("Location: index.php");
    }
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

    <div class="span10 offset1">
        <div class="row">
            <h3>Create a Customer</h3>
        </div>

        <form class="form-horizontal" action="create.php" method="post">
            <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Established</label>
                <div class="controls">
                    <select name="founded" class="input-xlarge">
                        <?php
                        echo '<option></option>';
                        for ($yearCount=1900; $yearCount<=date("Y"); $yearCount++)
                        {
                            echo '<option value="'.$yearCount.'">'.$yearCount.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <textarea name="address" placeholder="Address"></textarea>
                </div>
            </div>
            <script type= "text/javascript" src = "js/countries3.js"></script>
            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    <select id="country"  name="country" class="input-xlarge" onchange="print_state('state',this.selectedIndex);">
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <select id="state"  name="state" class="input-xlarge">
                    </select>
                </div>
            </div>
            <script language="javascript">print_country("country");</script>

            <div class="control-group">
                <label class="control-label">Latitude</label>
                <div class="controls">
                    <input id="lat" name="lat" placeholder="Latitude" class="input-xlarge" type="text">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Longitude</label>
                <div class="controls">
                    <input id="lng" name="lng" placeholder="Longitude" class="input-xlarge" type="text">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"">Company Nature</label>
                <div class="controls">
                    <select name="type" class="input-xlarge">
                        <option></option>
                        <option>Public</option>
                        <option>Private</option>
                        <option>Partnership</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"">Business Type</label>
                <div class="controls">
                    <select name="industry" class="input-xlarge">
                        <option></option>
                        <option>Marketing</option>
                        <option>Software</option>
                        <option>Web</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"">Size</label>
                <div class="controls">
                    <select name="size" class="input-xlarge">
                        <option></option>
                        <option>1-10 Employees</option>
                        <option>11-50 Employees</option>
                        <option>51-200 Employees</option>
                        <option>201-500 Employees</option>
                        <option>501-1000 Employees</option>
                        <option>1001-5000 Employees</option>
                        <option>5001-10,000 Employees</option>
                        <option>10,001+ Employees</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Specialities</label>
                <div class="controls">
                    <textarea name="specialities" placeholder="Specialities"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Review</label>
                <div class="controls">
                    <textarea name="review" placeholder="Review"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Website</label>
                <div class="controls">
                    <textarea name="website_url" placeholder="Website"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>