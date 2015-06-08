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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>faculty</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="faculty_request_purchase.php" method="POST" onLoad="_top">

<?php
include 'faculty.php';

if(!isset($_POST['pname']))
{
	print "<h3 align='center' style='color:grey'>Please enter the following details</h3>";
    form();
}
else if($_POST['pname'] && $_POST['cname'] && $_POST['des'] && $_POST['quant'])
{
	request();
}
else
{

	print "<h3 align='center' style='color:red'>Marked fields are compulsory</h3>";
    form();
}
?>
<?php
function form()
{
	echo "<table align='center' style='color:black'><tr><td>Project Name : </td>";
	echo "<td><input type='text' name='pname'></input>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "</tr><tr><td>Name of Component : </td><td>";
	echo "<input type='text' name='cname'></input>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr><td>Description :</td><td><textarea name='des' cols='19' rows='3' style='width:173px'></textarea>
	&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	//echo "<td><h1 style='color:red'>*</h1></td>";
	echo "<tr><td>Quantity :</td><td><input type='text' name='quant'></input>
	&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	//echo "<td><h1 style='color:red'>*</h1></td>";
	echo "<tr><td>Manufacturer(if known):</td><td><input type='text' name='manu'></input></td>";
	echo "<tr><td>";
	echo "<tr><td>Part Number(if known):</td><td><input type='text' name='part'></input></td>";
	echo "<tr><td>";
	echo "<tr><td>Required By:</td>";
	echo "<td>
		<select name='required' style='width:173px'>
			<option>3 Month</option>
			<option>1-3 Month</option>
			<option>Within 1 Month</option>
		</select>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr><td>";
	echo "<input type='submit' name='add' value='Submit' id='submit'></input></td>";
	echo "<td><input type='reset' name='reset' value='Reset'></input>";
	echo "</td></tr></table>";	
}

function request()
{
	include 'db.php';
	$sql="select MAX(id) AS id from request_component";
	$res=mysql_query($sql);
	$row = mysql_fetch_array($res);
	$id=$row['id'];
	$id=$id+1;
	$uid=$_SESSION['user'];
	$utype='Faculty';
	$pname=$_POST['pname'];
	$cname=$_POST['cname'];
	$ctype='Consumable';
	$des=$_POST['des'];
	$gname='';
	$quant=$_POST['quant'];
	$manu=$_POST['manu'];
	$pno=$_POST['part'];
	$rby=$_POST['required'];
	$rdate = date("d/m/Y");
	$status='Approved';
	
	$sql="INSERT INTO request_component values('$id','$uid','$utype','$pname','$cname','$ctype','$gname','$des',
	'$quant','$manu','$pno','$rby','$rdate','$status','')";
	
	$result=mysql_query($sql);
	if($result)
	{
		echo "<h4 align='center' style='color:red'>Added Successfully</h4>";
		echo "<br/><center/><input type=button value='back' onclick=window.location.href='faculty.php' ></input>";

	}
	else
	{
		echo "<h4 align='center' style='color:red'>Invalid input</h4>";
		addform();	
	}

}
?>
