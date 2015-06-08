<?php
	$q=$_GET["q"];
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	include 'db.php';
	$sql = "select distinct main_cat.category from main_cat, major_cat where major_cat.category = '$q' and
	major_cat.id=main_cat.refno_maj";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option >".$row['category']."</option>";
	}
?>