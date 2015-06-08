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
<form action="staff_purchase_request_details.php" method="POST" onLoad="_top">
<?php
include 'faculty.php';

if(isset($_POST['dapprove']))
{
	dapprove();
}
else if(!isset($_POST['approve']))
{
	$id=$_GET["rno"];
	$name=$_GET["name"];
	print "<br><h3 style='color:red' align='center'>Purchase requests by ".$name." (".$id.")</h3>";
	form($id);
}
else if($_POST['approve'])
{
	approve();
}
else
{
	print "<br><h3 style='color:red'></h3><br>";
}
?>
<?php
function form($id)
{
	$gid=$_SESSION['user'];
	include 'db.php';
	
	$sql2="SELECT name FROM faculty WHERE id='$gid'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$gname=$row2['name'];
	
	echo "<br/><table border='1' align='center' id='edittab'><tr><th>No</th><th>Component Name</th>
	<th>Project Name</th><th>Description</th><th>Quantity</th><th>Manufacturer</th><th>Part Number</th>
	<th>Request Date</th><th>Required By</th><th></th></tr>";
	
	$no=1;
	$v=1;
	
	$sql="SELECT * FROM request_component WHERE uid='$id' and utype='Staff' and gname='$gname' and
	status='pending'";
	
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		$id=$row['id'];
		
		if(($v%2)==0)
		{
			echo "<tr class='alt'><td>".$no."</td><td>".$row[4]."</td><td>".$row[3]."</td>
			<td>".$row[7]."</td><td>".$row[8]."</td><td>".$row[9]."</td><td>".$row[10]."</td>
			<td>".$row[12]."</td><td>".$row[11]."</td>
			<td><input type='checkbox' name='items[]' value='".$id."'></input></td></tr>";
		}
		else
		{
			echo "<tr><td>".$no."</td><td>".$row[4]."</td><td>".$row[3]."</td><td>".$row[7]."</td>
			<td>".$row[8]."</td><td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[12]."</td>
			<td>".$row[11]."</td><td><input type='checkbox' name='items[]' value='".$id."'></input></td></tr>";
		}
	$v++;
	$no++;
	}
	echo "</table>";
	echo "<br><br><table align='center'><tr><td><input type='submit' name='approve' value='Approve Selected'>
	</input></td><td><input type='submit' name='dapprove' value='Disapprove Selected'></input></td>
	<td><button type='button' onclick='history.back();'>Back</button></tr></table>";

}

function approve()
{
	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			echo "<h3 align='center'>You didn't select any items</h3>";
			echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			$N = count($issue);
			include 'db.php';
			
			for($i=0; $i < $N; $i++)
			{
				$id=$issue[$i];
				$sql="UPDATE request_component SET status='Approved' WHERE id='$id'";
				$result=mysql_query($sql);
			}
			echo "<h4 align='center' style='color:red'>Requests Approved Successfully </h4>";
			echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
	}
	else
	{
		echo "<h3 align='center'>You didn't select any items</h3>";
		echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
}

function dapprove()
{
	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			echo "<h3 align='center'>You didn't select any items</h3>";
			echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			$N = count($issue);
			include 'db.php';
			
			for($i=0; $i < $N; $i++)
			{

				$id=$issue[$i];
				$sql="UPDATE request_component SET status='Disapproved' WHERE id='$id'";
				$result=mysql_query($sql);	
			}
			echo "<h3 align='center' style='color:red'>Requests Disapproved Successfully </h3>";
			echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
	}
	else
	{
		echo "<h3 align='center'>You didn't select any items</h3>";
		echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
}
?>
</form>
</body>
</html>