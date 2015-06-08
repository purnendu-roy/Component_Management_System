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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
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


</head>
<body>
<form action="confirm_faculty_issue.php" method="POST" onLoad="_top">
<?php
include 'admin.php';
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
		print "<br/><h3 style='color:red' align='center'>Invalid Date</h3>";

	}

}

function isValidDate($date)
{
    $date_format = 'd-m-Y'; /* use dashes - dd/mm/yyyy */

    $date = trim($date);
    /* UK dates and strtotime() don't work with slashes, 
    so just do a quick replace */
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
?>
<?php
function form()
{
	echo "<br/><br/><table align='center'><tr><td>Return Date :</td>
	<td><input type='text' name='rdate' id='datepicker'></input></td><td>( DD/MM/YYYY )</td></tr></table>
	<br/><table align='center'><tr><td><input type='submit' name='selissue' value='Issue'></input></td>
	<td><input type='reset' value='clear'/></td>
	<td><button type='button' onclick='history.back();'>Back</button></td></tr></table>";
}

function issue($rdate)
{
include 'db.php';
$uid=$_SESSION['issueuserid'];
$utype='Faculty';
$idate=date("d/m/Y");
if($_SESSION['issuecmp']=='All')
{
	$sql="SELECT * FROM request_issue where uid='$uid' and status='Approved'";
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{	
		$id=$row['id'];
		$cid=$row['cid'];
		$quant=$row['quantity'];
		
		$sql1="Select MAX(id) AS id FROM user_issue_consumable";
		$result1=mysql_query($sql1);
		while($row1 = mysql_fetch_array($result1))
			$id1=$row1['id'];
		$id1=$id1+1;
		$sql2="INSERT INTO user_issue_consumable VALUES('$id1','$uid','$utype','$cid','$quant','$idate','$rdate')";
		$result2=mysql_query($sql2);
		$sql3="DELETE FROM request_issue WHERE id='$id'";
		$result3=mysql_query($sql3);
	}	
	echo("<h3 style='color:red' align='center'>All Component Issued Successfully</h3>");
	header("refresh:2;admin.php");
	//echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
}
else
{
	foreach($_SESSION['issuecmp'] as $arr) 
	{
        $sql="SELECT * FROM request_issue where id='$arr'";
		$result=mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			
		$sql1="Select MAX(id) AS id FROM user_issue_consumable";
		$result1=mysql_query($sql1);
		while($row1 = mysql_fetch_array($result1))
			$id1=$row1['id'];
		
		$id1=$id1+1;
		$cid=$row['cid'];
		$quant=$row['quantity'];//taking from request_issue table
		$sql2="INSERT INTO user_issue_consumable VALUES('$id1','$uid','$utype','$cid','$quant','$idate','$rdate')";
		$result2=mysql_query($sql2);
		$sql3="DELETE FROM request_issue WHERE id='$arr'";
		$result3=mysql_query($sql3);	
		}

        	unset($_SESSION['issuecmp']);
	}
	
	echo("<h3 style='color:red' align='center'>Selected components issued successfully</h3>");
	header("refresh:2;admin.php");
	//echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
}
}
?>
</form>
</body>
</html>