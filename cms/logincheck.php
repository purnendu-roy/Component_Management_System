<?php	
 include("db.php");
 if(!isset($_SESSION))
 {
	session_start();
 }
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
			echo "<script>alert('username and password worng')";
			echo "header('Location:login.php');</script>";
				
	}
 //$result=mysql_query("select * from login",$con);

 /*while($row=mysql_fetch_array($result))
 {
		 if($row['uid']==$_POST['myuname'] && $row['pass']==$_POST['mypwd'])
	    {
		  $flag=1;
		  $_SESSION['user_id']=$row['user_id'];
	    }
 }*/
 
 
?>