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
<form action="student_return.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['rno']))
{
	echo "<br/><table align='center'><tr><td>Enter Roll No. : </td><td><input type='text' name='rno'></input>
	</td></tr></table><br/>
	<table align='center'><tr><td><input type='submit' name='submit' value='Submit'></input></td>
	<td><input type='reset' value='clear'></input></tr></table>";
}
else if($_POST['rno'])
{
	include 'db.php';
	$rno=$_POST['rno'];
	$sql="SELECT * FROM user_issue_consumable WHERE uid='$rno'";
	$result=mysql_query($sql);
	
	if(mysql_num_rows($result) == 0)
	{
			print "<br/><h3 style='color:red' align='center'>No Data Found</h3>";
			header("refresh:2,admin.php");
	}
	else
		header("location:student_return_details.php?rno=$rno");
}

else
{
	echo "<h4 align='center' style='color:red'>*Please enter roll number</h4>";
	echo "<br/><table align='center'><tr><td>Enter Roll No. : </td><td><input type='text' name='rno'></input>
	</td></tr></table><br/>
	<table align='center'><tr><td><input type='submit' name='submit' value='Submit'></input></td>
	<td><input type='reset' value='clear'></input></tr></table>";
}

?>
</form>
</body>
</html>