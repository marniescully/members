<?php
	$dbhost = "";
	$dbuser = "";
	$dbpass = "";
	$dbname = "";
	$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(mysqli_connect_errno()) {
		die("Database connection failed: " .
			mysqli_error() .
			" (" . mysqli_errno() . ")"
		);
	} 
?>

<html>
<head>
	<title>Members</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-16" />	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- jQuery Mobile -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
	<!-- jQuery UI -->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!-- Bootstrap 3.37 -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- Google Font-->
	<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet">
	<!-- My Styles -->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<?php $logged_in= "" ?>
		<div id="links">
			<div>
				<a href="index.php" class="link left_link">Home</a>
				<a href="result_all_adds.php" class="link left_link">Add Totals</a> 

				<a href="result_status.php?<?php echo 'status=4&total=' . urlencode($total_watchlist->Total);?>" class="link right_link"><?php echo $total_watchlist->Total;?>Watch</a>
				<a href="result_status.php?<?php echo 'status=3&total=' . urlencode($total_blocked->Total);?>" class="link right_link"><?php echo $total_blocked->Total;?>Blocked</a>
				<a href="result_status.php?<?php echo 'status=2&total=' .  urlencode($total_removed->Total);?>" class="link right_link"><?php echo $total_removed->Total;?>Removed</a>

			<!--	
				<a id="login_link" class="link right_link" href="">Blocked</a> 
				<a id="my_details" class="link right_link" href="member_details.php?id=1014">Watchlist</a>
			
			-->
		</div>
		</div>
		<div id="logo">
			<a href="index.php">
				<div id="smlogo" class="hidden-lg hidden-md hidden-sm visible-xs">
					<img id ="sm_birds" src="images/2indiGoHigh_birds-sm.png"></a>
				</div>
				<div id="big_logo" class="visible-lg visible-md visible-sm hidden-xs">
					<a href="index.php"><img src="images/2birdies.png" >
				</div>
			</a>
		</div>
		<div id="search_nav">
			<div id="search_last_name">
				<form method="POST" action="result_by_name.php">
					<label for="last_name">First Name:</label>
					<input type="text" id="first_name" name="first_name" required="true">
					<input type="submit" name="submit" value="search">
				</form>
			</div>
		</div>
	</header>



