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

  $res=mysql_query("SELECT * FROM user WHERE Username ='".$_SESSION['user']."'");
	$userRow=mysql_fetch_array($res);





?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['GT_email']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="css/mainpage.css" type="text/css" />
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">

        <div id="navbar" class="navbar-collapse collapse">

          <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['GT_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                <li><a href="Me.php">My Profile</a></li>
							</ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	<div id="wrapper">

	<div class="container">
	</div>

  </div>
	<div id = "content">
      <div id = "title">
      Main Page
	    </div>
	</div>
	<div id = "searchForm">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"method="post">
    Title:
		<input type="text" name="title">
		<br>
		<br>
    Designation:
		<select name="Designation">;
    <?php
     $query = "SELECT Dname FROM designation;";
     $result = mysql_query($query) or die(mysql_error());
		 while($row = mysql_fetch_assoc($result)) {
    echo '<option   value=\"'.$row['Dname'].'">'.$row['Dname'].'</option>';
    }
    echo "</select>";
    ?>
		<br>
		<br>
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
		<input type="radio" name="catagory" value="Course" checked> Course
	  <input type="radio" name="catagory" value="Project"> Project
	  <input type="radio" name="catagory" value="Both"> Both
    <button type="submit" class="btn btn-block btn-primary" name="btn-filter">Apply Filter</button>
		</form>

 </div>
 <div id = "resultForm">
  <?php echo $userRow[CouseName];
  ?>
 </div>
  <script src="assets/jquery-1.11.3-jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>
<?php ob_end_flush(); ?>
