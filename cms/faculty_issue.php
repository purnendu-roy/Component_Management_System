<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:login.php");
if($_SESSION['auth']!='Admin')
{
	session_destroy();
	header("Location:login.php");	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="faculty_issue.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['rno']))
{
	echo "<br/><table align='center'><tr><td>Name of Faculty : </td>";
	echo "<td><select name='rno' style='width:173px;'>";
	include 'db.php';
	
	$sql = "SELECT  name from faculty";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option>".$row['name']."</option>";
	}
	echo "</select></td></tr>";
	echo "<tr><td><input type='submit' name='submit' value='Submit'></input></td>
	<td><input type=button value='back' onclick=window.location.href='admin.php'></input></td></tr>";
}

else if($_POST['rno'])
{
	include 'db.php';
	
	$rno=$_POST['rno'];
	$sql = "SELECT  * from faculty where name='$rno'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$uid=$row['id'];

	$sql="SELECT * FROM request_issue WHERE uid='$uid' and status='Approved'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
		print "<br/><h3 style='color:red' align='center'>No Issue Requests</h5>";
		header("refresh:1;admin.php");
	}
	else
		header("location:faculty_issue_details.php?id=$uid");
}

else
{
	echo "<h4 align='center' style='color:red'>Please enter the name of faculty</h4>";
	echo "<input list='main' name='rno'><datalist id='main'>";

	include 'db.php';
	$sql = "SELECT  name from faculty";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option>".$row['name']."</option>";
	}
  	echo "</datalist></td></tr>";
	echo "<tr><td><input type='submit' name='submit' value='Submit'></input></td>
	<td><input type=button value='back' onclick=window.location.href='admin.php'></input></td></tr>";
}
?>
</form>
</body>
</html>