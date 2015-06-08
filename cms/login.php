<?php
if(!isset($_SESSION))
 {
	session_start();
 }
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8">

  <title>Login</title>

    <link rel="stylesheet" href="css/log.css" media="screen" type="text/css" />
	<!--include jQuery
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"
	type="text/javascript"></script>

	...include jQuery Validation Plugin...
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"
	type="text/javascript"></script>
	
	<script type="text/javascript">
		$(function()
		{
			$('#triangle').validate({
				rules:
				{
					myuname:
					{
						required:true
					},
					
				},
				message:
				{
					myuname:
					{
						required:"please provide your user id"
					},
				}
			})
		})
	</script>-->

</head>

<body>

  <span href="#" class="button" id="toggle-login">Log in</span>
 <!-- <span href="#" class="button" ><a href="index.php">back</a></span>-->
 <span href="#" class="button" onclick="location.href='index.php';" >back</span>
<div id="login">
  <div id="triangle"></div>
  <h1>Log in</h1>
<form name ="log" method="post" action="login.php"  onsubmit="return(regvalidate())">
<?php	
if(!isset($_POST["myuname"]))
{
     	loginform();
}
else if($_POST["myuname"] && $_POST["mypwd"] && $_POST["type"])
{
	checklogin();
}
else
{
	echo "<script>alert('You Can not Login with Blank Username or Password ')";
	echo "</script>";
    loginform();

}
function checklogin()
{
 include 'db.php' ;
	$myusername=$_POST['myuname']; 
 	$mypassword=$_POST['mypwd']; 
	$type=$_POST['type'];
	$myusername = stripslashes($myusername);
 	$mypassword = stripslashes($mypassword);
 	$myusername = mysql_real_escape_string($myusername);
 	$mypassword = mysql_real_escape_string($mypassword);
	
	$sql="SELECT * FROM login WHERE uid='$myusername' and 	pass='$mypassword' and type='$type'";
 	$result=mysql_query($sql);
 	$count=mysql_num_rows($result);
	if($count==1)
	{	
		$_SESSION['user']=$_POST['myuname'];
		if($type=='Admin')
		{
			header("location:admin.php");
			$_SESSION['auth']='Admin';
		}
		else if($type=='Staff')
		{
			header("location:staff.php");
			$_SESSION['auth']='Staff';
		}
		else if($type=='Student')
		{
			header("location:student.php");
			$_SESSION['auth']='Student';
		}
		else
		{	
			header("location:faculty.php");
			$_SESSION['auth']='Faculty';
		}
		
	}
	else
	{
			echo "<script>alert('Invalid Username and Password !')";
			echo "</script>";
			loginform();
	}
}

function loginform()
{
    echo "<input type=text placeholder='Username' name='myuname' />
    <input type=password placeholder='Password' name='mypwd' />
	<select name='type'>
		<option value='Admin'>Admin</option>
		<option value='faculty'>Faculty</option>
		<option value='Staff'>Staff</option>
		<option value='Student'>student</option>
	</select>";
    echo "<input type='submit' value='Log in' />";
}
?>
 </form>
</div>

 <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>
 <script src="js/index.js"></script>

</body>

</html>