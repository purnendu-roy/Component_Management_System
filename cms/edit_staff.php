<?php
include 'admin.php';
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}	
	if(!isset($_SESSION['auth']))
	{
		header("Location:index.php");
	}
	if($_SESSION['auth']!='Admin')
	{
		session_destroy();
		header("Location:index.php");	
	}
?>

<html>
<head> 
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
</head>
<body>
<div id="center_addtext"><br>
<form action="edit_staff.php" method="POST" onLoad="_top">

<?php

	if(!isset($_POST['submit']))
	{
		print "<br/><h3 align='center' style='color:blue'><b>Edit Staff</b> </h5>";
     	addform();
	}
	else if($_POST['submit'] && $_POST['sname'])
	{
		$name=$_POST['sname'];
		header("location:edit_staff_details.php?name=$name");
	}
	else
	{
		print "<br/><h3 align='center' style='color:red'><b>Edit Staff</b></h5>";
		addform();
	}
?>

<?php
function addform()
{
    include 'db.php';
	echo "<b><table align='center'><tr><td>Select a Staff : </td><td>";
	echo "<select name='sname' onchange='getSearch(this.value)' style='border:1px solid grey;width:172px;
	font-size:40;'>";
	echo "<option></option>";
		// onchange='getSearch(this.value)'
		$sql="select distinct name from staff"; //distinct names from Staff table 
		$result=mysql_query($sql);
		while($row = mysql_fetch_array($result)) //drop down list for staff name
		{
			$val=$row['name'];
			echo "<option value='$val'>";
			echo $val;
			echo "</option>";
		}
	echo "</select>";
	echo "</td></tr><tr><td></td></tr></table>";
	echo "<br>";
	echo "<input type='submit' name='submit' value='Search' style='margin-left: 520px;font-size:17px;'>
	</input>";
}
?>

</div>
</body>
</html>