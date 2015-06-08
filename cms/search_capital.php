<?php
include 'admin.php';
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}	
	if(!isset($_SESSION['auth']))
	{
		header("Location:index.php");
	}
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
<body>
<!--<div id="center_addtext">-->
<br>
<form action="search_capital.php" method="POST" onLoad="_top">

<?php
	if(!isset($_POST['cname']))
	{
		echo "<h4 align='center' style='color:blue'><b>Search Capital Items</b></h4></center>";
		searchform();
	}
	else if($_POST['cname'])
	{
		searchdata();
	}
	else
	{
		echo "<h3 align='center' style='color:red'><b>Please Enter Euipment Name</b></h3></center>";
		searchform();
	}
?>

<?php
function searchform()
{
    include 'db.php';
	echo "<b><table align='center'><tr><td>Euipment Name:</td>";	
	echo "<td><input list='main' name='cname'>";
    echo "<datalist id='main'>";
		$sql = " SELECT distinct name from capital";
		$result = mysql_query($sql);
		echo "<select>";
		while($row = mysql_fetch_array($result))
		{
			echo "<option >".$row['name']."</option>";
		}
	echo "</select></datalist><td></tr>";
	echo "<tr><td>Category : </td><td><input type='text' name='category' ></td></tr>
		<tr><td>Description:</td><td><input type='text' name='des'></input></td></tr>
		<tr><td>Supplier :</td><td><input type='text' name='supplier'></input></td></tr>
		<tr><td>Bill No. :</td><td><input type='text' name='bno'></input></td></tr>";
	echo "<tr><td>Reference No. :</td><td><input type='text' name='refno'></input></td></tr>
		<tr><td>Manufacturer:</td><td><input type='text' name='manu'></input></td></tr>
		<tr><td>Purchase Date:</td><td><input type='date' name='pdate' style='width:168px;'></input></td></tr>
		<tr><td>Entry Date:</td><td><input type='date' name='edate' style='width:168px;'></input></td></tr>";
		
	echo "<tr><td><input type=submit name='submit' value='search'></input></td>
	<td><input type=reset name='reset' value='reset'></td></tr></table>";	
}

function searchdata()
{
	include 'db.php';
	$name = $_POST['cname'];
	$category = $_POST['category'];
	$des = $_POST['des'];
	$pdate = $_POST['pdate'];
	$edate = $_POST['edate'];
	$manu = $_POST['manu'];
	$refno = $_POST['refno'];
	$bno = $_POST['bno'];
	$supplier=$_POST['supplier'];
	$sql="select * from capital where name like '%$name%' and category like '%$category%' and description like
	'%$des%' and supplier like '%$supplier%' and bno like '%$bno%' and refno like '%$refno%' and manufacturer
	like '%$manu%' and  pdate like '%$pdate%' and edate like '%$edate%'	";
	
	$result=mysql_query($sql);
	if(mysql_num_rows($result)==0)
	{
		echo "<h3 align='center' style='color:red'><b>No Data Found...</b></h3></center>";
		searchform();
	}
	else
	{
		echo "<br/><h3 style='color:red'><center><u>Searched results...</u></center></h5>";
		echo "<table border='1' align='center'id='edittab'><tr><th>Item Name</th><th>Category</th>
		<th>Description</th><th>Supplier</th>";
		echo "<th>Unit Price</th><th>Bill No.</th><th>Reference No.</th><th>Manufacturer</th>
		<th>Warranty</th><th>Purchase Date</th>
		<th>Entry Date</th><th>Quantity</th><th>Amount</th><th>Status</th></tr>";
	
		$v=1;
	  while($row = mysql_fetch_array($result))
	  {
		if(($v%2)==0)
		{	
			echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".
			$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[8]."</td>
			<td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[11]."</td>
			<td>".$row[12]."</td><td>".$row[13]."</td><td>".$row[14]."</td></tr>";
		}
		else
		{
			echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".
			$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[8]."</td>
			<td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[11]."</td>
			<td>".$row[12]."</td><td>".$row[13]."</td><td>".$row[14]."</td></tr>";
		}
		$v++;
	  }
	echo "</table><br/><br/>";
	//echo "</table><br><center><button type='button' onclick='history.go(-1);'>Back</button></center></br>";
	echo "</table><br><center><button type='button'><a href='search_capital.php'>
	Back</a></button></center></br>";
	}
}
?>
</body>
</html>