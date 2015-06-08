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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="staff_confirm_issue1.php" method="POST" onLoad="_top">
<?php
include 'db.php';
include 'staff.php';
if(!isset($_POST['quantity']))
{
	
		print "<br><h3>Please enter required quantity</h3>			<br>";
	if(isset($_GET["id"]))
	{
		$_SESSION['issuecid']=$_GET["id"];
		$_SESSION['issuequant']=$_GET["quantity"];
	}
		form($_SESSION['issuecid'],$_SESSION['issuequant']);
}
else if($_POST['quantity'] && $_POST['gname'] )
{
	issue();
}
else
{

	print "<br><h3 style='color:red'>Please enter the quantity</h3><br>";
     	form($_SESSION['issuecid'],$_SESSION['issuequant']);
}
function form($cid,$quant)
{
	$uid=$_SESSION['user'];
	echo $uid;
	echo "<table><tr><td>Enter Quantity</td><td><input 	type='text' name='quantity'></input></td>
	<td style='color:red'>(".$quant." Available)";
	echo "</td></tr><tr><td>Faculty in charge</td><td>";
?>
	<select name='gname'>
	<option>----------------</option>
<?php
	//$uid=$_SESSION['user'];
	include 'db.php';
	$sql="SELECT lab FROM staff where id='$uid'";
 	$result=mysql_query($sql);
	
	$row = mysql_fetch_array($result);
	$lab=$row['lab'];
	$sql="SELECT name FROM faculty where lab='$lab'";
 	$result=mysql_query($sql);
	 while($row = mysql_fetch_array($result))
   	{
   
   			echo "<option>".$row['name']."</option>";
   	}

?>
</select>
</td>
<?php
echo "<td><h1 style='color:red'>*</h1></td>";
echo "<tr><td><input type='submit' value='Submit'></input></td></tr>";
}
function issue()
{
$quant=$_POST['quantity'];
$pname='';
$gname=$_POST['gname'];
$cid=$_SESSION['issuecid'];
$aquant=$_SESSION['issuequant'];
if($quant>$aquant)
{
	echo "<br><h3 style='color:red'>Error!. Only ".				$aquant." Quantities are avilable</h3><br>";
?>
<br>
<button type="button" onclick="history.back();">Back</button>
<?php
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
	$status='Pending';
	$sql="INSERT INTO request_issue values('$id','$uid','$utype','$cid','$quant','$pname','$gname','$rd','$status')";
	$result=mysql_query($sql);
	if($result)
	{
	echo "<h4 style='color:red'>Issue Request Successful</h4>";
	$q=$aquant-$quant;
	$sql="UPDATE component SET quantity='$q' WHERE id='$cid'";
	$result=mysql_query($sql);

	}
?>
<br>
<button type="button" onclick="location.href = 'staff.php';">Back</button>
<?php
	
}
}
?>

