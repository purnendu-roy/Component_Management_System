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
<form action="word_search.php" method="POST" onLoad="_top">

<?php
	if(!isset($_POST['submit']))
	{
		echo "<h4 align='center' style='color:blue'><b>Search</b></h4></center>";
		searchform();
	}
	else if($_POST['submit'] && $_POST['search'])
	{
		searchdata();
	}
	else
	{
		echo "<h3 align='center' style='color:red'><b>Please Enter The Field</b></h3></center>";
		searchform();
	}
?>

<?php
function searchform()
{
	/*$b='a';
	$a='b';
	$$b='c';
	echo $a;*/
    echo "<table align='center'><tr><td><input type=text name='search'></td>";
	echo "<td><input type=submit name='submit' value='search'></input></td></tr></table>";
}

// searching function for any word or text
function searchdata()
{
	include 'db.php';
	$s=$_POST['search'];
	$flag=0;
	
	// searching for consumable items.
	$sql="SELECT * FROM consumable WHERE type LIKE '%$s%' OR category LIKE '%$s%' OR subcat LIKE '%$s%' OR 
	description LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$flag=1;
		echo "<br/><h3 style='color:red' align='center'>Consumable Items</h5>";
		
	    echo "<table border='1' align='center' id='edittab'><tr><th>Component</th>
		<th>Category</th><th>Sub Category</th><th>Description</th>";
		
		echo "<th>Quantity</th><th>Consumed Quantity</th><th>Price</th><th>Purchase Date</th>
		<th>Manufacturer</th><th>Reference No.</th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{
				echo "<tr class='alt'><td><u><a href='issue_comp_details.php?id=".$row[0]."'>".$row[1]."</a>
				</u></td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
						
				echo "<td>".$row[5]."</td><td>".$row[15]."</td><td>".$row[6]."</td><td>".$row[7]."</td>
				<td>".$row[11]."</td><td>".$row[12]."</td></tr>";
			}
			else
			{
				echo "<tr><td><u><a href='issue_comp_details.php?id=".$row[0]."'>".$row[1]."</a>
				</u></td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
						
				echo "<td>".$row[5]."</td><td>".$row[15]."</td><td>".$row[6]."</td><td>".$row[7]."</td>
				<td>".$row[11]."</td><td>".$row[12]."</td></tr>";
			}
			$v++;
		}
		echo "</table>";
	}
	
	// searching for capital items
	$sql="select * from capital where name like '%$s%' or category like '%$s%' or description like '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0)
	{
		$flag=1;
		echo "<br/><h3 style='color:red'><center><u>Capital Items</u></center></h5>";
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
			<td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[11]."</td><td>".$row[12]."</td>
			<td>".$row[13]."</td><td>".$row[14]."</td></tr>";
		}
		else
		{
			echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".
			$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[8]."</td>
			<td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[11]."</td><td>".$row[12]."</td>
			<td>".$row[13]."</td><td>".$row[14]."</td></tr>";
		}
				$v++;
	}
	echo "</table><br/><br/>";
	}
	//echo "</table><br><center><button type='button'><a href='search_student.php'>
	//Back</a></button></center></br>";
	
	//....... student............
	$sql="select * from student where roll like '%$s%' or name like '%$s%' or course like '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0)
	{
		$flag=1;
		echo "<h3 style='color:red'><center><u>Student</u></center></h5>";
		echo "<table border='1' align='center'id='edittab'><tr><th>Roll NO.</th><th>Name</th>
		<th>Course</th><th>Email</th><th>Phone</th></tr>";
	
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
				$row[3]."</td><td>".$row[4]."</td></tr>";
			}
			else
			{
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
				$row[3]."</td><td>".$row[4]."</td></tr>";
			}
		$v++;
		}
	echo "</table><br><br>";
	}
	
	//........ Faculty........
	$sql="select * from faculty where id like '%$s%' or name like '%$s%' or lab like '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0)
	{
		$flag=1;
		echo "<h3 style='color:red'><center><u>Faculty </u></center></h5>";
		echo "<table border='1' align='center'id='edittab'><tr><th>Faculty ID</th><th>Name</th>
		<th>Lab</th><th>Email</th><th>Phone</th></tr>";
	
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
				$row[3]."</td><td>".$row[4]."</td></tr>";
			}
			else
			{
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
				$row[3]."</td><td>".$row[4]."</td></tr>";
			}
		$v++;
		}
	echo "</table><br><br>";
	}
	
	//........ Staff........
	$sql="select * from staff where id like '%$s%' or name like '%$s%' or lab like '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0)
	{
		$flag=1;
		echo "<h3 style='color:red'><center><u>Staff</u></center></h5>";
		echo "<table border='1' align='center'id='edittab'><tr><th>Staff ID</th><th>Name</th>
		<th>Lab</th><th>Email</th><th>Phone</th></tr>";
	
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
				$row[3]."</td><td>".$row[4]."</td></tr>";
			}
			else
			{
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
				$row[3]."</td><td>".$row[4]."</td></tr>";
			}
		$v++;
		}
	echo "</table>";
	}
	if($flag==0)
	{
		print "<br/><h3 style='color:red'><center>No data found</center></h3>";
	}
	//echo "<input type=button onClick='parent.location='word_search.php'' value='Back'></input></center></br>";
	echo "<br><center><button type='button'><a href='word_search.php'>Back</a>
	</button></center></br>";
}
?>
</body>
</html>