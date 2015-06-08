<!DOCTYPE html>
<html>
<head><title>admin</title>
<link rel="icon" type="image/x-icon" type="image/vnd.microsoft.icon" href="images/cms.jpg"/>
<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta charset='utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/script.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/script.js"></script>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>-->
<script type="text/javascript" charset="utf-8">
var $ = jQuery.noConflict();
  $(window).load(function() {
    $('.flexslider').flexslider({
          animation: "slide"
    });
  });
</script>
</head>
<!--<body background="images/set.png"> background="images/abc3.jpg"-->
<body> 

  <div id="header">
        <div class="header_content">
      
        <div class="logo"><a href=""><font face="Stencil Std" color ="black">CMS</font></a>
		<span>NIT calicut</span>
		<div id="right-corner"><p><font size="4px" color="">Welcome  <b>Admin</b></font></p></div>
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

  
  <!--start admin menu-->
<div id='cssmenu'>
<ul>
   <li><a href='admin.php'><span>Home</span></a></li>
   <li><a href='#'><span>ADD</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Item</span></a>
            <ul>
               <li><a href='add_capital_item.php'><span>Capital</span></a></li>
               <li class='last'><a href='add_consumable_item.php'><span>Consumable</span></a></li>
            </ul>
         </li>
         <li class='has-sub'><a href='#'><span>User</span></a>
            <ul>
               <li><a href='add_faculty.php'><span>Faculty</span></a></li>
               <li><a href='add_staff.php'><span>Staff</span></a></li>
			     <li><a href='add_student.php'><span>Student</span></a></li>
            </ul>
         </li>
      </ul>
   </li>
    <li><a href='#'><span>EDIT</span></a>
	<ul>
         <li class='has-sub'><a href='#'><span>Item</span></a>
            <ul>
               <li><a href='edit_capital.php'><span>Capital</span></a></li>
               <li class='last'><a href='edit_consumable.php'><span>Consumable</span></a></li>
            </ul>
         </li>
         <li class='has-sub'><a href='#'><span>User</span></a>
            <ul>
               <li><a href='edit_faculty.php'><span>Faculty</span></a></li>
			   <li class='last'><a href='edit_staff.php'><span>Staff</span></a></li>
			   <li class='last'><a href='edit_student.php'><span>Student</span></a></li>
            </ul>
         </li>
      </ul>
   </li>
   
   <li><a href='#'><span>SEARCH</span></a>
      <ul>
         <li class='has-sub'><a href='#'><span>Item</span></a>
            <ul>
               <li><a href='search_capital.php'><span>Capital</span></a></li>
               <li class='last'><a href='search_consumable.php'><span>Consumable</span></a></li>
            </ul>
         </li>
         <li class='has-sub'><a href='#'><span>User</span></a>
            <ul>
				 <li><a href='search_faculty.php'><span>Faculty</span></a></li>
			     <li class='last'><a href='search_staff.php'><span>Staff</span></a></li>
				 <li class='last'><a href='search_student.php'><span>Student</span></a></li>
            </ul>
         </li>
		 <li><a href='word_search.php'><span>Word Search</span></a></li>
      </ul>
   </li>
	
	<li><a href='#'><span>ISSUE</span></a>
      <ul>
		 <li><a href='faculty_issue.php'><span>Faculty</span></a></li>
         <li><a href='student_issue.php'><span>Student</span></a></li>
		 <li class='has-sub'><a href='#'><span>Lab</span></a>
			<ul>
               <li><a href='lab_issue_capital.php'><span>Capital</span></a></li>
               <li class='last'><a href='lab_issue.php'><span>Consumable</span></a></li>
            </ul>
		 </li>
      </ul>
   </li>
   
   <li><a href='#'><span>RETURN</span></a>
      <ul>
         <li><a href='student_return.php'><span>Student</span></a></li>
         <li><a href='faculty_return.php'><span>Faculty</span></a></li>
      </ul>
   </li>
   
   <li><a href='#'><span>REPORT</span></a>
      <ul>
         <li><a href='min_stock_alerts.php'><span>Minimum Stock Alert</span></a></li>
         <li class="has-sub"><a href='#'><span>Component Issued</span></a>
		 <ul>
         <li><a href='ci_student.php'><span>Student</span></a></li>
         <li><a href='ci_faculty.php'><span>Faculty</span></a></li>
		 <li><a href='ci_lab.php'><span>Lab</span></a></li>
         </ul>
		 </li>
		 
		 <li class="has-sub"><a href='#'><span>Request for</span></a>
		 <ul>
         <li><a href='purchase_requests.php'><span>Purchase</span></a></li>
		 <li><a href='issue_requests.php'><span>Issue</span></a></li>
         </ul>
		 </li>
		
		 <li class="has-sub"><a href='#'><span>Issue NoDues</span></a>
		 <ul>
			 <li><a href='issue_no_dues.php'><span>By Id</span></a></li>
			 <li><a href='issue_no_dues_lab.php'><span>By Lab</span></a></li>
		 </ul>
		 
		 <li class="has-sub"><a href='#'><span>Capital Items</span></a>
		 <ul>
         <li><a href='capital_all.php'><span>View All</span></a></li>
		 <li><a href='damaged_components.php'><span>Damaged Components</span></a></li>
         </ul>
		 </li>
		 <li><a href='purchase_history.php'><span>Purchase History</span></a></li>
		 <li><a href='consumable_item_status.php'><span>Components status</span></a></li> 
		 <li class='last'><a href='discussion_admin.php'><span>discussion forum</span></a></li>
      </ul>
      </li>
	
   <li class='last'><a href='#'><span>Settings</span></a>
	<ul>
		<li><a href='change_pwd.php'><span>Change Password</span></a></li>
		 <li><a href='logout.php'><span>Logout</span></a></li>
	</ul>
   </li>
</ul>
</div><!-- end of Header-->

<div id="wrap">
    <!--div class="top_slogan"><font face="Castellar">
Component Management System is a Web Application designed to Improve the Management of Components in store of ECED.
<font color="red">Welcome Administrator</font>
  </div>-->	
<div class="clear"></div>    
</div>


        <!-- <div class="footer">
        	<div class="footer_content">
            <div class="footer_left">
                <p>
				<a href="http://www.nitc.ac.in/">NITC Home</a>
				|<a href="http://ece.nitc.ac.in/"> EC Site</a> | Copyright © 2015 CMS ECED.All Rights Reserved.Designed BY
				<a href="https://www.facebook.com/shanoo.sidgaphs">P.Kr.Roy</a></p>
               <ul class="footer_menu">
                    <li><a href="index.html">home</a></li>
                    <li><a href="page.html">page</a></li>
                    <li><a href="page.html">blog</a></li>
                    <li><a href="page.html">porfolio</a></li>
                    <li><a href="page.html">contact</a></li> 
                </ul>
            </div>
            
            <div class="footer_right">
                <ul class="social_icons">
                <li><a href="#"><img src="images/icon_rss.png" alt="" title="" /></a></li>
                <li><a href="#"><img src="images/icon_facebook.png" alt="" title="" /></a></li>
                <li><a href="#"><img src="images/icon_twitter.png" alt="" title="" /></a></li>
                <li><a href="#"><img src="images/icon_dribbble.png" alt="" title="" /></a></li>
                </ul>
            </div>
           <div class="clear"></div>
           </div>
        </div>-->


</body>
</html>
