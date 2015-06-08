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
			width:90%;
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
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="damaged_components.php" method="POST" onLoad="_top">
<?php
include 'admin.php';
include 'db.php';

$sql="SELECT * FROM capital WHERE status='Damaged'";
$result=mysql_query($sql);
if(mysql_num_rows($result)==0)
{
	echo "<h3 style='color:red' align='center'>No damaged components</h3>";
	header("refresh:2,admin.php");
}
else
{
	print "<br/><h3 style='color:red' align='center'>Damaged Components</h3><br/>";
	echo "<table border='1' align='center' id='edittab' ><tr><th>No.</th><th>Name</th><th>Category</th>
	<th>Description</th><th>Supplier</th><th>Bill No.</th><th>Purchase Date</th><th>Warranty</th>
	<th>Manufacturer</th><th>Reference No.</th><th>Location</th><th>Remarks</th><th></th></tr>";
	
	$v=1;
	$no=1;
	
	while($row = mysql_fetch_array($result))
	{
		if(($v%2)==0)
		{	
			echo "<tr class='alt'><td>".$no."</td><td>".$row[1]."</td><td>".$row[2]."</td>
			<td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[6]."</td><td>".$row[10]."</td>
			<td>".$row[9]."</td><td>".$row[8]."</td><td>".$row[7]."</td><td>";
			
			if($row['status']=='Available')
				echo "Store";
			else if($row['status']=='Issued')
			{
				$id=$row[0];
				$sql1="SELECT location FROM issue_capital where cid='$id'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				$loc=$row1['location'];
				echo "$loc";
			}
			else
			{
				$id=$row[0];
				$sql1="SELECT location FROM issue_capital where cid='$id'";
				$result1=mysql_query($sql1);
				$count=mysql_num_rows($result1);
				if($count==1)
				{
					$row1=mysql_fetch_array($result1);
					$loc=$row1['location'];
					echo "$loc";
				}
				else
					echo "Store";
			}
			echo "</td><td>".$row[15]."</td><td><u><a href='repair_dmg.php?id=$row[0]'>Repaired</a></u></td>";
		}
		else
		{
			echo "<tr><td>".$no."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>
			<td>".$row[4]."</td><td>".$row[6]."</td><td>".$row[10]."</td><td>".$row[9]."</td>
			<td>".$row[8]."</td><td>".$row[7]."</td><td>";
			
			if($row['status']=='Available')
				echo "Store";
			else if($row['status']=='Issued')
			{
				$id=$row[0];
				$sql1="SELECT location FROM issue_capital where cid='$id'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				$loc=$row1['location'];
				echo "$loc";
			}
			else
			{
				$id=$row[0];
				$sql1="SELECT location FROM issue_capital where cid='$id'";
				$result1=mysql_query($sql1);
				$count=mysql_num_rows($result1);
				if($count==1)
				{
					$row1=mysql_fetch_array($result1);
					$loc=$row1['location'];
					echo "$loc";
				}
				else
					echo "Store";
			}
			echo "</td><td>".$row[15]."</td><td><u><a href='repair_dmg.php?id=$row[0]'>Repaired</a></u></td>";
		}
	$no++;	
	$v++;
	}
}
?>
</form>
</body>
</html>