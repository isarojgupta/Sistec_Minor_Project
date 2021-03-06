<?PHP
	session_start();
	if($_SESSION['sid'] == session_id() && $_SESSION['user'] == "student")
	{	
		$student_id = $_SESSION['student_id'];
		
		$connection = @mysqli_connect("localhost", "root", "") or die;
		
		$sql1 = "SELECT * FROM minordb.student WHERE student_id = '".$student_id."'";
		
		$sql2 = "SELECT * FROM minordb.leave_statistics WHERE student_id = '".$student_id."'";
		
		$result1 = mysqli_query($connection,$sql1);
		
		$result2 = mysqli_query($connection,$sql2);
		
		while($row1 = mysqli_fetch_array($result1))
		{
			$first_name = $row1['first_name'];
			$middle_name = $row1['middle_name'];
			$last_name = $row1['last_name'];
		}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>student Profile</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../images/bg.gif);
}
</style>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
  <div id="header">
    <div id="title">Leave Management System</div>
    <div id="quick_links">
      <ul>
        <li><a class="home" href="index.php">Home</a></li>
        <li>|</li>
       
        <li><a class="logout" href="../logout.php">Logout</a></li>
        <li>|</li>
        <li><a class="greeting" href="#">Hi <?php echo $_SESSION['user']; ?></a></li>
      </ul>
    </div>
  </div>
  <div id="content_panel">
    <div id="heading">Student Profile<hr size="2" color="#FFFFFF" ice:repeating=""/></div>
    <div id="form">
    <form method="post" action="approve_reject_db.php">
    <fieldset>
    <legend>Personal Information</legend>
    <label for="student_id"><span>Student ID </span>
    	<input type="text" name="student" id="student_id" readonly="true" value="<?php echo $student_id ?>" style="background-color:#F6F6F6; color:#069" />
    </label>
    <label for="student_name"><span>student Name </span>
    	<input type="text" readonly="true" value="<?php echo $first_name." ".$middle_name." ".$last_name ?>" style="background-color:#F6F6F6; color:#069" />
    </label>
    </fieldset>
    <br />
    <fieldset>
    <legend>Leave Statistics</legend>
    <div id="table">
    	<span><table border="1" bgcolor="#006699" >
				<tr>
                	<th width="120px">Leave Types</th>
					<th width="200px">Maximum Allowed Leaves</th>
					<th width="120px">Leaves Taken</th>
					<th width="200px">Remaining Leaves</th>
				</tr>
			</table></span>
    <?PHP
    while($row2 = mysqli_fetch_array($result2))
		{
			$leave_type = $row2['leave_type'];
			$maximum_leaves = $row2['maximum_leaves'];
			$laves_taken = $row2['leaves_taken'];
			$remaining_leaves = $maximum_leaves - $laves_taken;
			echo "<table border=\"1\">
					<tr>
						<td width=\"120px\">".$leave_type."</td>
						<td width=\"200px\">".$maximum_leaves."</td>
						<td width=\"120px\">".$laves_taken."</td>
						<td width=\"200px\">".$remaining_leaves."</td>
					</tr>
				</table>";
		}
		
	?>
    </div>
    </fieldset>
    </form>
    </div>
  </div>
  <div id="side_bar">
  	<ul>
    	<li class="menu_head">Controls</li>
        <li><a href="apply_leave.php">Apply Leave</a></li>
        <li><a href="view_leave_history.php">View Leave History</a></li>
        <li><a href="view_leave_status.php">View Leave Status</a></li>
         <li><a href="view_profile.php">View Profile</a></li>
    </ul>
  </div>
  <div id="footer">
  	<p><br />Leave Management System</p>
  </div>
</div>
</body>
</html>
<?php
	}
	else
	{
		header("Location: ../index.html");
	}
	mysqli_close($connection);
?>
