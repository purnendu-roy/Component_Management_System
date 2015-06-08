<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
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
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:70%;
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
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="faculty_return.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['name']))
{
	include 'db.php';
	
	echo "<table align='center'><tr><td>Select Faculty:</td><td><select name='name' style='width:173px'>";
	$sql2 = " SELECT name from faculty ORDER BY name";
	$result2 = mysql_query($sql2);
	
	while($row2 = mysql_fetch_array($result2))
	{
		echo "<option >".$row2['name']."</option>";
	}
	echo "</select></td><td><input type='submit' name='submit' value='GO'></input></td></tr>";   
}
else if($_POST['name'])
{
	$name=$_POST['name'];
	include 'db.php';
	
	$sql1="SELECT * FROM faculty WHERE name='$name'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	$id=$row1['id'];
	
		mysql_connect('localhost', 'root' ,'shanoo')or die('cannot connect'); 
		mysql_select_db('test123')or die('cannot select DB');
		
	$sql="SELECT * FROM user_issue_consumable WHERE uid='$id'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
			print "<br/><h3 style='color:red' align='center'>No Data Found</h5>";
			header("refresh:2,admin.php");
	}
	else
		header("location:faculty_return_details.php?rno=$id&name=$name");
}
else
{
	include 'db.php';
	
	echo "<table align='center'><tr><td>Select Faculty</td><td><select name='name' style='width:173px'>";
	$sql2 = " SELECT name from faculty ORDER BY name";
	$result2 = mysql_query($sql2);
	while($row2 = mysql_fetch_array($result2))
	{
		echo "<option >".$row2['name']."</option>";
	}
	echo "</select></td><td><input type='submit' name='submit' value='GO'></input></td></tr>";   
}
?>
</form>
</body>
</html>