<?php

session_start();

if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  } elseif ($_SESSION['type'] == 'Student') {
    header("Location: main.php");
    exit;
  }


function updater($number,$name,$instructor,$category,$designation,$estimated){
      $db = mysqli_connect('localhost:3306','root','','4400')
      or die('Error connecting to MySQL server.');
      $sql_1 = "INSERT INTO course VALUES ('{$number}', '{$instructor}', {$estimated}, '{$name}', '{$designation}')";
      if ($db->query($sql_1) === TRUE) {
        echo "<p align='center' style='color: red'>Course added successfully.</p>";
        } else {
        echo "<p align='center' style='color: red'>You must fill every required field.</p>";
        }

      foreach ($_POST['category'] as $selectedCategory){
          $sql_3 = "INSERT INTO course_IS_category VALUES ('{$number}','{$selectedCategory}')";;
          $db->query($sql_3);}

      $db->close();}


if(isset($_POST['number']) and isset($_POST['name']) and isset($_POST['instructor']) and isset($_POST['estimated']) 
  and isset($_POST['category'])){
    updater($_POST['number'],$_POST['name'],$_POST['instructor'],$_POST['category'],$_POST['designation'],$_POST['estimated']);
  }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add a Course</title>
        <style>
        a {
          font-size:19px;
          font-family:Garamond;
        }
        option {
          font-family:Garamond;
        }
        input, textarea, select{font-family:inherit;}
        label,select {
        display: inline-block;
        vertical-align: middle;
        }     
        </style>
    </head>
    <body>
      <?php
      $name = $nameErr = $number = $numberErr = $instructor = $instructoErr = "";
      $category = $categoryErr = $designation = $designationErr = $estimated = $estimatedErr = "";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
          $nameErr = "<span style='color: red;font-size:13px;'>You must enter course name.</span>";
          } else {
          $name = test_input($_POST["name"]);
        }

      if (empty($_POST["instructor"])) {
          $instructorErr = "<span style='color: red;font-size:13px'>You must enter instructor name.</span>";
          } else {
          $instructor = test_input($_POST["instructor"]);
          }
      if (empty($_POST["estimated"])) {
          $estimatedErr = "<span style='color: red;font-size:13px'>You must enter estimated number of students.</span>";
          } else {
          $estimated = test_input($_POST["estimated"]);
          }
      if (empty($_POST["category"])) {
          $categoryErr = "<span style='color: red;font-size:13px'>You must select at least one category.</span>";
          } 
      }
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
      ?>       
      <h1 style="font-family:Garamond";" align=center>Add a Course</h1>
      <center>
      <form style="font-family:Garamond" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Course Number：<input type='text' name="number"><br>
      <span class="error"> <?php echo $numberErr;?></span>
      <br>
      Course Name：<input type='text' name="name"><br>
      <span class="error"> <?php echo $nameErr;?></span>
      <br>
      Instructor：<input type='text' name="instructor"><br>
      <span class="error"> <?php echo $instructoErr;?></span>
      <br>
      Category：<select name="category[]" multiple  size="6">
      <option value="Computing for Good">Computing for Good</option>
      <option value="Doing good for Your Neighborhood">Doing good for Your Neighborhood</option>
      <option value="Reciprocal Teaching and Learning">Reciprocal Teaching and Learning</option>
      <option value="Urban Development">Urban Development</option>
      <option value="Adaptive Learning">Adaptive Learning</option>
      <option value="Technology for Social Good">Technology for Social Good</option>
      <option value="Sustainable Communities">Sustainable Communities</option>
      <option value="Crowd-Sourced">Crowd-Sourced</option>
      <option value="Collaborative Action">Collaborative Action</option>
      </select><br>
      <span class="error"> <?php echo $categoryErr;?></span>
      <br>
      Designation：<select name="designation" style="width: 200px; font-family : Garamond;">
      <option value="Sustainable Communities">Sustainable Communities</option>
      <option value="Community">Community</option>
      </select> <br>
      <br>
      Estimated # of Students：<input type='number' min="1" name="estimated" style="font-family : Garamond; width: 50px;"><br>
      <span class="error"> <?php echo $estimatedErr;?></span>
      <br>
      <p><input style="width:50px;height:25px;font-size:15px;font-family:Garamond" type="button" value="Back" onclick="location.href='../choose_functionality.php'">&nbsp;&nbsp;&nbsp;<input class="login-button" type='submit' value='Submit' style="width:70px;height:25px;font-size:15px;font-family:Garamond"></p>
      </form>
    </body>
</html>