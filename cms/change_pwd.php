<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:login.php");
?>

<html>
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
</head>
<body>
<form action="change_pwd.php" method="POST" onLoad="_top">
<?php
if($_SESSION['auth']=='Admin')
	include 'admin.php';

else if($_SESSION['auth']=='Student')
	include 'student.php';

else if($_SESSION['auth']=='Faculty')
	include 'faculty.php';

else
	include 'staff.php';

if(!isset($_POST['opwd']))
{
	echo "<br><h3 align='center' style='color:blue'> Please enter the following details</h3>";
	form();
}
else if($_POST['opwd'] && $_POST['npwd1'] && $_POST['npwd2'])
{
	change();
}
else
{
	echo "<br><h3 style='color:red' align='center'> Please enter the following details</h3>";
	form();
}
function form()
{
echo "<table align='center'><tr><td><b>Enter Old Password : </td><td><input type='password' name='opwd'> </input></td></tr>";
echo "<tr><td><b>Enter New Password :</b> </td><td><input type='password' name='npwd1'></input></td></tr>";
echo "<tr><td><b>Confirm New Password :</b> </td><td><input type='password' name='npwd2'></input></td></tr>";

echo "<tr><td><input type='submit' value='Submit'></input></td>
	<td><input type='reset' value='Clear'></input></td></tr></table></b>" ;
}
function change()
{
	include 'db.php';
	$op = $_POST['opwd'];
	$np1 = $_POST['npwd1'];
	$np2 = $_POST['npwd2'];
	$uid=$_SESSION['user'];
	$sql="select * from login where uid='$uid'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	//echo $row[1];
	if($op==$row[1])
	{
		if($np1==$np2)
		{
			if(strlen($np1)<6)
			{	
				echo "<center>";
	   echo "<br><h4 style='color:red'><b><font color='red' size='4'>*</font></b>Password length should not be lessthan 6</h4><br>";
				echo "</center>";
				form();
			}
			else
			{
				$sql ="update login set pass='$np1' where uid='$uid'";
				$res=mysql_query($sql);
				if($res)
				{
					echo "<br><h3 style='color:red' align='center'>Password Changed</h3>";
					//header("Refresh:2;url=admin.php");
				}
			}
		}
		else
		{	echo "<br><h4 style='color:red' align='center'>New password not matching</h4><br>";
			form();
		}
	}
	else
	{	echo "<br><h4 style='color:red' align='center'>Invalid old password</h4><br>";
		form();
	}	
}
?>
</form>
</body>
</html>