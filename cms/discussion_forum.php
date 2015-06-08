<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}	
	if(!isset($_SESSION['auth']))
	{
		header("Location:index.php");
	}
	/*if($_SESSION['auth']!='Faculty' || $_SESSION['auth']!='Staff' || $_SESSION['auth']!='Student')
	{
		session_destroy();
		header("Location:index.php");	
	}*/
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style>
		#edittab
		{
		font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
		width:50%;
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
	<script>
</script>
</head>
<body>
<form action="discussion_forum.php" method="POST" onLoad="_top" name="myForm" id="myForm">
<?php
if($_SESSION['auth']=='Admin')
	include 'admin.php';

else if($_SESSION['auth']=='Student')
	include 'student.php';

else if($_SESSION['auth']=='Faculty')
	include 'faculty.php';

else
	include 'staff.php';

if(!isset($_POST['submit']))
{
	echo "<h3 align='center' style='color:Grey'>Discussion Forum</h3>";
	form();
}
else if($_POST['serial'] && $_POST['area'])
{
	add();
}
else
{
	echo "<h3 style='color:red' align='center'>Discussion Forum</h3>";
	form();
}
function form()
{
	echo "<table align='center' border='2' id='edittab'>";
	echo "<tr><td>Serial Number</td><td><input type='text' name='serial' size='75'></td></tr>";
	//echo "<tr><td>Name</td><td><input type='text' name='name' size='75'></td></tr>";
	echo "<tr><td>Suggestion</td><td><textarea name='area' rows='15' cols='75'></textarea></td></tr>";
	echo "</table>";
	echo "<br/><center/><input type='submit' name='submit' value='submit'/>";
	echo "<input type='reset' name='reset' value='clear'/>";
}
function add()
{
	include "db.php";
	$sno=$_POST['serial'];
	$sug=$_POST['area'];
	
	if($_SESSION['auth']=='Faculty')
	{
		$name=$_SESSION['name'];
		$id=$_SESSION['id'];
		$result=mysql_query("insert into discussion values('$sno','$id','$name','$sug')");
		if($result)
			echo "<script>alert('suggestion added successfully')</script>";
		else
			echo "<script>alert('No Duplicate Entry')</script>";
	}
	if($_SESSION['auth']=='Student')
	{
		$name=$_SESSION['name'];
		$roll=$_SESSION['rno'];
		$result=mysql_query("insert into discussion values('$sno','$roll','$name','$sug')");
		if($result)
			echo "<script>alert('suggestion added successfully')</script>";
		else
			echo "<script>alert('No Duplicate Entry')</script>";
	}
	if($_SESSION['auth']=='Staff')
	{
		$name=$_SESSION['name'];
		$id=$_SESSION['staffid'];
		$result=mysql_query("insert into discussion values('$sno','$id','$name','$sug')");
		if($result)
			echo "<script>alert('suggestion added successfully')</script>";
		else
			echo "<script>alert('No Duplicate Entry')</script>";
	}
}
?>
</form>
</body>
</html>
