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

$sql = "SELECT User.Username as Name, Apply.Pname as Project, USER.MajorName as 'Applicant Major', 
        USER.Year as 'Applicant Year', Apply.Status
        FROM Apply, USER
        WHERE Apply.Student_name = USER.Username
        ORDER BY FIELD(Apply.Status, 'Pending', 'Accepted','Rejected')";

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

$colNames = array_keys(reset($data));

if(isset($_POST['action']) and isset($_POST['Pending'])){

if ($_POST['action'] === 'Accept') {
    foreach ($_POST['Pending'] as $selectedPending){
    $array = explode(",",$selectedPending);
    $sql = "UPDATE Apply
            SET Status = 'Accepted'
            WHERE Student_name = '{$array[0]}' AND Pname ='{$array[1]}'";
    $db->query($sql);
    header("Refresh:0");}}
else {
    foreach ($_POST['Pending'] as $selectedPending){
    $array = explode(",",$selectedPending);
    $sql = "UPDATE Apply
            SET Status = 'Rejected'
            WHERE Student_name = '{$array[0]}' AND Pname ='{$array[1]}'";
    $db->query($sql);
    header("Refresh:0");}}  
    }

?>

<!DOCTYPE html>
<html>
<head>
<title>Application</title>
<style>
.col1 {display: none; }
</style>
</head>
<body>
<?php
$action = "";
?> 
<h1 style="font-family:Garamond";" align=center>Application</h1>
<form autocomplete="off" style="font-family:Garamond" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table class="proejct_report" style="border:5px #cccccc solid; font-family:Garamond" rules="all" cellpadding='5' align=center>
    <tr>
        <?php
          foreach($colNames as $colName)
          {
              echo "<th class = '{$colName}'>$colName</th>";
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
             if ($row['Status'] == 'Pending'){
             if ($colName === 'Name') {
              $value = implode(",",$row);
              echo "<td class = '{$colName}'><div class='checkbox'><label><input type='checkbox' id='{$row['Name']}' name='Pending[]' value='{$value}'>".$row[$colName]."</label></div></td>";}
             else {echo "<td class = '{$colName}'><label for='{$row['Name']}'>".$row[$colName]."</label></td>";}
             }else{echo "<td>".$row[$colName]."</td>";}
          }
        echo "</tr>";  
        }
    $db->close();
    ?>
</table>
<br/>
<center>
<p><input style="width:50px;height:25px;font-size:15px;font-family:Garamond" type="button" value="Back" onclick="location.href='../choose_functionality.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input class="login-button" type="submit" name="action" value="Accept" style="width:70px;height:25px;font-size:15px;font-family:Garamond"/>&nbsp;&nbsp;&nbsp;
<input class="login-button" type="submit" name="action" value="Reject" style="width:70px;height:25px;font-size:15px;font-family:Garamond"/></p>
</form>

</body>
</html>