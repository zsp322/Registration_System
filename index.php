<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';

function updater($name,$pass){
			
			$res=mysql_query("SELECT Username, Password, UserType FROM user WHERE Username='{$name}'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

			if( $count == 1 && $row['Password']==$pass && $row['UserType'] == 'Student') {
				$_SESSION['user'] = $row['Username'];
				$_SESSION['type'] = $row['UserType'];
        		header("Location: main.php");
			} elseif($count == 1 && $row['Password']==$pass && $row['UserType'] == 'Admin'){
				$_SESSION['user'] = $row['Username'];
				$_SESSION['type'] = $row['UserType'];
        		header("Location: choose_functionality.php");
			} else {
				echo "<center><span style='color: red;font-size:15px;'>Incorrect password or useranme, please try again.</span>";
			}}
		
if(isset($_POST['name']) and isset($_POST['pass'])){
    updater($_POST['name'],$_POST['pass']);
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
input, textarea, select{font-family:inherit;}
</style>
</head>
<body>
	<?php
	$name = $nameErr = $pass = $passErr = $msgErr=""; 
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
          $nameErr = "<span style='color: red;font-size:13px;'>You must enter user name.</span>";
          } else {
          $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
          $nameErr = "<span style='color: red';font-size:12px>You can only use alphabet and space.</span>";
          }
        }

      if (empty($_POST["pass"])) {
          $passErr = "<span style='color: red;font-size:13px'>You must enter your password.</span>";
          } else {
          $pass = test_input($_POST["pass"]);
        }
     }
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>
<h1 style="font-family:Garamond";" align=center>Login</h1>
      <center>
      <form autocomplete="off" style="font-family:Garamond" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Username：<input type='text' name="name""><br>
      <span class="error"> <?php echo $nameErr;?></span>
      <br>
      Password：<input type='password' name="pass"><br>
      <span class="error"> <?php echo $passErr;?></span>
      <span class="error"> <?php echo $msgErr;?></span>
      <br>
      <p>
      <input class="login-button" type='submit' value='Login' style="width:70px;height:25px;font-size:15px;font-family:Garamond">&nbsp;&nbsp;&nbsp;<input style="width:70px;height:25px;font-size:15px;font-family:Garamond" type="button" value="Register" onclick="location.href='../register.php'"></p>
      </form>
</body>
</html>