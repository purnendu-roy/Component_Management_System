<?php
$q=$_GET["q"];
if(!isset($_SESSION)) 
{ 
session_start(); 
}
$c=$_SESSION['category'];
include 'db.php';
$sql = " SELECT spec1 FROM consumable WHERE category = '$q' and type='$c' ";
$result = mysql_query($sql);
echo "<option></option>";
while($row = mysql_fetch_array($result))
{
	echo "<option >".$row['0']."</option>";
}
?>

