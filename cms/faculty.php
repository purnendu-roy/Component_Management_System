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
<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/x-icon" type="image/vnd.microsoft.icon" href="images/cms.jpg"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
   <title>faculty</title>
   <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
   <link rel="stylesheet" type="text/css" media = "all" href="css/styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="js/script.js"></script>

</head>

<body>

  <div id="header">
        <div class="header_content">
      
         <div class="logo"><a href=""><font face="Stencil Std" color ="black">CMS</font></a>
		<span>NIT calicut</span>
		
		<?php
		
			$id=$_SESSION['user'];
			include 'db.php';
			$sql="SELECT * FROM faculty WHERE id='$id'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$user=$row['name'];
			$fid=$row['id'];
			$_SESSION['name']=$user;
			$_SESSION['id']=$fid;
			echo "<h5 id='right-corner'>
			<font size='4px' color='#a40100'><p style='text-align:center;'>".$user." &nbsp;</font>
			<font size='4px' color='#25383C '>(".$fid.")</font></h5>";
			//echo "<h5>".$user."</h5>";
			echo "</p>";
		?>
		</div>
        
        <!-- <div class="menu">
            <ul>
               <li class="selected"><a href="index.html">Home</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="page.html">contact</a></li> 
            </ul>
         </div>-->
         
        </div> 
  </div><!-- End of Header-->
  
  <!--start faculty menu-->
<div id='cssmenu'>
<ul>
	<li></li>
	
   <li><a href='faculty.php'><span>Home</span></a></li>
   <li><a href='#'><span>SEARCH</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Item</span></a>
            <ul>
               <li><a href='user_search_capital.php'><span>Capital</span></a></li>
               <li class='last'><a href='user_search_consumable.php'><span>Consumable</span></a></li>
            </ul>
         </li>
         <li class='has-sub'><a href='#'><span>User</span></a>
            <ul>
               <li><a href='search_faculty.php'><span>Faculty</span></a></li>
			    <li class='last'><a href='search_staff.php'><span>Staff</span></a></li>
               <li class='last'><a href='search_student.php'><span>Student</span></a></li>
			    
            </ul>
         </li>
		 <li><a href='word_searchf.php'><span>Word Search</span></a></li>
      </ul>
   </li>
	
	<li><a href='#'><span>REQUEST</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Issue</span></a>
			<ul>
				<li><a href='faculty_request_issue.php'><span>New Request</span></a></li>
				<li><a href='faculty_request_issuewithdraw.php'><span>Withdraw</span></a></li>
			</ul>
		 </li>
         <li class='has-sub'><a href='#'><span>Purchase</span></a>
			<ul>
				<li><a href='faculty_request_purchase.php'><span>New Request</span></a></li>
				<li><a href='faculty_request_purwithdraw.php'><span>Withdraw</span></a></li>
			</ul>
		 </li>
      </ul>
   </li>
   <?php
	include 'db.php';
	$rno=$_SESSION['user'];
	$sql="SELECT * FROM faculty WHERE id='$rno'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$user=$row['name'];
	$sql="SELECT * FROM request_issue WHERE gname='$user' and status='Pending'";
	$result=mysql_query($sql);
   if(mysql_num_rows($result)>0)
   {
   ?>
		<li><a href='#'><span><blink style='color:#B40404'>APPROVAL</blink></span></a>
   <?php
   }
   else
   {
	$sql="SELECT * FROM request_component WHERE gname='$user' and status='Pending'";
	$result=mysql_query($sql);
		if(mysql_num_rows($result)>0)
		{
	?>
			<li><a href='#'><span><blink style='color:#B40404'>APPROVAL</blink></span></a>
		<?php
		}
		else
		{
		?>
			<li><a href='#'><span>APPROVAL</span></a>
		<?php
		}
   }
   ?>
      <ul>
         <li class='has-sub'><a href='#'><span>Issue</span></a>
			<ul>
				<li><a href='faculty_approval_stafffissue.php'><span>Staff</span></a></li>
				<li><a href='faculty_approval_studentissue.php'><span>Student</span></a></li>
			</ul>
		 </li>
         <li class='has-sub'><a href='#'><span>Purchase</span></a>
			<ul>
				<li><a href='faculty_approval_staffpurchase.php'><span>Staff</span></a></li>
				<li><a href='faculty_approval_studentpurchase.php'><span>Student</span></a></li>
			</ul>
		 </li>
      </ul>
   </li>
  
   <li><a href='liabilities.php'><span>LIABILITIES</span></a></li>
   <li><a href='discussion_forum.php'><span>Discussion</span></a></li>
   <li class='last'><a href='#'><span>Settings</span></a>
	<ul>
		<li><a href='change_pwd.php'><span>Change Password</span></a></li>
		 <li><a href='logout.php'><span>Logout</span></a></li>
	</ul>
   </li>
</ul>
</div><!-- end of Header-->

<div id="wrap">
<div class="clear"></div>    
</div>


</body>
</html>
