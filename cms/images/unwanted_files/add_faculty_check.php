<?php
session_start();
include("db.php");

$_SESSION['id_blank']="";
$_SESSION['u_blank']="";
$_SESSION['u_valid']="";
$_SESSION['e_blank']="";
$_SESSION['e_valid']="";
$_SESSION['p_blank']="";
$_SESSION['p_valid']="";

$flg=0;

if(isset($_POST['submit']))
{
	
	$fac_id=$_POST["id"];
	$fac_name=$_POST["name"];
	$fac_lab=$_POST["lab"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	
	//user id cant be blank
	if(empty($_POST["id"]))
	{
		$_SESSION['id_blank']="Faculty ID is Required";
		$flg=1;
	}
	
	//user name validation
	if(empty($_POST["name"]))
	{
		$_SESSION['u_blank']="User Name is Required";
		$flg=1;
	}
	else
	{
		if(!preg_match("/^[a-zA-Z ]*$/",$fac_name))
		{
			$_SESSION['u_valid']="Only letters and White Space allowed";
			$flg=1;
		}
	}
	
	//email validation
	if(empty($_POST["email"]))
	{
		$_SESSION['e_blank']="Email ID is Required";
		$flg=1;
	}
	else
	{
		if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			$_SESSION['e_valid']="Invalid Email Format";
			$flg=1;
		}
	}
	
	//phone no validation
	
	if(empty($_POST["phone"]))
	{
		$_SESSION['p_blank']="Contact No. is Required";
		$flg=1;
	}
	else
	{
		if(!preg_match("/^[0-9]*$/",$phone))
		{
			$_SESSION['p_valid']="Invalid PHONE NO. Format";
			$flg=1;
		}
	}
	
}
if($flg==1)
	{
		header('location:add_faculty.php');
	}
else
{	
$a=mysql_query("insert into faculty values('$fac_id','$fac_name','$fac_lab','$email','$phone')");

$result=mysql_query("select * from faculty");
//$_SESSION['user_id']=$_POST['id'];


	if($result)
	{
		echo "<h3 style='color:red'>Added Successfully</h3>";
		$sql=mysql_query("insert into login values('$fac_id','$fac_id','Faculty')");
		$xyz= mysql_query("select * from login");
		/*echo "<table>";
		while($row = mysql_fetch_array($xyz)){
		echo "<tr>";
		echo "<td>" . $row['uid'] . "</td>";
		echo "<td>" . $row['pass'] . "</td>";
		echo "<td>" . $row['type'] . "</td>";
		echo "</tr>";
		echo "</table>";}*/
		header("Refresh:1;url=admin.php");
	}
mysql_close($con);
}
?>