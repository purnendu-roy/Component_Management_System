<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Staff')
{
	session_destroy();
	header("Location:index.php");	
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
<form action="student_staff_issue.php" method="POST" onLoad="_top">
<?php
include 'staff.php';

if(!isset($_POST['rno']))
{
	echo "<br/><table align='center'><tr><td>Enter Roll No. :</td><td><input type='text' name='rno'></input></td>
	</tr><tr><td><input type='submit' name='submit' value='Submit'></input></td>
	<td><input type=button value='back' onclick=window.location.href='staff.php'></input></td></tr>";
}
else if($_POST['rno'])
{
	include 'db.php';
	
	$rno=$_POST['rno'];
	//$_SESSION['rno']=$_POST['rno'];
	
	$sql="SELECT * FROM request_issue WHERE uid='$rno' and status='Approved'";
	$result=mysql_query($sql);
	
	if(mysql_num_rows($result) == 0)
	{
		print "<br/><h3 style='color:red' align='center'>No Issue Requests</h5>";
		//header("refresh:1;staff.php");
	}
	else
		header("location:student_staff_issue_det.php?rno=$rno");
}
else
{
	echo "<h3 align='center' style='color:red'>Please Enter Roll Number:</h3>";
	echo "<table align='center'><tr><td>Enter Roll No. :</td><td><input type='text' name='rno'></input>
	</td></tr><tr><td><input type='submit' name='submit' value='Submit'></input></td>
	<td><input type=button value='back' onclick=window.location.href='staff.php'></input></td></tr>";
}
?>
</form>
</body>