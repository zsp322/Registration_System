<?php

session_start();

if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  } elseif ($_SESSION['type'] == 'Student') {
    header("Location: main.php");
    exit;
  }


function updater($advisor,$email,$name,$description,$designation,$estimated,$major,$year,$dept,$category){
      $db = mysqli_connect('localhost:3306','root','','4400')
      or die('Error connecting to MySQL server.');
      $sql_1 = "INSERT INTO project VALUES ('{$advisor}', '{$email}', '{$name}', '{$description}', '{$designation}', 
      {$estimated})";
      if ($db->query($sql_1) === TRUE) {
        echo "<p align='center' style='color: red'>Project added successfully.</p>";
        } else {
        echo "<p align='center' style='color: red'>You must fill every requred field.</p>";
        }
      $sql_2 = "INSERT INTO requirement VALUES ('{$name}', '{$major}', '{$year}', '{$dept}')";
      $db->query($sql_2);

      foreach ($_POST['category'] as $selectedCategory){
          $sql_3 = "INSERT INTO Proj_IS_category VALUES ('{$name}','{$selectedCategory}')";;
          $db->query($sql_3);}

      $db->close();}


if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['description']) and isset($_POST['estimated']) 
  and isset($_POST['category'])){
    updater($_POST['advisor'],$_POST['email'],$_POST['name'],$_POST['description'],$_POST['designation'],$_POST['estimated']
           ,$_POST['major'],$_POST['year'],$_POST['dept'],$_POST['category']);
  }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add a Project</title>
        <style>
        a {
          font-size:19px;
          font-family:Garamond;
        }
        option {
          font-family:Garamond;
        }
        label,input, textarea, select{
        font-family:inherit;
        display: inline-block;
        vertical-align: middle;
        }
        input.wideInput{
        text-align: left;
        padding-left:0;
        padding-top:0;
        padding-bottom:0.4em;
        padding-right: 0.4em;
        }
        </style>
    </head>
    <body>
      <?php
      $name = $nameErr = $email = $emailErr = $advisor = $description = $descriptionErr = "";
      $category = $categoryErr = $designation = $designationErr = $major = $year =  $dept = $estimated = $estimatedErr = "";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
          $nameErr = "<span style='color: red;font-size:13px;'>You must enter project name.</span>";
          } else {
          $name = test_input($_POST["name"]);
        }

      if (empty($_POST["email"])) {
          $emailErr = "<span style='color: red;font-size:13px'>You must enter advisor email.</span>";
          } else {
          $email = test_input($_POST["email"]);
          if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
          $emailErr = "Invalid Email";
          }
        }
      if (empty($_POST["description"])) {
          $descriptionErr = "<span style='color: red;font-size:13px'>You must enter project description.</span>";
          } else {
          $description = test_input($_POST["description"]);
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
      <h1 style="font-family:Garamond";" align=center>Add a Project</h1>
      <center>
      <form style="font-family:Garamond" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Project Name：<input type='text' name="name"><br>
      <span class="error"> <?php echo $nameErr;?></span>
      <br>
      Advisor：<input type='text' name="advisor"><br>
      <br>
      Advisor Email：<input type='email' name="email" size="25"><br>
      <span class="error"> <?php echo $emailErr;?></span>
      <br>
      Description：<textarea class="wideInput" type='textarea' name="description" style="width: 300px; height: 200px;"></textarea><br><span class="error"> <?php echo $descriptionErr;?></span>
      <br>
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
      Estimated # of Students：<input type='number' min="1" name="estimated" style="font-family : Garamond; width:50px;"><br>
      <span class="error"> <?php echo $estimatedErr;?></span>
      <br>
      Major Requirement：<select name="major" style="font-family : Garamond;">
      <option value=NULL>No Requirement</option>
      <option value="Computer Science">Computer Science</option>
      <option value="Applied Mathematics">Applied Mathematics</option>
      <option value="Architecture">Architecture</option>
      <option value="Biology">Biology</option>
      <option value="Aerospace Engineering">Aerospace Engineering</option>
      <option value="Economics">Economics</option>
      <option value="Business Administration">Business Administration</option>
      </select><br>
      <br>
      Year Requirement：<select name="year" style="font-family : Garamond;">
      <option value=NULL>No Requirement</option>
      <option value="Freshman">Only Freshman Students</option>
      <option value="Sophomore">Only Sophomore Students</option>
      <option value="Junior">Only Junior Students</option>
      <option value="Senior">Only Senior Students</option>
      </select><br>
      <br>
      Department Requirement：<select name="dept" style="font-family : Garamond;">
      <option value=NULL>No Requirement</option>
      <option value="College of Computing">College of Computing</option>
      <option value="College of Sciences">College of Sciences</option>
      <option value="College of Design">College of Design</option>
      <option value="College of Engineering">College of Engineering</option>
      <option value="Ivan Allen College of Liberal Arts">Ivan Allen College of Liberal Arts</option>
      <option value="Business Administration">Business Administration</option>
      </select><br>
      <p><input style="width:50px;height:25px;font-size:15px;font-family:Garamond" type="button" value="Back" onclick="location.href='../choose_functionality.php'">&nbsp;&nbsp;&nbsp;
      <input class="login-button" type='submit' value='Submit' style="width:70px;height:25px;font-size:15px;font-family:Garamond"></p>
      </form>
    </body>
</html>

<!--Hold down the control (ctrl) button to select multiple options
Hold down the command button to select multiple options->