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

<form action="ci_student.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['submit']))
{
	display();
}
else if(isset($_POST['submit']) && isset($_POST['rno']))
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
	
	$sql="SELECT * FROM user_issue_consumable where utype='Student'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
		print "<br/><h3 style='color:red' align='center'>No Data Found</h3>";
		header("refresh:2,admin.php");
	}
	else
	{
		$sql1="SELECT DISTINCT uid FROM user_issue_consumable where utype='Student'";
		$result1=mysql_query($sql1);
		print "<br/><h3 style='color:red' align='center'>Components Issued to Students</h3>";
		
		echo "<table align='center'><tr><td>Enter roll no to filter</td><td><select name='rno'><option/>";
		
		while($r = mysql_fetch_array($result1))
			echo "<option>".$r['uid']."</option>";
		echo "</select>";
		echo "</td><td><input type='submit' name='submit' value='GO'></input></td></tr></table><br/><br/>";  
		echo "<br/><table border='1' align='center' id='edittab'><tr><th>No</th><th>Roll No</th><th>Name</th>
		<th>Type</th><th>Category</th><th>Sub Category</th><th>Description</th><th>Quantity</th>
		<th>Issue Date</th><th>Return Date</th>";
		
		$v=1;
		$no=1;
		
		while($row = mysql_fetch_array($result))
		{
			$rno=$row['uid'];
			$cid=$row['cid'];
			$sql1="SELECT * FROM student WHERE roll='$rno'";
			$result1=mysql_query($sql1);
			$row1=mysql_fetch_array($result1);
			$name=$row1['name'];
			
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
				<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td><td>".$cat."</td>
				<td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td><td>".$row['idate']."</td>
				<td>".$row['rdate']."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$no."</td><td>".$rno."</td><td>".$name."</td>
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
	if(!empty($_POST['rno']))
	{
		$rno=$_POST['rno'];
		include 'db.php';
		
		$sql="SELECT * FROM user_issue_consumable WHERE uid='$rno'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result) == 0)
		{
			print "<br/><h3 style='color:red' align='center'>No Data Found</h3>";
			header("refresh:2,admin.php");
		}
		else
		{
			$sql1="SELECT distinct uid FROM user_issue_consumable WHERE utype='student'";
			$result1=mysql_query($sql1);
			
			print "<br/><h3 style='color:red' align='center'>Components Issued to ".$rno."</h3>";
			echo "<table align='center'><tr><td>Enter roll no to filter</td><td><select name='rno'><option/>";
			
			while($r = mysql_fetch_array($result1))
				echo "<option>".$r['uid']."</option>";
			echo "</select>";
			echo "</td><td><input type='submit' name='submit' value='GO'></input></td></tr></table><br/><br/>";  
			echo "<br/><table border='1' align='center' id='edittab' ><tr><th>No</th><th>Roll No</th>
			<th>Name</th><th>Type</th><th>Category</th><th>Sub Category</th><th>Description</th>
			<th>Quantity</th><th>Issue Date</th><th>Return Date</th>";	
			
			$v=1;
			$no=1;
			
			while($row = mysql_fetch_array($result))
			{
				$rno=$row['uid'];
				$cid=$row['cid'];
				$sql1="SELECT * FROM student WHERE roll='$rno'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				$name=$row1['name'];
				
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
					<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td><td>".$cat."</td>
					<td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$no."</td><td>".$rno."</td><td>".$name."</td>
					<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td><td>".$cat."</td>
					<td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
			$v++;
			$no++;
			}
		}
	}
	else
		display();
}
?>
</form>
</body>
</html>