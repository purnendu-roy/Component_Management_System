<?php
include 'admin.php';
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
</head>
<body>
	<div id="center_addtext"><br>
	<form action="add_sc_spec.php" method="POST" onLoad="_top">
<?php

	if(!isset($_POST['f1']))
	{
		$c=$_GET['category'];
		$_SESSION['sccat']=$_GET['category'];
		echo "<h4 align='center' style='color:red;'>Specifications of ".$c.":</h4>";
		form();
	}
	else if($_POST['f1'])
	{
		addspec();

	}
	else
	{
		print "<h5 align='center'>Please enter the following details</h5>";
     	form();
	}
	
function form()
{
		echo "<table align='center'>
		<tr>
		<td>Spec 1 : </td>
		<td><input type='text' name='f1' size='30'></td>
		</tr>
		<tr>
		<td>Spec 2 : </td>
		<td><input type='text' name='f2' size='30'></td>
		</tr>
		<tr>
		<td>Spec 3 : </td>
		<td><input type='text' name='f3' size='30'></td>
		</tr>
		<tr>
		<td>Spec 4 : </td>
		<td><input type='text' name='f4' size='30'></td>
		</tr>
		<tr>
		<td>Spec 5 : </td>
		<td><input type='text' name='f5' size='30'></td>
		</tr>
		<tr>
		<td>Spec 6 : </td>
		<td><input type='text' name='f6' size='30'></td>
		</tr>
		<tr>
		<td>Spec 7 : </td>
		<td><input type='text' name='f7' size='30'></td>
		</tr>
		<tr>
		<td>Spec 8 : </td>
		<td><input type='text' name='f8' size='30'></td>
		</tr>
		<tr>
		<td>Spec 9 : </td>
		<td><input type='text' name='f9' size='30'></td>
		</tr>
		<tr>
		<td>Spec 10 : </td>
		<td><input type='text' name='f10' size='30'></td>
		</tr>
		<tr></tr>
		<tr>
		<td><br><br><input type='submit' name='Add' Value='Submit'></td>
		<td><br><br><input type='Reset' name='Reset'></td>
		</tr>
		</table>";
}

//add specification  function
function addspec()
{
	include 'db.php';
	$f1=$_POST['f1'];
	$f2=$_POST['f2'];
	$f3=$_POST['f3'];
	$f4=$_POST['f4'];
	$f5=$_POST['f5'];
	$f6=$_POST['f6'];
	$f7=$_POST['f7'];
	$f8=$_POST['f8'];
	$f9=$_POST['f9'];
	$f10=$_POST['f10'];
	$type=$_SESSION['sccat'];
	
	$sql="select id from specification";
	$res=mysql_query($sql);
	$count=mysql_num_rows($res);
	$id=$count+1;
	$sql="INSERT INTO specification values('$id','$type','$f1','$f2','$f3','$f4','$f5','$f6','$f7','$f8','$f9',
	'$f10')";
	$result=mysql_query($sql);
	if($result)
		echo "<b><h4 style='color:red' align='center'>Specifications of ".$type." added</h4></b>";
	else
		echo "<h4 style='color:red'>Error</h4>";

	echo "<br><center><input type=button onClick=location.href='admin.php' value='back'/></center>";

}
?>
</div>
</body>
</html>