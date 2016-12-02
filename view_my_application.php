<?php
ob_start();
session_start();
require_once 'dbconnect.php';

$db = mysqli_connect('localhost:3306','root','','4400')
or die('Error connecting to MySQL server.');
$res=mysql_query("SELECT * FROM user WHERE Username ='".$_SESSION['user']."'");
$userRow=mysql_fetch_array($res);
$userName = $userRow[Username];
$sql = "SELECT Date, Pname as Project_Name, Status
FROM Apply
WHERE Student_name = '$userName'
ORDER BY FIELD(Status, 'Pending', 'Accepted','Rejected')";

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
</head>
<body>
<h1 style="font-family:Garamond";" align=center>My Application</h1>
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
