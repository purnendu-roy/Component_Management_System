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
			width:80%;
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
<form action="ci_faculty.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['submit']))
{
	display();
}
else if(isset($_POST['submit']) && isset($_POST['name']))
{
	dis();
}
else
{
}
?>
<?php
function display()
{
	include 'db.php';
	
	$sql="SELECT * FROM user_issue_consumable where utype='Faculty'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
			print "<br/><h3 style='color:red' align='center'>No Data Found</h3>";
			header("refresh:2,admin.php");
	}
	else
	{
		print "<br/><h3 style='color:red' align='center'>Components Issued to Faculty</h3>";
		echo "<table align='center'><tr><td>Enter faculty name to filter</td>
		<td><select name='name'><option>---------------</option>";
		$sql2 = " SELECT name from faculty";
		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2))
		{
			echo "<option >".$row2['name']."</option>";
		}
		echo "</select></td><td><input type='submit' name='submit' value='GO'></input></td></tr></table><br/>";   	   
		echo "<br/><br/><table border='1' align='center' id='edittab' ><tr><th>No</th><th>Faculty ID</th>
		<th>Name</th><th>Lab</th><th>Type</th><th>Category</th><th>Sub Category</th><th>Description</th>
		<th>Quantity</th><th>Issue Date</th><th>Return Date</th></tr>";
		
		$v=1;
		$no=1;
		
		while($row = mysql_fetch_array($result))
		{
			$rno=$row['uid'];
			$cid=$row['cid'];
			
			$sql1="SELECT * FROM faculty WHERE id='$rno'";
			$result1=mysql_query($sql1);
			$row1=mysql_fetch_array($result1);
			$name=$row1['name'];
			$lab=$row1['lab'];
			
			$sql2="SELECT * FROM consumable WHERE id='$cid'";
			$result2=mysql_query($sql2);
			$row2=mysql_fetch_array($result2);
			$type=$row2['type'];
			$cat=$row2['category'];
			$sub=$row2['subcat'];
			$des=$row2['description'];
			
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$no."</td><td>".$rno."</td><td>".$name."</td>
				<td>".$lab."</td><td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
				<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
				<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$no."</td><td>".$rno."</td><td>".$name."</td><td>".$lab."</td>
				<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td><td>".$cat."</td>
				<td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td><td>".$row['idate']."</td>
				<td>".$row['rdate']."</td></tr>";
			}
		$v++;
		$no++;
		}
	}
}

function dis()
{
	$name=$_POST['name'];
	include 'db.php';
	
	$sql1="SELECT * FROM faculty WHERE name='$name'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	$id=$row1['id'];
	
	$sql="SELECT * FROM user_issue_consumable WHERE uid='$id'";
	$result=mysql_query($sql);
	
	if(mysql_num_rows($result) == 0)
	{   
		print "<br/><h3 style='color:red' align='center'>No Data Found</h3>";
		header("refresh:2,admin.php");
	}
	else
	{
		print "<br/><h3 style='color:red' align='center'>Components Issued to ".$name."</h3>";
		echo "<table align='center'><tr><td>Enter faculty name to filter</td><td><select name='name'>";
		$sql2 = " SELECT name from faculty";
		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2))
		{
			echo "<option >".$row2['name']."</option>";
		}
		echo "</select></td><td><input type='submit' name='submit' value='GO'></input></td></tr></table><br/>";   	   
		echo "<br/><br/><table border='1' align='center' id='edittab' ><tr><th>No</th><th>Faculty ID</th>
		<th>Name</th><th>Lab</th><th>Type</th><th>Category</th><th>Sub Category</th><th>Description</th>
		<th>Quantity</th><th>Issue Date</th><th>Return Date</th>";
		
		$v=1;
		$no=1;
		
		while($row = mysql_fetch_array($result))
		{
			$rno=$row['uid'];
			$cid=$row['cid'];
			
			$sql1="SELECT * FROM faculty WHERE id='$rno'";
			$result1=mysql_query($sql1);
			$row1=mysql_fetch_array($result1);
			$name=$row1['name'];
			$lab=$row1['lab'];
			
			$sql2="SELECT * FROM consumable WHERE id='$cid'";
			$result2=mysql_query($sql2);
			$row2=mysql_fetch_array($result2);
			$type=$row2['type'];
			$cat=$row2['category'];
			$sub=$row2['subcat'];
			$des=$row2['description'];
			
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$no."</td><td>".$rno."</td><td>".$name."</td><td>".$lab."</td><td>
				<a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td><td>".$cat."</td>
				<td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td><td>".$row['idate']."</td>
				<td>".$row['rdate']."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$no."</td><td>".$rno."</td><td>".$name."</td><td>".$lab."</td><td>
				<a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td><td>".$cat."</td>
				<td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td><td>".$row['idate']."</td>
				<td>".$row['rdate']."</td></tr>";
			}
		$v++;
		$no++;
		}
	}
}
?>
</form>
</body>
</html>