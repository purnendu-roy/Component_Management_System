<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:login.php");
if($_SESSION['auth']!='Admin')
{
	session_destroy();
	header("Location:login.php");	
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
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="faculty_issue_details.php" method="POST" onLoad="_top">
<?php
include 'admin.php';
if(isset($_POST['allissue']))
{
	issueall();
}
else if(isset($_POST['selissue']))
{
	issue();
}
else
{
	$id=$_GET['id'];
	$_SESSION['issueuserid']=$_GET['id'];;
	form($id);
}
?>
<?php
function form($id)
{
	print "<br/><h3 style='color:red' align='center'>Issue Requests By ".$id."</h3>";
	echo "<br/><table border='1' align='center' id='edittab' ><tr><th>No</th><th>Component</th><th>Category</th>
	<th>Sub Category</th><th>Description</th><th>Quantity</th><th>Request Date</th><th></th></tr>";
	
	$v=1;
	$no=1;
	
	include 'db.php';
	
	$sql2="SELECT * FROM faculty where id='$id'";
	$result2=mysql_query($sql2);
	$row1=mysql_fetch_array($result2);
	$name=$row1['name'];
	
	$sql="SELECT * FROM request_issue where uid='$id' and  status='Approved'";
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		$id=$row['id'];
		$cid=$row['cid'];
		$sql3 = "SELECT * FROM consumable WHERE id='$cid'";
		$result3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($result3);

		if(($v%2)==0)
		{
			echo "<tr class='alt'><td>".$no."</td><td><a href='issue_comp_details.php?id=".$cid."'><u>
			".$row3['type']."</u></a></td><td>".$row3[2]."</td><td>".$row3[3]."</td>
			<td>".$row3[4]."</td><td><u><a href='edit_quantity.php?cid=$row[0]&id=$row[1]&name=$name&ut=Faculty'>
			".$row['quantity']."</a></u></td><td>".$row['rdate']."</td>
			<td><input type='checkbox' name='items[]' value='".$id."'></input></td></tr>";
		}
		else
		{
			echo "<tr><td>".$no."</td><td><a href='issue_comp_details.php?id=".$cid."'><u>
			".$row3['type']."</u></a></td><td>".$row3[2]."</td><td>".$row3[3]."</td><td>".$row3[4]."</td>
			<td><u><a href='edit_quantity.php?cid=$row[0]&id=$row[1]&name=$name&ut=Faculty'>
			".$row['quantity']."</a></u></td><td>".$row['rdate']."</td>
			<td><input type='checkbox' name='items[]' value='".$id."'></input></td></tr>";
		}
	$v++;
	$no++;
	}

	echo "</table>";
	echo "<br/><br/><table align='center'><tr><td><input type='submit' name='selissue' value='Issue Selected'>
	</input></td><td><input type='submit' name='allissue' value='Issue All'></input></td></tr></table>";
}

function issue()
{
	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			echo "<h3 align='center'>You didn't select any items</h3><center/>";
			echo "<br/><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			$_SESSION['issuecmp']=$issue;
			header("location:confirm_faculty_issue.php");
		}
	}
	else
	{	
		print "<br/><h3 style='color:red' align='center'>>You didn't select any items.</h3><center/>";
		echo "<br/><button type='button' onclick='history.back();'>Back</button>";
	}
}

function issueall()
{
	$_SESSION['issuecmp']='All';
	header("location:confirm_faculty_issue.php");
}
?>
</form>
</body>
</html>