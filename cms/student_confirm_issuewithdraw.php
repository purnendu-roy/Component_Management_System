<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Student')
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
<title>student</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<?php
	include 'student.php';
	$id=$_GET["id"];
	include 'db.php';
	
	$sql="SELECT * from request_issue where id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
	if($row['status']=='Disapproved')
	{
		$sql="DELETE FROM request_issue where id='$id'";
		$result=mysql_query($sql);
		echo "<h3 style='color:red' align='center'>Request withdrawn successfully </h3>";
		echo "<br/><input type=button value='back' onclick=window.location.href='student.php' ></input>";
	}
	else
	{
		$q=$row['quantity'];
		$cid=$row['cid'];
		$sql="SELECT * from consumable where id='$cid'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$aq=$row['quantity'];
		$quant=$q+$aq;
		
		$sql="UPDATE consumable SET quantity='$quant' where id='$cid'";
		$result=mysql_query($sql);
		
		$sql="DELETE FROM request_issue where id='$id'";
		$result=mysql_query($sql);
		if($result)
			echo "<h3 style='color:red' align='center'>Request withdrawn successfully </h3>";

		echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
?>
