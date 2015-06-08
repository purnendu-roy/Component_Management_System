<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
	if($_SESSION['auth']!='Student')
	{
		session_destroy();
		header("Location:index.php");	
	}
?>
<html>
<body>
<?php
	include 'student.php';
	$id=$_GET["id"];
	include 'db.php';
	$sql="DELETE FROM request_component where id='$id'";
	$result=mysql_query($sql);
	if($result){
		echo "<h4 style='color:red' align='center'>Request withdrawn successfully ";
	echo "<img src='images/added.png' style='position: absolute; top: 217px; left:530px; z-index: -1;'></h4>";
		header("refresh:1;student.php");}
	else
		echo "Error..!";
	//echo "<br><br><button type="button" onclick="history.back();">Back</button>";
	echo "<br/><br/><input type=button value='back' onclick=window.location.href='student.php' ></input>";
?>
</body>
</html>
