<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail

  //Header for users
	$res=mysql_query("SELECT * FROM user WHERE Username ='".$_SESSION['user']."'");
	$userRow=mysql_fetch_array($res);
  	$userName = $userRow['Username'];
  	$userMajor = $userRow['MajorName'];

	$res2 = mysql_query("SELECT * FROM major WHERE MajorName = $userMajor");
	$userRow2 = mysql_fetch_array($res2);
	$department = $userRow2['DeptName'];

	//Submission
	if ( isset($_POST['btn-submit']) ) {
		$major = $_POST['Major'];
    $year = $_POST['Year'];
		$query = "UPDATE user SET Year='$year',MajorName='$major' WHERE Username = '$userName'";
		$res = mysql_query($query);
    if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully Change";
			unset($major);
			unset($year);
     } else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";
		}
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['GT_email']; ?></title>
<link rel="stylesheet" href="css/editProfile.css" type="text/css" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
</head>
<body>
<?php
if ( isset($errMSG) ) {
?>
<div class="form-group">
		<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
			</div>
		</div>
			<?php
}
?>
<div id = "title">
Edit Profile
</div>
<div id = "profileForm">
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" method="post">
	Major:
	<select name="Major">;
	<?php
	 $query = "SELECT MajorName FROM major;";
	 $result = mysql_query($query) or die(mysql_error());
	 while($row = mysql_fetch_assoc($result)) {
	echo '<option   value=\"'.$row['MajorName'].'">'.$row['MajorName'].'</option>';
	}
	echo "</select>";
	?>
	<br>
	<br>
	Year:
	<select name = "Year">;
		<option value="Freshman">Freshman</option>
		<option value="Sophomore">Sophomore</option>
		<option value="Junior">Junior</option>
		<option value="Senior">Senior</option>
  </select>
	<br>
	<br>
	</form>
	<div id = "departmentName">
  Department:
	<?php echo $department;?>
	</div>
	<button type="submit" class="btn btn-block btn-primary" name="btn-submit">Submit</button>
</div>

</body>
