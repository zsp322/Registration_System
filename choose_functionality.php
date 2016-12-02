<?php
session_start();

if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  } elseif ($_SESSION['type'] == 'Student') {
    header("Location: main.php");
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Choose Functionality</title>
        <style>
        a {
          font-size:19px;
          font-family:Garamond;
        }
        </style>
    </head>
    <body>       
      <h1 style="font-family:Garamond";" align=center>Choose Functionality</h1>
      <center><a href="../view_applications.php">View Applications</a>
      <br>
      <br>
      <a href="../view_project_report.php">View Popular Project Report</a>
      <br>
      <br>
      <a href="../view_application_report.php">View Application Report</a>
      <br>
      <br>
      <a href="../add_project.php">Add a Project</a>
      <br>
      <br>
      <a href="../add_course.php">Add a Course</a>
      <br>
      <br>
      <input style="width:80px;height:25px;font-size:15px;font-family:Garamond" type="button" value="Log Out" onclick="location.href='../logout.php?logout'"></center>
    </body>
</html>