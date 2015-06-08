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
			width:90%;
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
<form action="purchase_requests_item.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['submit']))
{
	$id=$_GET['id'];
	$_SESSION['cmppid']=$_GET['id'];
	form();
}
else if($_POST['submit'] && $_POST['refno'])
{
	update();
}
else
{
	echo "<h4 align='center' style='color:red'>Please enter reference number</h4>";
	form();
}

function form()
{
	echo "<br/><table align='center'><tr><td>Enter Reference No. :</td>
	<td><input type='text' name='refno'></input></td></tr>
	<tr><td><input type='submit' name='submit' value='Submit'></input></td></tr>";
}
function update()
{
	$refno=$_POST['refno'];
	$_SESSION['caprefno']=$_POST['refno'];
	include 'db.php';
	$id=$_SESSION['cmppid'];
	$sql="UPDATE request_component SET status='Purchased',refno='$refno' where id='$id'";
	$result=mysql_query($sql);
	$sql1="SELECT * FROM request_component where id='$id'";
	$result1=mysql_query($sql1);
	$row=mysql_fetch_array($result1);
	$ctype=$row[5];
	if($ctype=='Capital')
		header("location:add_capital_item.php");
	else
		header("location:add_consumable_item.php");
}
?>
</form>
</body>
</html>