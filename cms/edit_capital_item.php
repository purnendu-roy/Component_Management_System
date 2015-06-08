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
	<style>
		#edittab
		{
		font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
		width:90%;
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
		}
		#edittab tr.alt td 
		{
		color:#000000;
		background-color:#EAF2D3;
		}
	</style>
</head>
<body>

<form action="edit_capital_item.php" method="POST" onLoad="_top">

<?php

	if(!isset($_POST['submit']))
	{
		print "<br/><h3 align='center' style='color:blue'><b>Edit Item</b> </h5>";
		$cid=$_GET['id'];
		$_SESSION['editcid']=$_GET['id'];
		addform($cid);
	}
	else if($_POST['submit'] && $_POST['status'] && $_POST['remarks'])
	{
		edit();
	}
	else
	{
		echo "<h4 align='center' style='color:red'>Marked fields are compulsory</h4>";
		$id=$_SESSION['editcid'];
		addform($id);
	}
?>

<?php
function addform($cid)
{
    include 'db.php';
	$sql="select * from capital where id='$cid'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	echo "<table align='center'><tr><td>Name of Item</td><td><input type='text' value='".$row['name']."'
	disabled='disabled'></input></td></tr>";
	echo "<tr><td>Category</td><td><input type='text' value='".$row['category']."'
	disabled='disabled'></input></td></tr>";
	echo "<tr><td>Description</td><td><input type='text' value='".$row['description']."'
	disabled='disabled'></input></td></tr>";
	echo "<tr><td>Supplier</td><td><input type='text' value='".$row['supplier']."'
	disabled='disabled'></input></td></tr>";
	echo "<tr><td>Bill No.</td><td><input type='text' value='".$row['bno']."'
	disabled='disabled'></input></td></tr>";
	echo "<tr><td>Reference No</td><td><input type='text' value='".$row['refno']."'
	disabled='disabled'></input></td></tr>";
	echo "<tr><td>Status</td><td><select name='status' style='width:173px;'>
	<option></option>
	<option>Damaged</option>
	</select></td><td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
	echo "<tr><td>Remarks</td><td><textarea name='remarks' cols='14' rows='3'style='width:169px;'></textarea></td><td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
	echo "<tr><td><input type='submit' name='submit' value='Update'></input></td></tr>";
}
?>

<?php
function edit()
{
	$id=$_SESSION['editcid'];
	$status=$_POST['status'];
	$remarks=$_POST['remarks'];
	include 'db.php';
	$sql="update capital set status='$status', remarks='$remarks' where id='$id'";
	$result=mysql_query($sql);
	if($result)
		echo "<h4 align='center' style='color:red'></b>Updated Successfully</h4>";
	
	header("refresh:2; url=edit_capital.php");
}
?>
</body>
</html>