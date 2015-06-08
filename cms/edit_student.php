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
</head>
<body>
<div id="center_addtext"><br>
<form action="edit_student.php" method="POST" onLoad="_top">

<?php

	if(!isset($_POST['submit']))
	{
		print "<br/><h3 align='center' style='color:blue'><b>Edit Student</b> </h5>";
     	addform();
	}
	else if($_POST['submit'] && $_POST['sroll'])
	{
		$roll_no=$_POST['sroll'];
		include 'db.php' ;
		$sql="select * from student where roll='$roll_no'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)==0)//if none of the row matched 
		{
			echo "<br/><h3 align='center' style='color:red;'> Invalid Roll Number</h3>";
			addform();
		}
		else
		{
			header("location:edit_student_details.php?roll=$roll_no");
		}
	}
	else
	{
		echo "<br/><h3 align='center' style='color:red;'>Please Enter Roll Number</h3>";
		addform();
	}
	
function addform()
{
   echo "<b><table align='center'><tr><td>Enter Roll Number.:</td><td>
   <input type='text' name='sroll'></td></tr></table>";
   echo "<br></b>";
   echo "<input type='submit' name='submit' value='Search' style='margin-left: 520px;font-size:17px;'>
	</input>";
}
?>

</div>
</body>
</html>