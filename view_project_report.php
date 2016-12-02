<?php

session_start();

if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  } elseif ($_SESSION['type'] == 'Student') {
    header("Location: main.php");
    exit;
  }

$db = mysqli_connect('localhost:3306','root','','4400')
or die('Error connecting to MySQL server.');

$sql = "SELECT Pname as Project, count(Student_name) as No_of_Applicants
		FROM Apply
		GROUP BY Pname
		ORDER BY count(Student_name) DESC
		Limit 10;";

$result = $db->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

$colNames = array_keys(reset($data))
?>

<!DOCTYPE html>
<html>
<head>
<title>Popular Project</title>
</head>
<body>
<h1 style="font-family:Garamond";" align=center>Popular Project</h1>
<table class="proejct_report" style="border:5px #cccccc solid; font-family:Garamond" rules="all" cellpadding='5' align=center>
<tr>
    <?php
       foreach($colNames as $colName)
       {
          echo "<th>$colName</th>";
       }
    ?>
</tr>

    <?php
       //print the rows
       foreach($data as $row)
       {
          echo "<tr>";
          foreach($colNames as $colName)
          {
          	if ($colName === "Project") {
             echo "<td>".$row[$colName]."</td>";}
            else {
            echo "<td align=center>".$row[$colName]."</td>";}
          	}
          echo "</tr>";
       }
    $db->close();
    ?>
</table>
<br/>
<center>
<input style="width:50px;height:25px;font-size:17px;font-family:Garamond" type="button" value="Back" onclick="location.href='../choose_functionality.php'">
</body>
</html>