<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Faculty')
{
	session_destroy();
	header("Location:index.php");	
}
?>
<html>
<head> 
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:30%;
			font-size:14px;
			border-collapse:collapse;
		}
		#edittab td, #edittab th 
		{
			font-size:1em;
			border:1px solid #98bf21;
			padding:3px 7px 2px 7px;
		}
		#edittab th 
		{
			font-size:1.1em;
			text-align:left;
			padding-top:5px;
			padding-bottom:4px;
			background-color:#4E9CE9;
			color:#ffffff;
			background-image: -webkit-gradient
			(
				linear,
				left top,
				left bottom,
				color-stop(0.19, #5AC5E0),
				color-stop(1, #4481EB)
			);
			background-image: -o-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -moz-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -webkit-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -ms-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: linear-gradient(to bottom, #5AC5E0 19%, #4481EB 100%);
		}
		#edittab tr.alt td 
		{
			color:#000000;
			background-color:#EAF2D3;
		}
	</style>
</head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<form action="#" method="POST" onLoad="_top">

<?php
include 'faculty.php';

$gid=$_SESSION['user'];
include 'db.php';

$sql2="SELECT name FROM faculty WHERE id='$gid'";
$result2=mysql_query($sql2);
$row2=mysql_fetch_array($result2);
$gname=$row2['name'];
$sql="SELECT distinct uid FROM request_component WHERE utype='Student' and gname='$gname' and status='pending'";
$result=mysql_query($sql);

if(mysql_num_rows($result) == 0)
{
	print "<br/><h3 style='color:red' align='center'>No Purchase Requests</h3>";
	header("refresh:1;faculty.php");
}
else
{
	print "<br/><h3 style='color:red' align='center'>Purchase Requests</h5>";
	echo "<table border='1' align='center' id='edittab' ><tr><th>No</th><th>Roll No</th><th>Name</th>";
	
	$v=1;
	$no=1;

	while($row = mysql_fetch_array($result))
	{
		$rno=$row['uid'];
		$sql1="SELECT * FROM student WHERE roll='$rno'";
		$result1=mysql_query($sql1);
		$row1=mysql_fetch_array($result1);
		
		if(($v%2)==0)
		{	
			echo "<tr class='alt'><td>".$no."</td>
			<td><a href='student_purchase_request_details.php?rno=".$row['uid']."&name=".$row1['name']."'>
			".$row['uid']."</a></td><td>".$row1['name']."</td></tr>";
		}
		else
		{
			echo "<tr><td>".$no."</td>
			<td><a href='student_purchase_request_details.php?rno=".$row['uid']."&name=".$row1['name']."'>
			<u>".$row['uid']."</u></a></td><td>".$row1['name']."</td></tr>";
		}
	$v++;
	$no++;
	}
	echo "</table>";
	echo "<br/><center/><input type=button value='back' onclick=window.location.href='faculty.php'></input>";
}
?>
</form>
</body>
</html>