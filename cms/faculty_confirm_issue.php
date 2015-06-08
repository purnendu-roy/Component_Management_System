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
<form action="faculty_confirm_issue.php" method="POST" onLoad="_top">
<?php
include 'db.php';
include 'faculty.php';
if(!isset($_POST['quantity']))
{
	print "<br><h3 align='center'>Please enter required quantity</h3><br>";
	if(isset($_GET["id"]))
	{
		$_SESSION['issuecid']=$_GET["id"];
		$_SESSION['issuequant']=$_GET["quantity"];
	}
	form($_SESSION['issuecid'],$_SESSION['issuequant']);
}
else if($_POST['quantity'] && $_POST['pname'])
{
	issue();
}
else
{
	print "<br><h3 style='color:red' align='center'>Please enter the quantity</h3><br>";
   	form($_SESSION['issuecid'],$_SESSION['issuequant']);
}
?>
<?php
function form($cid,$quant)
{
	echo "<table align='center'><tr><td>Enter Quantity</td>
	<td><input 	type='text' name='quantity'></input></td><td style='color:red'>(".$quant." Available)";
	echo "<tr><td>Project Name</td><td><input type='text' name='pname'></input></td>";
	echo "<tr></tr>";
	echo "<tr></tr>";
	echo "<br><tr><td><input type='submit' value='Submit'></input></td>
	<td><input type='reset' value='Clear'></input></td>
	<td><input type=button value='back' onclick=window.location.href='faculty.php'></input></td></tr>";
}
function issue()
{
	$quant=$_POST['quantity'];
	$cid=$_SESSION['issuecid'];
	$pname=$_POST['pname'];
	$gname='';
	$aquant=$_SESSION['issuequant'];
	
	if($quant>$aquant)
	{
		echo "<br><h3 style='color:red' align='center'>Error!. Only ".$aquant." Quantities are
		avilable</h3><br>";
	   echo "<br/><center/><input type=button value='back' onclick=window.location.href='faculty.php'></input>";
	}
	else
	{
		include 'db.php';
		$sql="select MAX(id) AS id from request_issue";
		$res=mysql_query($sql);
		$row = mysql_fetch_array($res);
		$id=$row['id'];
		$id=$id+1;
		$uid=$_SESSION['user'];
		$utype=$_SESSION['auth'];
		$rd = date("d/m/Y");
		$status='Approved';
		
		$sql="INSERT INTO request_issue values('$id','$uid','$utype','$cid','$quant','$pname','$gname','$rd',
		'$status')";
		$result=mysql_query($sql);
		if($result)
		{
			echo "<h4 style='color:red' align='center'>Issue Request Successful</h4>";
			$q=$aquant-$quant;
			$sql="UPDATE consumable SET quantity='$q' WHERE id='$cid'";
			$result=mysql_query($sql);
		}
	  echo "<br/><center/><input type=button value='back' onclick=window.location.href='faculty.php'></input>";
	}
}
?>
</form>
</body>
</html>