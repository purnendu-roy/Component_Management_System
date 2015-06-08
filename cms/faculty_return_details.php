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
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="faculty_return_details.php" method="POST" onLoad="_top">

<?php
include 'admin.php';

if(isset($_POST['allreturn']))
{
	returnall();
}
else if(isset($_POST['selreturn']))
{
	cmpreturn();
}
else
{
	$id=$_GET['rno'];
	$name=$_GET['name'];
	$_SESSION['issueuserid']=$_GET['rno'];
	print "<br/><h3 style='color:red' align='center'>Components issued to ".$name."</h5>";
	form($id);
}
?>
<?php
function form($id)
{
	echo "<br><table border='1' align='center' id='edittab' ><tr><th>No</th><th>Component</th><th>Category</th>
	<th>Sub Category</th><th>Description</th><th>Quantity</th><th>Issue Date</th><th>Return Date</th><th></th>
	</tr>";
	
	$v=1;
	$no=1;
	
	include 'db.php';
	
	$sql="SELECT * FROM user_issue_consumable where uid='$id'";
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		$cid=$row['cid'];
		$sql3 = "SELECT * FROM consumable WHERE id='$cid'";
		$result3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($result3);

		if(($v%2)==0)
		{
			echo "<tr class='alt'><td>".$no."</td><td><a href='issue_comp_details.php?id=".$cid."'>
			<u>".$row3['type']."</u></a></td><td>".$row3[2]."</td><td>".$row3[3]."</td>
			<td>".$row3[4]."</td><td>".$row['quantity']."</td><td>".$row['idate']."</td>
			<td>".$row['rdate']."</td><td><input type='checkbox' name='items[]' value='".$row['id']."'>
			</input></td></tr>";
		}
		else
		{
			echo "<tr><td>".$no."</td><td><a href='issue_comp_details.php?id=".$cid."'>
			<u>".$row3['type']."</u></a></td><td>".$row3[2]."</td><td>".$row3[3]."</td>
			<td>".$row3[4]."</td><td>".$row['quantity']."</td><td>".$row['idate']."</td>
			<td>".$row['rdate']."</td><td><input type='checkbox' name='items[]' value='".$row['id']."'></input>
			</td></tr>";
		}
	$v++;
	$no++;
	}

	echo "</table><br/><br/><table align='center'>";
	echo "<tr><td><input type='submit' name='selreturn' value='Return Selected'></input></td>
	<td><input type='submit' name='allreturn' value='Return All'></input></td></tr>";
}

function cmpreturn()
{
	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			echo "<h3 style='color:red' align='center'>You didn't select any items.</h3><center/>";
			echo "<br><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			include 'db.php';	
			$N=count($issue);
			
			for($i=0;$i<$N;$i++)
			{
				$rowid=$issue[$i];
				$sql="SELECT * FROM user_issue_consumable where id='$rowid'";
				$result=mysql_query($sql);
				$row = mysql_fetch_array($result);
				$q=$row['quantity'];
				$cid=$row['cid'];
				
				$sql3 = "SELECT * FROM consumable WHERE id='$cid'";
				$result3 = mysql_query($sql3);
				$row3 = mysql_fetch_array($result3);
				$aq=$row3['quantity'];
				$quant=$q+$aq;
				
				$sql="UPDATE consumable SET quantity='$quant' where id='$cid'";
				$result=mysql_query($sql);
				
				$sql="DELETE FROM user_issue_consumable where id='$rowid'";
				$result=mysql_query($sql);	
			}		
		}
	print "<br/><h3 style='color:red' align='center'>Selected components returned successfully</h3>";
	header("refresh:2,admin.php");
	}
	else
	{
		echo "<h3 style='color:red' align='center'>You didn't select any items.</h3><center/>";
		echo "<br><button type='button' onclick='history.back();'>Back</button>";

	}
}

function returnall()
{
	$id=$_SESSION['issueuserid'];
	include 'db.php';
	
	$sql="SELECT * FROM user_issue_consumable WHERE uid='$id'";
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		$q=$row['quantity'];
		$cid=$row['cid'];
		$rowid=$row['id'];
		$sql3 = "SELECT * FROM consumable WHERE id='$cid'";
		$result3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($result3);
		$aq=$row3['quantity'];
		$quant=$q+$aq;
		
		$sql1="UPDATE consumable SET quantity='$quant' where id='$cid'";
		$result1=mysql_query($sql1);
		
		$sql2="DELETE FROM user_issue_consumable where id='$rowid'";
		$result2=mysql_query($sql2);
	}
	print "<br/><h3 style='color:red' align='center'>All components returned successfully</h3>";
	header("refresh:2,admin.php");
}
?>
</form>
</body>
</html>