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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
 $(function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true,
	 minDate: 1
	});
	 $( "#datepicker" ).datepicker( "option", "showAnim", "slideDown");
	$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy");
  });
  </script>


<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="confirm_student_staff_issue.php" method="POST" onLoad="_top">
<?php
include 'staff.php';

if(!isset($_POST['submit']) && !isset($_POST['rdate']))
{
	form();
}
else if($_POST['rdate'])
{
	$rdate=$_POST['rdate'];
	
	if(isValidDate($rdate))
	{
		issue($rdate);
	} 
	else
	{
		print "<br/><h3 style='color:red' align='center'>Invalid Date</h5>";
	}
}
else
{
	print "<br/><h3 style='color:red' align='center'>*Invalid Date</h5>";
	form();
}

function isValidDate($date)
{
    $date_format = 'd-m-Y'; /* use dashes - dd/mm/yyyy */

    $date = trim($date);
    /* UK dates and strtotime() don't work with slashes, so just do a quick replace */
	
    $date = str_replace('/', '-', $date); 

    $time = strtotime($date);

    $is_valid = date($date_format, $time) == $date;

    if($is_valid)
    {
        return true;
    }

    /* not a valid date..return false */
    return false;
}

function form()
{
	echo "<br/><table align='center'><tr><td>Return Date : </td>
	<td><input type='text' name='rdate' id='datepicker'></input></td><td>(DD/MM/YYYY)</td>
	</tr></table>
	<br/><table align='center'><tr><td><input type='submit' name='selissue' value='Issue'></input></td>
	<td><input type='reset' value='clear'/></td>
	<td><button type='button' onclick='history.back();'>Back</button></td></tr></table>";
}

function issue($rdate)
{
	include 'db.php';
	$uid=$_SESSION['issueuserid'];
	//$stid=$_SESSION['staffid'];
	$utype='Student';
	$idate=date("d/m/Y");
	
	if($_SESSION['issuecmp']=='All')
	{
		$sql="SELECT * FROM request_issue where uid='$uid' and status='Approved'";
		/*$sql="select * from request_issue r, lab_det l where r.uid='$uid' and l.staff_id='$stid' and 
		r.gname=l.fac_in  and  r.status='Approved'";*/
		
		$result=mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{	
			$id=$row['id'];
			$cid=$row['cid'];
			
			$gn=$row['gname'];
			//echo $gn;
			
			$quant=$row['quantity'];
			
			$sql1="Select MAX(id) AS id FROM user_issue_consumable";
			$result1=mysql_query($sql1);
			while($row1 = mysql_fetch_array($result1))
				$id1=$row1['id'];
			
			$id1=$id1+1;
$sql2="INSERT INTO user_issue_consumable VALUES('$id1','$uid','$utype','$gn','$cid','$quant','$idate','$rdate')";
//$sql2="INSERT INTO user_issue_consumable VALUES('$id1','$uid','$utype','$cid','$quant','$idate','$rdate')";
			$result2=mysql_query($sql2);
			
			$sql3="DELETE FROM request_issue WHERE id='$id'";
			$result3=mysql_query($sql3);
		}	
		echo "<h3 align='center'>All components issued successfully</h3>";
		echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
	else
	{
		foreach($_SESSION['issuecmp'] as $arr) 
		{
			$sql="SELECT * FROM request_issue where id='$arr'";
			
			/*$sql="select * from request_issue r, lab_det l where r.id='$arr' and r.uid='$uid' and
			l.staff_id='$stid' and r.gname=l.fac_in  and  r.status='Approved'";*/
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$sql1="Select MAX(id) AS id FROM user_issue_consumable";
				$result1=mysql_query($sql1);
				while($row1 = mysql_fetch_array($result1))
					$id1=$row1['id'];
				
				$id1=$id1+1;
				$cid=$row['cid'];
				$quant=$row['quantity'];
				
				$gn=$row['gname'];
				//echo $gn;
$sql2="INSERT INTO user_issue_consumable VALUES('$id1','$uid','$utype','$gn','$cid','$quant','$idate','$rdate')";
//$sql2="INSERT INTO user_issue_consumable VALUES('$id1','$uid','$utype','$cid','$quant','$idate','$rdate')";
				$result2=mysql_query($sql2);
				$sql3="DELETE FROM request_issue WHERE id='$arr'";
				$result3=mysql_query($sql3);	
			}
		unset($_SESSION['issuecmp']);
		}//echo $gn;
		echo "<h3 align='center'>Selected components issued successfully</h3>";
		echo "<br/><center/><input type=button value='back' onclick=window.location.href='staff.php'></input>";
	}
}
?>
</form>
</body>
</html>