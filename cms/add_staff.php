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
<form action="add_staff.php" method="POST" onLoad="_top">
<?php

if(!isset($_POST['id']))
{
	
	print "<h5 align='center' style='color:#4682B4'>
	<b><br><br>Please enter the following details:</br></br></b></h5>";
     
	 addform();
}
else if($_POST['id'] && $_POST['name'] && $_POST['email'] && $_POST['phone'])
{
	$email = $_POST['email'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{	
		$phone = $_POST['phone'];
			/*if(preg_match('/^\d{10}$/',$phone))
    			{
      				addData();
    			}
    			else
				{
					echo "<h4 align='center' style='color:red'>Invalid phone number</h4>";
					addform();
				}*/
		if(ctype_digit($phone))
    	{
			if(strlen($phone)>3 && strlen($phone)<11)
			{ 
				addData();
			}
			else
			{
				echo "<h4 align='center' style='color:red'>Invalid phone number</h4>";
				addform();
			}
    	}
	}
	else
	{
		echo "<h4 align='center' style='color:red'>	Invalid e-mail id</h4>";
		addform();
	}
}
else
{

	print "<h5 align='center' color='red'><br><br><b>Please enter the following details</b></br></br></h5>";
     	addform();
}
?>
<?php
function addform() 
{	//echo $_SESSION['fac_id']; taking from add_faculty.php
	print("<b><table  align='center'>
	<tr><td>Staff ID :</td><td><input name='id' type='text' size='20'></input></td></tr>
	<tr><td>Name :</td><td><input name='name' type='text' size='20'></input></td></tr>
	<tr><td>Lab in charge :</td><td></b>");
	
		echo "<input list='main' name='lab'>";
        echo "<datalist id='main'>";
		include 'db.php';
		$sql = " SELECT name from labs";
		$result = mysql_query($sql);
		echo "<select>";
		while($row = mysql_fetch_array($result))
		{
			echo "<option >".$row['name']."</option>";
		}
		echo "</select></datalist>";
    
print("</td>
  </tr>
  <tr>
  <td>email :</td><td><input name='email' type='text' size='20'></input></td>
  </tr>
  <tr>
  <td>Phone :</td><td><input name='phone' type='text' size='20'></input></td>
  </tr>
  <tr></tr>
  <tr><td><align='center'><br>
  <input type='submit' value='Register' align='center'></br></input></td>
	<td><br><input type='reset' value='Clear'></center></br></input></td>
  </tr>
  </table>");
}
function addData()
{
include 'db.php';
	$id = $_POST['id'];
	$name = $_POST['name'];
	$lab=$_POST['lab'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$_SESSION['staff_id']=$id; //session variable for Staff ID
	$sql="Select * FROM labs where name='$lab'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count==0)
	{
		$sql="Select MAX(id) AS id FROM labs";
		$result=mysql_query($sql);
		while($row = mysql_fetch_array($result))
			$id1=$row['id'];
		$id1=$id1+1;
		$sql="INSERT INTO labs values('$id1','$lab')";
		$result=mysql_query($sql);
	}
	
	//$sql="INSERT INTO staff values('$id','$name','$lab','$email','$phone')";
	$result=mysql_query("insert into staff values('$id','$name','$lab','$email','$phone')");
	
	$abc=mysql_query("SELECT faculty.id AS fid, faculty.name AS fname, staff.id AS sid, staff.name AS sname, 	
	faculty.lab FROM faculty INNER JOIN staff ON faculty.lab = staff.lab");
	if( mysql_num_rows($abc)>0)
	{	
		while($row=mysql_fetch_array($abc))
		{
			$fid=$row['fid'];
			$fname=$row['fname'];
			$sid=$row['sid'];
			$sname=$row['sname'];
			$lab=$row['lab'];
			mysql_query("insert into lab_det values('$lab','$fid','$fname','$sid','$sname')");
		}
	}
	if($result)
	{
		echo "<h3 align='center' style='color:red'>Added Successfully</h3>";
		$sql="INSERT INTO login values('$id','$id','Staff')";
		mysql_query($sql);
		header("Refresh:1;url=admin.php");
	}
	else
	{
		echo "<h4 align='center' style='color:red'>ID already exists</h4>";
		addform();
	}
}
?>
</body>
</html>