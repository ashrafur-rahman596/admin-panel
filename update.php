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

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
}

if ( !empty($_POST)) {
    // keep track validation errors
    $nameError = null;
    $emailError = null;
    $mobileError = null;
    $cityError = null;

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

//    if (empty($email)) {
//        $emailError = 'Please enter Email Address';
//        $valid = false;
//    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
//        $emailError = 'Please enter a valid Email Address';
//        $valid = false;
//    }



    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE global  set name = ?, founded = ?, address =?, city = ?, country = ?, lat = ?, lng= ?, type = ?, industry = ?, size = ?, specialities = ?, review = ?, website_url = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name,$founded,$address,$city,$country,$lat,$lng,$type,$industry,$size,$specialities,$review,$website_url,$id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM global where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $name = $data['name'];
    $founded = $data['founded'];
    $address = $data['address'];
    $city = $data['city'];
    $country = $data['country'];
    $lat = floatval($data['lat']);
    $lng = floatval($data['lng']);
    $type = $data['type'];
    $industry = $data['industry'];
    $size = $data['size'];
    $specialities = $data['specialities'];
    $review = $data['review'];
    $website_url = $data['website_url'];
    Database::disconnect();
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

    <div class="span10 offset1">
        <div class="row">
            <h3>Update Info</h3>
        </div>

        <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
            <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input id="name" name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
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
                            if($yearCount == $founded)
                            {
                                echo '<option value="'.$yearCount.'" selected="selected">'.$yearCount.'</option>';
                            }
                            else
                            {
                                echo '<option value="'.$yearCount.'">'.$yearCount.'</option>';
                            }

                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <textarea name="address" placeholder="Address"><?php echo !empty($address)?$address:'';?></textarea>
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
            <script language="javascript">print_country("country","<?php echo $country; ?>");</script>
            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <select id="state"  name="state" class="input-xlarge">
                    </select>
                </div>
            </div>
            <script language="javascript">print_city("state","<?php echo $country; ?>","<?php echo $city; ?>");</script>

            <div class="control-group">
                <label class="control-label">Latitude</label>
                <div class="controls">
                    <input id="lat" name="lat" placeholder="Latitude" class="input-xlarge" type="text" value="<?php echo !empty($lat)?$lat:'';?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Longitude</label>
                <div class="controls">
                    <input id="lng" name="lng" placeholder="Longitude" class="input-xlarge" type="text" value="<?php echo !empty($lng)?$lng:'';?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"">Company Nature</label>
                <div class="controls">
                    <select name="type" class="input-xlarge">
                        <option></option>
                        <option <?php if($type == "Public"){ echo '" selected="selected"';} ?> >Public</option>
                        <option <?php if($type == "Private"){ echo '" selected="selected"';} ?> >Private</option>
                        <option <?php if($type == "Partnership"){ echo '" selected="selected"';} ?> >Partnership</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"">Business Type</label>
                <div class="controls">
                    <select name="industry" class="input-xlarge">
                        <option></option>
                        <option <?php if($industry == "Marketing"){ echo '" selected="selected"';} ?> >Marketing</option>
                        <option <?php if($industry == "Software"){ echo '" selected="selected"';} ?> >Software</option>
                        <option <?php if($industry == "Web"){ echo '" selected="selected"';} ?> >Web</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"">Size</label>
                <div class="controls">
                    <select name="size" class="input-xlarge">
                        <option></option>
                        <option <?php if($size == "1-10 Employees"){ echo '" selected="selected"';} ?> >1-10 Employees</option>
                        <option <?php if($size == "11-50 Employees"){ echo '" selected="selected"';} ?> >11-50 Employees</option>
                        <option <?php if($size == "51-200 Employees"){ echo '" selected="selected"';} ?> >51-200 Employees</option>
                        <option <?php if($size == "201-500 Employees"){ echo '" selected="selected"';} ?> >201-500 Employees</option>
                        <option <?php if($size == "501-1000 Employees"){ echo '" selected="selected"';} ?> >501-1000 Employees</option>
                        <option <?php if($size == "1001-5000 Employees"){ echo '" selected="selected"';} ?> >1001-5000 Employees</option>
                        <option <?php if($size == "5001-10,000 Employees"){ echo '" selected="selected"';} ?> >5001-10,000 Employees</option>
                        <option <?php if($size == "10,001+ Employees"){ echo '" selected="selected"';} ?> >10,001+ Employees</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Specialities</label>
                <div class="controls">
                    <textarea name="specialities" placeholder="specialities"><?php echo !empty($specialities)?$specialities:'';?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Review</label>
                <div class="controls">
                    <textarea name="review" placeholder="review"><?php echo !empty($review)?$review:'';?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Website</label>
                <div class="controls">
                    <textarea name="website_url" placeholder="website_url"><?php echo !empty($website_url)?$website_url:'';?></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>