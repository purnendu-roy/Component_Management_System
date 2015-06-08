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
<form action="add_student.php" method="POST" onLoad="_top">

<?php
if(!isset($_POST['roll_no']))
{
	print "<h5 align='center' style='color:#4682B4'><br><br>
	<b>Please enter the following details</br><br></b></h5>";
    addform();
}
else if($_POST['roll_no'] && $_POST['course'] && $_POST['name'] && $_POST['email'] && $_POST['phone'])
{
	$roll = $_POST['roll_no'];
	$len1=strlen($roll);
	$email = $_POST['email'];
	if($len1 == 9)	
	{	if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{	$phone = $_POST['phone'];
			if(preg_match('/^\d{10}$/',$phone))
    		{
      			addData();
    		}
    		else
			{
				echo "<h4 align='center' style='color:red'> Invalid phone number</h4>";
				addform();
			}
		}
		else
		{
			echo "<h4 align='center' style='color:red'>Invalid e-mail id</h4>";
			addform();
	
		}
	}
	else
	{
		echo "<h4 align='center' style='color:red'>Invalid Roll Number</h4>";
		addform();
	}
}
else
{
	print "<h5 align='center' style='color:#4682B4'><br><br><b>Please enter the following details</br></br></h5>";
    addform();
}

//starting of student add form
function addform()
{
  print("<table  align='center'>
  <tr>
  <td>Roll No. :</td><td><input name='roll_no' type='text' size='20'></input></td>
  </tr>
  <tr>
  <td>Name :</td><td><input name='name' type='text' size='20'></input></td>
  </tr>
  <tr>
  <td>Course :</td>
  <td><select name='course' style='width:173px'>
			<option></option>
			<option>UG</option>
			<option>PG</option>
			<option>Phd</option>

	  </select></td>
  </tr>
  <tr>
  <td>email :</td><td><input name='email' type='text' size='20'></input></td>
  </tr>
  <tr>
  <td>Phone :</td><td><input name='phone' type='text' size='20'></input></td>
  </tr>
  <tr></tr>

  <tr><td><br><input type='submit' value='Register'></br></input></td>
	<td><br><input type='reset' value='Clear'></br></input></td>
  </tr>
  </table>");
}

//add student data
function addData()
{
include 'db.php';
$id = $_POST['roll_no'];
$name = $_POST['name'];
$course = $_POST['course'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$sql = "INSERT INTO student values('$id','$name','$course','$email','$phone')";
$result = mysql_query($sql);
$st="UPDATE student SET roll = LOWER(roll)"; //updating the student roll in small letter
$rt=mysql_query($st);
if($result)
{
	$sql = "INSERT INTO login values('$id','$id','Student')"; // insert into login table 
	$result = mysql_query($sql);
	echo "<h3 style='color:red'><center><b>Added Successfully</b></center></h3>";
	header("Refresh:1;url=admin.php");
}
else
{
	echo "<h4 align='center' style='color:red'><center><b>Roll Number already exists</b></center></h4>";
	addform();	
}
}
?>

	</div>
</body>
</html>