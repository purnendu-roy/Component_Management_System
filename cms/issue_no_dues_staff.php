<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
	
	if($_SESSION['auth']!='Staff')
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
			width:80%;
			font-size:14px;
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
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>cms</title>
<body>
<form action="issue_no_dues_staff.php" method="POST" onLoad="_top">
<?php
include 'staff.php';

	if(!isset($_POST['submit']))
	{
		echo "<h3 align='center' style='color:grey'>Check No Dues</h3>";
		form();
	}
	//else if(isset($_POST['submit']) && isset($_POST['rno']))
	else if($_POST['submit'] && $_POST['rno'])
	{
		check();
	}
	else
	{
		echo "<h3 align='center' style='color:red'>Please Enter ID</h3>";
		form();
	}
	
	function form()
	{
		echo "<table align='center'><tr><td>Enter ID :</td><td><input type='text' name='rno'></input>";
		echo "</td><td><input type='submit' name='submit' value='GO'></input></td></tr>"; 
	}
	function check()
	{
		$stid=$_SESSION['staffid'];
		//$id=$_SESSION['issueuserid'];
		$rno1=$_POST['rno'];
		include 'db.php';
		//$sql="SELECT * FROM user_issue_consumable where uid='$rno1'";
		$sql="select * from lab_det l, user_issue_consumable u where
		u.uid='$rno1' and l.staff_id='$stid' and l.fac_in=u.guide ";
		$result=mysql_query($sql);
		if(mysql_num_rows($result) == 0)
		{
			print "<br/><h3 style='color:red' align='center'>No Dues can be issued to ".$rno1."</h5>";
		}
		else
		{
			print "<br/><h3 style='color:red' align='center'>Components Issued to ".$rno1."</h5>";
			echo "<br/><table border='1' align='center' id='edittab'><tr><th>No</th>
			<th>Roll No</th><th>Name</th><th>Type</th><th>Category</th><th>Sub Category</th>
			<th>Description</th><th>Quantity</th><th>Lab</th><th>Issue Date</th><th>Return Date</th>";
			
			$v=1;
			$no=1;
	
			while($row = mysql_fetch_array($result))
			{
				$gn=$row['guide'];
				$rno=$row['uid'];
				$cid=$row['cid'];
				$lb=$row['lab'];
				//echo $rno;
				
				$f1="select * from faculty where id='$rno'";
				$resf1=mysql_query($f1);
				$rf1=mysql_fetch_array($resf1);
				$facname=$rf1['name'];
				
				//echo $rno1;
				$rn1= strtolower($rno1);
				//echo $rn1;
				$sql1="SELECT * FROM student WHERE roll='$rn1'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				$name=$row1['name'];
				
				
				$sql2="SELECT * FROM consumable WHERE id='$cid'";
				$result2=mysql_query($sql2);
				$row2=mysql_fetch_array($result2);
				$type=$row2['type'];
				$cat=$row2['category'];
				$sub=$row2['subcat'];
				$des=$row2['description'];
				
				if(($v%2)==0)
				{	
					echo "<tr class='alt'><td>".$no."</td><td>".$rno."</td>";
					if($rn1 == $row1['roll'])
						echo "<td>".$name."</td>";
					else
						echo "<td>".$facname."</td>";
					echo "<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
					<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$lb."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$no."</td><td>".$rno."</td>";
					if($rn1 == $row1['roll'])
						echo "<td>".$name."</td>";
					else
						echo "<td>".$facname."</td>";
					echo "<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
					<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$lb."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				$v++;
				$no++;
			}
			echo "</table>";
		}
		echo "<br><center/><input type=button value='back' onclick=window.location.href='staff.php' ></input>";
	}
?>
</form>
</body>
</html>