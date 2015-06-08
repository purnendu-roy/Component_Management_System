<?php
include 'db.php';
$sql = "SELECT * from capital";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
	echo "<option>".$row['name']."</option>";
}
?>


