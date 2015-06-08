<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
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
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:70%;
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
			background-image: -webkit-gradient
			(
				linear,
				left top,
				left bottom,
				color-stop(0.19, #5AC5E0),
				color-stop(1, #4481EB)
			);
			background-image: -o-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -moz-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -webkit-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -ms-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: linear-gradient(to bottom, #5AC5E0 19%, #4481EB 100%);
		}
		#edittab tr.alt td 
		{
			color:#000000;
			background-color:#EAF2D3;
		}
	</style>
</head>
<body>
<form action="purchase_history.php" method="POST" onLoad="_top">
<?php
include 'admin.php';
include 'db.php';

//$cid=$_GET['id'];
//$sql="SELECT * FROM consum_details where cid='$cid' ORDER BY id DESC ";

$sql="select * from consum_details";
$res=mysql_query($sql);
echo "<h3 style='color:grey' align='center'>Purchase History</h3><br/>";
echo "<table border='1' align='center' id='edittab'><tr><th>No.</th><th>Type</th><th>Quantity</th><th>Price</th>
<th>Purchase Date</th><th>Manufacturer</th><th>Reference Number</th></tr>";

$no=1;
$v=1;

while($row = mysql_fetch_array($res))
{
	$refno1=$row['refno'];
	$s1="select type from consumable where refno='$refno1'";
	$r1=mysql_query($s1);
	$r2=mysql_fetch_array($r1);
	$typ=$r2['type'];
	
	if(($v%2)==0)
	{	
		echo "<tr class='alt'><td>".$no."</td><td>".$typ."</td><td>".$row[3]."</td><td>".$row[2]."</td>
		<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td></tr>";
	}
	else
	{
		echo "<tr><td>".$no."</td><td>".$typ."</td><td>".$row[3]."</td><td>".$row[2]."</td><td>".$row[4]."</td>
		<td>".$row[5]."</td><td>".$row[6]."</td></tr>";
	}
$no++;	
$v++;
}
echo "</table>";
?>
</form>
</body>
</html>