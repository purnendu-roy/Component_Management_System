<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Faculty')
{
	session_destroy();
	header("Location:index.php");	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Faculty</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<?php
include 'faculty.php';
$id=$_GET["id"];
include 'db.php';
$sql="DELETE FROM request_component where id='$id'";
$result=mysql_query($sql);
if($result)
{
	echo "<script>alert('Request withdrawn successfully')</script>";
	//echo "<h4 style='color:red' align='color'>Request withdrawn successfully ";
	//echo "<img src='images/added.png' style='position: absolute; top: 210px; left:492px; z-index: -1;'></h4>";
	header("refresh:1;faculty.php");
}
else
{
	echo "<script>alert('Error...!')</script>";
	header("refresh:1;faculty.php");
}
?>
</body>
</html>