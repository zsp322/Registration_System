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
$sql = "SELECT *
FROM(
-- To obtain No of Applicants and accept rate for each project
SELECT count_applicants.Pname as Project, count_applicants.No_of_Applicants,
CONCAT(ROUND(IFNULL(Accepted.accepted_no,0)/count_applicants.No_of_Applicants*100, 0), '%') as Accept_Rate
FROM
(SELECT Pname, count(*) as No_of_Applicants
FROM Apply
GROUP BY Pname) as count_applicants
LEFT JOIN
(SELECT Pname, count(*) as accepted_no
FROM Apply
WHERE Status = 'Accepted'
GROUP BY Pname) as Accepted
ON count_applicants.Pname = Accepted.Pname
) as t1
NATURAL JOIN(
-- To obtain Top 3 Applicants major for each Project
SELECT Pname as Project, GROUP_CONCAT(Major2) as Top3Major
FROM(
SELECT Pname, Major2, count(Major1) as rank FROM(
SELECT * FROM(
SELECT Pname, Majorname as Major1, count(Majorname) as CMajor1
FROM Apply JOIN USER ON Apply.Student_name = USER.Username
GROUP BY Pname, MajorName) as t1
NATURAL JOIN(
SELECT Pname, Majorname as Major2, count(Majorname) as CMajor2
FROM Apply JOIN USER ON Apply.Student_name = USER.Username
GROUP BY Pname, MajorName) as t2
WHERE CMajor1 >= CMajor2) as t3
GROUP BY Pname, Major2
HAVING rank>=0 and rank <=3) as t4
GROUP BY Project) as topmajor
ORDER BY Accept_Rate DESC;";

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
<title>Application Report</title>
</head>
<body>
<h1 style="font-family:Garamond";" align=center>Application Report</h1>
<center>
<div style="height:250px;width:500px;overflow:auto;">
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
          	if ($colName === 'Project') {
             echo "<td>".$row[$colName]."</td>";}
            else {
            echo "<td align=center>".$row[$colName]."</td>";}
          	}
          echo "</tr>";
       }
    $db->close();
    ?>
</table>
</div>
<br/>
<input style="width:50px;height:25px;font-size:17px;font-family:Garamond" type="button" value="Back" onclick="location.href='../choose_functionality.php'">
</body>
</html>