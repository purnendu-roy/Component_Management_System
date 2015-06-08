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
<title>faculty</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="student_issue_request_details.php" method="POST" onLoad="_top">
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
	echo "<h3 style='color:red' align='center'>Issue requests by ".$name." (".$id.")</h3>";
	form($id,$name);
}
else if($_POST['approve'])
{
	approve();
}
else
{
	print "<br><h3 style='color:red' align='center'></h3><br>";
}
?>
<?php
function form($id,$name)
{
	$gid=$_SESSION['user'];
	include 'db.php';
	$sql2="SELECT name FROM faculty WHERE id='$gid'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$gname=$row2['name'];
	
	echo "<br><table border='1' align='center' id='edittab'><tr><th>No</th><th>Component</th><th>Category</th>
	<th>Sub Category</th><th>Description</th><th>Quantity</th><th>Request Date</th><th></th></tr>";
	
	$no=1;
	$v=1;
	
	$sql="SELECT * FROM request_issue WHERE uid='$id' and utype='Student' and gname='$gname' and status='pending'";
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
			echo "<tr class='alt'><td>".$no."</td><td><a href='issue_comp_details.php?id=".$cid."'>
			<u>".$row3['type']."</u></a></td><td>".$row3[2]."</td><td>".$row3[3]."</td>
			<td>".$row3[4]."</td><td><u><a href='edit_quantity.php?cid=$row[0]&id=$row[1]&name=$name&ut=Student'>
			".$row['quantity']."</a></u></td><td>".$row['rdate']."</td>
			<td><input type='checkbox' name='items[]' value='".$id."'></input></td></tr>";
		}
		else
		{
			echo "<tr><td>".$no."</td><td><a href='issue_comp_details.php?id=".$cid."'>
			<u>".$row3['type']."</u></a></td><td>".$row3[2]."</td><td>".$row3[3]."</td>
			<td>".$row3[4]."</td><td><u><a href='edit_quantity.php?cid=$row[0]&id=$row[1]&name=$name&ut=Student'>
			".$row['quantity']."</a></u></td><td>".$row['rdate']."</td>
			<td><input type='checkbox' name='items[]' value='".$id."'></input></td></tr>";
		}
	$v++;
	$no++;
	}
	echo "</table>";
	echo "<br/>";
	echo "<table align='center'><tr><td><input type='submit' name='approve' value='Approve Selected'></input>
	</td><td><input type='submit' name='dapprove' value='Disapprove Selected'></input></td>
	<td><button type='button' onclick='history.back();'>Back</button></td></tr>";

}

function approve()
{

	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			echo "<h3 align='center'>You didn't select any items</h3>";
			echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			$N = count($issue);
			for($i=0; $i<$N; $i++)
			{
				include 'db.php';
				$id=$issue[$i];
				$sql="UPDATE request_issue SET status='Approved' WHERE id='$id'";
				$result=mysql_query($sql);	
			}
			echo "<h3 style='color:red' align='center'>Requests Approved Successfully </h3><center/>";
			echo "<br/><br/><button type='button' onclick='history.back();'>Back</button>";
		}
	}
	else
	{
		echo "<h3 style='color:red' align='center'>You didn't select any items</h3>";
		echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
	
}

function dapprove()
{
	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			echo "<h3 style='color:red' align='center'>You didn't select any items</h3>";
			echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			$N = count($issue);
			for($i=0; $i < $N; $i++)
			{
				include 'db.php';
				$id=$issue[$i];
				$sql="UPDATE request_issue SET status='Disapproved' WHERE id='$id'";
				$result=mysql_query($sql);	
				
				$sql1="SELECT * FROM request_issue  WHERE id='$id'";
				$result1=mysql_query($sql1);	
				$row1 = mysql_fetch_array($result1);
				$cid=$row1['cid'];
				$quant=$row1['quantity'];
				
				$sql3="SELECT * from consumable where id='$cid'";
				$result3=mysql_query($sql3);
				$row3=mysql_fetch_array($result3);
				$aq=$row3['quantity'];
				$quant=$quant+$aq;
				
				$sql2="UPDATE consumable SET quantity='$quant' where id='$cid'";
				$result2=mysql_query($sql2);
			}
			echo "<h3 style='color:red' align='center'>Requests Disapproved Successfully </h3>";
			echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
		}
	}
	else
	{
		echo("<h3 style='color:red' align='center'>You didn't select any items.</h3>");
		echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
}
?>
</form>
</body>
</html>