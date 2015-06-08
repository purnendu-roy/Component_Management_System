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
<form action="lab_issue_capital_details.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(isset($_POST['selissue']))
{
	issue();
}
else
{
	$id=$_GET['id'];
	$_SESSION['issuecapuserid']=$_GET['id'];;
	form($id);
}
?>

<?php
function form($id)
{
	include 'db.php';
	
	$sql1 = "SELECT  * from staff where id='$id'";
	$result1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($result1);
	$sname=$row1['name'];
	$lab=$row1['lab'];
	
	echo "<br/><h3 style='color:red' align='center'>Issue Requests By ".$sname." ( ".$lab." )</h3>";
	echo "<br/><table border='1' align='center' id='edittab' ><tr><th>No.</th><th>Item Name</th><th>Category</th>
	<th>Description</th><th>Bill No.</th><th>Manufacturer</th><th>Request Date</th><th>Reference Number</th>
	<th></th></tr>";
	
	$v=1;
	$no=1;
	
	$sql="SELECT * FROM request_component where uid='$id' and  status='Purchased'";
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		$refno=$row['refno'];
		$capid=$row['id'];
		$sql3 = "SELECT * FROM capital WHERE refno='$refno'";
		$result3 = mysql_query($sql3);
		while($row3 = mysql_fetch_array($result3))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$no."</td><td>".$row3['name']."</td><td>".$row3[2]."</td>
				<td>".$row3[3]."</td><td>".$row3[6]."</td><td>".$row3[8]."</td><td>".$row['rdate']."</td>
				<td>".$row3[7]."</td><td><input type='checkbox' name='items[]' value='".$row3[0]."'></input>
				</td></tr>";
			}
			else
			{
				echo "<tr><td>".$no."</td><td>".$row3['name']."</td><td>".$row3[2]."</td>
				<td>".$row3[3]."</td><td>".$row3[6]."</td><td>".$row3[8]."</td><td>".$row['rdate']."</td>
				<td>".$row3[7]."</td><td><input type='checkbox' name='items[]' value='".$row3[0]."'></input>
				</td></tr>";
			}
			$v++;
			$no++;
		}
	}
	echo "</table><br/><br/><table align='center'>";
	echo "<tr><td><input type='submit' name='selissue' value='Issue Selected'></input></td></tr></table>";
}

function issue()
{
	if(isset($_POST['items']))
	{
		$issue = $_POST['items'];
		if(empty($issue))
		{
			print "<br/><h3 style='color:red' align='center'>You didn't select any items.</h3><center/>";
			echo "<br/><button type='button' onclick='history.back();'>Back</button>";
		}
		else
		{
			$_SESSION['issuecmp']=$issue;
			header("location:confirm_lab_issue_capital.php");
		}
	}
	else
	{
		print "<br/><h3 style='color:red' align='center'>You didn't select any items.</h3><center/>";
		echo "<br/><button type='button' onclick='history.back();'>Back</button>";
	}
}
?>
</form>
</body>
</html>