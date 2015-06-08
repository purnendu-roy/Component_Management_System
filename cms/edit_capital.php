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
	<style>
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
		}
		#edittab tr.alt td 
		{
		color:#000000;
		background-color:#EAF2D3;
		}
	</style>
</head>
<body>

<form action="edit_capital.php" method="POST" onLoad="_top">

<?php

	if(!isset($_POST['submit']))
	{
		print "<br/><h3 align='center' style='color:blue'><b>Edit Capital Item</b> </h5>";
     	addform();
	}
	else if($_POST['submit'] && $_POST['cname'])
	{
		display();
	}
	else
	{
		print "<br/><h3 align='center' style='color:red'><b>Edit Capital Item</b></h5>";
		addform();
	}
?>

<?php
function addform()
{
    include 'db.php';
	echo "<b><table align='center'><tr>
	<td>Select a Item Name : </td><td>";
	echo "<select name='cname' onchange='getSearch(this.value)' style='border:1px solid grey;width:172px; 
	font-size:40;'>";
	echo "<option></option>";
	
	$sql="select distinct name from capital"; //distinct names from capital table 
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result)) //drop down list for capital name
	{
		$val=$row['name'];
		echo "<option value='$val'>";
		echo $val;
		echo "</option>";
	}
	echo "</select>";
	echo "</td></tr>
	<tr><td></td></tr>
	</table>";
	echo "<br>";
	echo "<input type='submit' name='submit' value='Search' style='margin-left: 520px;font-size:17px;'>
	</input>";
}
?>

<?php
function display()
{
	$name = $_POST['cname'];
	include 'db.php';
	$sql="select * from capital where name like '%$name%'"; //select capital items
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
			print "<br/><h3 style='color:red'><center>No Data Found</center></h5>";
			addform();
	}
	else
	{
		print "<h3 style='color:red'><center>Search Results</center></h5>";
		echo "<br/><table border='1' align='center'id='edittab' ><tr><th>Item
		Name</th><th>Category</th><th>Description</th><th>Supplier</th><th>Unit Price</th>";
		echo "</th><th>Bill No.</th><th>Reference No.</th><th>Manufacturer</th><th>Purchase
		Date</th><th>Warranty</th><th>quantity</th><th>Status</th><th></th></tr>";
		
		$v=1;
		while($row = mysql_fetch_array($result))
		{	
			if(($v%2)==0)
			{	echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".				$row[8]."</td><td>".$row[10]."</td><td>".$row[9]."</td><td>".$row[12]."</td><td>".$row[14].				 "</td><td><u><a href='edit_capital_item.php?id=".$row['id']."'>Edit</a></u></td></tr>";
			}	
			else
			{
				echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".				 $row[8]."</td><td>".$row[10]."</td><td>".$row[9]."</td><td>".$row[12]."</td><td>".$row[14].					"</td><td><u><a href='edit_capital_item.php?id=".$row['id']."'>Edit</a></u></td></tr>";
			}
		$v++;
		}
		print("</table>");
		echo "<br/><center><button type='button' onclick='history.back();'>Back</button></center>";

	}
}
?>
</body>
</html>