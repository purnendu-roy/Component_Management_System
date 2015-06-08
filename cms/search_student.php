<?php

	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
	if($_SESSION['auth']=='Student')
	{
		session_destroy();
		header("Location:index.php");	
	}
	if($_SESSION['auth']=='Staff')
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
<form action="search_student.php" method="POST" onLoad="_top">
<?php
if($_SESSION['auth']=='Admin')
	include 'admin.php';
else if($_SESSION['auth']=='Student')
	include 'student.php';
else if($_SESSION['auth']=='Faculty')
	include 'faculty.php';
else
	include 'staff.php';

?>
<?php
if(!isset($_POST["roll_no"])&& !isset($_POST["name"])&& !isset($_POST["course"])&& !isset($_POST["email"])&& !isset($_POST["phone"]) )
	{
		echo "<h4 align='center' style='color:blue'><b>Enter atleast one field</b></h4></center>";
		searchform();
	}
	else if($_POST["roll_no"] || $_POST["name"] || $_POST["course"] || $_POST["email"] || $_POST["phone"])
	{
		searchdata();
	}
	else
	{
		echo "<h3 align='center' style='color:red'><b>Please Enter atleast one field</b></h3></center>";
		searchform();
	}
?>

<?php
function searchform()
{
    include 'db.php';
	echo "<b><table align='center'><tr><td>Roll Number:</td><td><input type=text name='roll_no'>
	</input></td></tr>";
	echo "<tr><td>Student Name:</td><td><input type=text name='name'></input></td></tr>";
	echo "<tr><td>Course:</td><td><select name='course' style='width:173px;'>
	<option></option>
	<option>UG</option>
	<option>PG</option>
	<option>Phd</option></select></td></tr>";
	echo "<tr><td>Email:</td><td><input type=text name='email'></input></td></tr>";
	echo "<tr><td>Phone:</td><td><input type=text name='phone'></input></td></tr>";
	echo "<tr><td><input type=submit name='submit' value='search'></input></td>
	<td><input type=reset name='reset' value='reset'></td></tr></table>";	
}

function searchdata()
{
	include 'db.php';
	$rno=$_POST['roll_no'];
	$name=$_POST['name'];
	$course=$_POST['course'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$sql="select * from student where roll like '%$rno%' and name like '%$name%' and course like '%$course%'
	and email like '%$email%' and phone like '%$phone%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)==0)
	{
		echo "<h3 align='center' style='color:red'><b>No Data Found...</b></h3></center>";
		searchform();
	}
	else
	{
		echo "<h3 align='center' style='color:red'><b>Searched Result...</b></h3></center>";
		echo "<table border='1' align='center'id='edittab' ><tr><th>Roll No.</th><th>Name</th>
			<th>course</th><th>Email</th><th>Phone</th></tr>";
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
					echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3].
					"</td><td>".$row[4]."</td></tr>";
				}
				$v++;
			}
	//echo "</table><br><center><button type='button' onclick='history.go(-1);'>Back</button></center></br>";
		echo "</table><br><center/>
		<input type=button value='back' onclick=window.location.href='search_faculty.php' ></input>";
	}
}
?>
</body>
</html>