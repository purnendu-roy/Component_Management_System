<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']=='Staff' || $_SESSION['auth']=='Staff')
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
<title>CMS</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="edit_quantity.php" method="POST">
<?php
if($_SESSION['auth']=='Faculty')
	include 'faculty.php';
else if($_SESSION['auth']=='Admin')
	include 'admin.php';
else
{
	session_destroy();
	header("Location:index.php");
}
if(!isset($_POST['submit']))
{
	$cid=$_GET['cid'];
	$id=$_GET['id'];
	$name=$_GET['name'];
	$_SESSION['editquancid']=$_GET['cid'];
	$_SESSION['editquanid']=$_GET['id'];
	$_SESSION['editquanname']=$_GET['name'];
	$_SESSION['editut']=$_GET['ut'];
	form($cid);
}
else if($_POST['submit'] && $_POST['quan'])
{
	$q=$_POST['quan'];
	if($q>0)
	    updateq();
	else
	{
		echo "<h4 style='color:red' align='center'>Invalid quantity</h4>";
		$cid=$_SESSION['editquancid'];
		form($cid);
	}
}
else
{
	echo "<h4 style='color:red' align='center'>Please enter quantity</h4>";
	$cid=	$_SESSION['editquancid'];
	form($cid);
}
?>
<?php
function form($cid)
{
	include 'db.php';
	$sql2="SELECT * FROM request_issue WHERE id='$cid'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	echo "<table align='center'><tr><td>Enter Quantity</td>
	<td><input type='text' name='quan' value='".$row2['quantity']."'/></td></tr>
	<tr><td><input type='submit' name='submit' value='Update'/></td>";
	echo "<td><button type='button' onclick='history.back();'>Back</button></td></tr></table>";
}
function updateq()
{
	$q=$_POST['quan'];
	$cid=$_SESSION['editquancid'];
	$id=$_SESSION['editquanid'];
	$name=$_SESSION['editquanname'];
	
	include 'db.php';
	
	$sql="SELECT * FROM request_issue WHERE id='$cid'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$quantity=$row['quantity'];
	$compid=$row['cid'];
	
	$sql1="SELECT * FROM consumable WHERE id='$compid'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	$aq=$row1['quantity'];
	$qq=$quantity+$aq;
	
	if($qq>=$q)
	{	
		if($quantity>$q)
		{
			$nq=$quantity-$q;
			$aq=$aq+$nq;
		}
		if($quantity<$q)
		{	
			$nq=$q-$quantity;
			$aq=$aq-$nq;	
		}
		$sql4="UPDATE consumable SET quantity='$aq' WHERE id='$compid'";
		$result4=mysql_query($sql4);	
		$sql2="UPDATE request_issue SET quantity='$q' WHERE id='$cid'";
		$result2=mysql_query($sql2);
		if($result2)
		{
			echo "<h4 style='color:red' align='center'>Updated successfully</h4>";
			$utype=$_SESSION['editut'];
			if($_SESSION['auth']=='Faculty')
			{
				if($utype=='Student')
					header("Refresh:1;student_issue_request_details.php?rno=$id&name=$name");
				if($utype=='Staff')
					header("Refresh:1;staff_issue_request_details.php?rno=$id&name=$name");
			}
			else
			{	
				if($utype=='Student')
					header("Refresh:1;student_issue_details.php?rno=$id");
				if($utype=='Faculty')
					header("Refresh:1;faculty_issue_details.php?id=$id");
				if($utype=='Staff')
					header("Refresh:1;lab_issue_details.php?id=$id");
			}
		}
	}
	else
	{
		echo "<h4 style='color:red' align='center'>Error..! Only ".$qq." quantities are available</h4>";
		$cid=$_SESSION['editquancid'];
		form($cid);	
	}
}
?>
</form>
</body>
</html>