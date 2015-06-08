<?php
	include 'admin.php';
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
	<style>
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
<form action="edit_consumable_item.php" method="POST" onLoad="_top">
<?php

if(isset($_POST['del']))
{
	$cid=$_SESSION['editcid'];
	header("location:delete_consumable.php?cid=$cid");
}
else if(isset($_POST['delete']))
{
	delete();
}
else if(!isset($_POST['submit']))
{
	echo "<h4 align='center' style='color:red'>Edit Consumable Components</h4>";
	$cid=$_GET['id'];
	$_SESSION['editcid']=$_GET['id'];
	form($cid);
}
else if(isset($_POST['submit'])&&$_POST['quantity'] && $_POST['pdate'] && $_POST['refno'] && $_POST['price'])
{
	update();
}
else if(isset($_POST['submit']) && $_POST['cq'])
{
	consume();
}
else
{
	echo "<h4 align='center' style='color:red'>Nothing to Update</h4>";
	$id=$_SESSION['editcid'];
	form($id);	
}

function form($cid)
{
include 'db.php';
$sql="SELECT * FROM consumable WHERE id='$cid'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$sid=$row['specid'];

$sql1="SELECT * FROM specification WHERE id='$sid'";
$result1=mysql_query($sql1);
$row1=mysql_fetch_array($result1);

echo "<table align='center'>
<tr><td>Type</td><td><input type='text' value='".$row['type']."'disabled='disabled'></input></td></tr>";
echo "<tr><td>Category</td><td><input type='text' value='".$row['category']."' disabled='disabled'></input>
</td></tr>";
echo "<tr><td>Sub Category</td><td><input type='text' value='".$row['subcat']."' disabled='disabled'></input>
</td></tr>";
echo "<tr><td>Description</td><td><input type='text' value='".$row['description']."' disabled='disabled'>
</input></td></tr>";

if(!empty($row1['f1']))
{
echo "<tr><td>".$row1['f1'].":</td><td><input type='text' disabled='disabled'  value=".$row['f1']."></td></tr>";
}
if(!empty($row1['f2']))
{
echo "<tr><td>".$row1['f2'].":</td><td><input type='text' disabled='disabled' value=".$row['f2']." ></td></tr>";
}
if(!empty($row1['f3']))
{
echo "<tr><td>".$row1['f3'].":</td><td><input type='text' disabled='disabled' value=".$row['f3']." ></td></tr>";
}
if(!empty($row1['f4']))
{
echo "<tr><td>".$row1['f4'].":</td><td><input type='text' disabled='disabled' value=".$row['f4']."></td></tr>";
}
if(!empty($row1['f5']))
{
echo "<tr><td>".$row1['f5'].":</td><td><input type='text' disabled='disabled' value=".$row['f5']."></td></tr>";
}
if(!empty($row1['f6']))
{
echo "<tr><td>".$row1['f6'].":</td><td><input type='text' disabled='disabled' value=".$row['f6']."></td></tr>";
}
if(!empty($row1['f7']))
{
echo "<tr><td>".$row1['f7'].":</td><td><input type='text' disabled='disabled' value=".$row['f7']."></td></tr>";
}
if(!empty($row1['f8']))
{
echo "<tr><td>".$row1['f8'].":</td><td><input type='text' disabled='disabled' value=".$row['f8']."></td></tr>";
}
if(!empty($row1['f9']))
{
echo "<tr><td>".$row1['f9'].":</td><td><input type='text' disabled='disabled' value=".$row['f9']." ></td></tr>";
}
if(!empty($row1['f10']))
{
echo "<tr><td>".$row1['f10'].":</td><td><input type='text' disabled='disabled'value=".$row['f10']."></td></tr>";
}
echo "<tr><td>Quantity</td><td><input type='text' name='quantity'></input></td></tr>";
echo "<tr><td>Consumed Quantity</td><td><input type='text' name='cq' value=0></input></td></tr>";
echo "<tr><td>Price</td><td><input type='text' name='price'></input></td></tr>";
echo "<tr><td>Manufacturer</td><td><input type='text' name='manu'></input></td></tr>";
echo "<tr><td>Purchase Date</td><td><input type='text' name='pdate'></input></td></tr>";
//echo "<tr><td>Bill No</td><td><input type='text' name='bno'></input></td></tr>";
echo "<tr><td>Reference No</td><td><input type='text' name='refno'></input></td></tr>";
echo "<tr><td><input type='submit' name='submit' value='Update'></input></td>
<td><input type='submit' name='delete' value='Delete'></input></td>
<td><button type='button'><a href='admin.php'>Back</a></button></td></tr>";
}
function update()
{
$cid=$_SESSION['editcid'];
$cq=$_POST['cq'];
$quantity=$_POST['quantity'];
$price=$_POST['price'];
$manu=$_POST['manu'];
$pdate=$_POST['pdate'];
$refno=$_POST['refno'];

include 'db.php';
$sql="SELECT * FROM consumable WHERE id='$cid'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$quant=$row['quantity'];
$quant=$quantity+$quant;
$sql="UPDATE consumable SET quantity='$quant', price='$price', manufacturer='$manu', pdate='$pdate', refno='$refno' WHERE id='$cid'";
$result=mysql_query($sql);

$sql5 = "SELECT MAX(id) AS id FROM consum_details";
$res5 = mysql_query($sql5);
$row5 = mysql_fetch_array($res5);
$id1=$row5['id'];
$id1++;

$sql6="INSERT INTO consum_details values('$id1','$cid','$price','$quantity','$pdate','$manu','$refno')";
$res6 = mysql_query($sql6);

$sql7="SELECT * FROM consumable WHERE id='$cid'";
$result7=mysql_query($sql7);
$row7=mysql_fetch_array($result7);
$cquant=$row7['cq'];
$quantity=$row7['quantity'];
$quantity=$quantity-$cq;
$cq=$cq+$cquant;
$sql1="UPDATE consumable SET cq='$cq', quantity='$quantity' WHERE id='$cid'";
$result1=mysql_query($sql1);
echo "<h4 style='color:red' align='center'>Updated Successfully</h4>";
echo "<br><center><button type='button'><a href='admin.php'>Back</a></center></button>";

}
?>
<?php
function consume()
{
$cq=$_POST['cq'];
$cid=$_SESSION['editcid'];
include 'db.php';
$sql="SELECT * FROM consumable WHERE id='$cid'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$cquant=$row['cq'];
$quantity=$row['quantity'];
$quantity=$quantity-$cq;
$cq=$cq+$cquant;
$sql1="UPDATE consumable SET cq='$cq', quantity='$quantity' WHERE id='$cid'";
$result1=mysql_query($sql1);
echo "<h4 style='color:red' align='center'>Updated Successfully</h4>";
echo "<br><center><button type='button'><a href='admin.php'>Back</a></center></button>";
}
?>
<?php
function delete()
{
$cid=$_SESSION['editcid'];
$f=0;
include 'db.php';
$sql1="SELECT * FROM user_issue_consumable WHERE cid='$cid'";
$result1=mysql_query($sql1);
$count1=mysql_num_rows($result1);
if($count1>0)
{
$f=1;	
echo "<h3 style='color:red' align='center'>This component is issued to the following users</h3>";
echo "<table border='1' align='center' id='edittab'><tr><th>No</th><th>ID</th> 
<th>Name</th><th>Type</th><th>Quantity</th><th>Issue Date</th><th>Return Date</th>";
$v=1;
$no=1;	
while($row1=mysql_fetch_array($result1))
{
$ut=$row1[2];
if($ut=='Student')
{	
	$sql2="SELECT * FROM student where roll='$row1[1]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$name=$row2['name'];
}
if($ut=='Faculty')
{	
	$sql2="SELECT * FROM faculty where id='$row1[1]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	$name=$row2['name'];
}

if(($v%2)==0)
{	

echo "<tr class='alt'><td>".$no."</td><td>".$row1[1]."</td><td>".$name."</td><td>".$row1['utype']."</td><td>".$row1['quantity']."</td><td>".$row1['idate']."</td><td>".$row1['rdate']."</td></tr>";
}
else
{
	
echo "<tr><td>".$no."</td><td>".$row1[1]."</td><td>".$name."</td><td>".$row1['utype']."</td><td>".$row1['quantity']."</td><td>".$row1['idate']."</td><td>".$row1['rdate']."</td></tr>";
}
$v++;
$no++;
}
echo "</table><br/>";
}
$sql1="SELECT * FROM lab_issue_consumable WHERE cid='$cid'";
$result1=mysql_query($sql1);
$count1=mysql_num_rows($result1);
if($count1>0)
{
$f=1;
?>
<br><br>
<?php	
echo "<br/><h3 style='color:red' align='center'>This component is issued to the following labs</h3>";
echo "<table border='1' align='center' id='edittab' ><tr><th>No</th><th>Lab</th><th>Staff in charge</th><th>Quantity</th><th>Issue Date</th>";
$v=1;
$no=1;	
while($row1=mysql_fetch_array($result1))
{
$id=$row1[2];
$sql2="SELECT * FROM staff where id='$id'";
$result2=mysql_query($sql2);
$row2=mysql_fetch_array($result2);
$name=$row2['name'];
$lab=$row2['lab'];
if(($v%2)==0)
{	

echo "<tr class='alt'><td>".$no."</td><td>".$lab."</td><td>".$name."</td><td>".$row1['quantity']."</td><td>".$row1['idate']."</td></tr>";
}
else
{
	
echo "<tr><td>".$no."</td><td>".$lab."</td><td>".$name."</td><td>".$row1['quantity']."</td><td>".$row1['idate']."</td></tr>";
}
$v++;
$no++;
}
print ("</table>");
}
if($f==1)
{
echo "<br/><center/><input type='submit' value='Delete Anyway' name='del'></input>";
}
else
{
$sql="DELETE FROM request_issue WHERE cid='$cid'";
$result=mysql_query($sql);
$sql="DELETE FROM consumable WHERE id='$cid'";
$result=mysql_query($sql);
echo "<br/><h4 style='color:red' align='center'>Deleted successfully</h4>";
//echo "<br><center><button type='button' onclick='location.href ='admin.php;''>Back<center></button>";
echo "<br><center><button type='button'><a href='admin.php'>
	Back</a></button></center></br>";
}
}
?>
