<?php include 'includes/header.php'; ?>

<?php 
	
	$total = $_GET['total'];


	// Check if id is set and if so assign it to a variable
	if (!empty($_GET['id'])) {
		$id = $_GET['id']; 

		// Get Text name of the status
			$query = "SELECT first_name,middle_initial,last_name FROM MEMBERS WHERE id = $id LIMIT 1";

			$result = mysqli_query($connection, $query);

			if (!$result) {
				die("Text name of status Database query failed");
			} 

			$member_name = mysqli_fetch_assoc($result);
			$first_name 	= utf8_encode($member_name["first_name"]);
			$middle_initial	= utf8_encode($member_name["middle_initial"]);
			$last_name 		= utf8_encode($member_name["last_name"]);

		// Member specific page
		// Check if status is set and if so assign it to a variable
		if (!empty($_GET['status'])) {
			$status = $_GET['status']; 

			// Get Text name of the status
			$query = "SELECT status FROM STATUS WHERE id = $status LIMIT 1";

			$result = mysqli_query($connection, $query);

			if (!$result) {
				die("Text name of status Database query failed");
			} 

			$status_name = mysqli_fetch_object($result);

			$query = "SELECT m.id as id, m.first_name as first_name, m.middle_initial as middle_initial, m.last_name as last_name, m.added_by, m.status as member_status,
							a.id  as added_id, a.first_name as added_first, a.middle_initial as added_middle, a.last_name as added_last, DATE_FORMAT(m.joined_date, '%c/%e/%y') AS 'Date Joined', s.status as status
					FROM MEMBERS m
					INNER JOIN MEMBERS a ON m.added_by = a.id
					INNER JOIN STATUS s ON m.status = s.id
					WHERE m.status = $status AND m.added_by = $id
					ORDER BY m.first_name";


		} else { // No Status means just show overall totals with Status shown in table

			$query = "SELECT m.id as id, m.first_name as first_name, m.middle_initial as middle_initial, m.last_name as last_name, m.added_by, m.status,
				a.id  as added_id, a.first_name as added_first, a.middle_initial as added_middle, a.last_name as added_last, DATE_FORMAT(m.joined_date, '%c/%e/%y') AS 'Date Joined', s.status as status
				FROM MEMBERS m
				INNER JOIN MEMBERS a ON m.added_by = a.id
				INNER JOIN STATUS s ON m.status = s.id
				WHERE added_by= $id;
				ORDER BY m.first_name";

		}

	} else { // This if is if it's a member or all members
	
	// All Members Section
	
	// Check if status is set and if so assign it to a variable
		if (!empty($_GET['status'])) {
			$status = $_GET['status'];
			// Get Text name of the status
			$query = "SELECT status FROM STATUS WHERE id = $status LIMIT 1";

			$result = mysqli_query($connection, $query);

			if (!$result) {
				die("All members text name of status Database query failed");
			} 
				$status_name = mysqli_fetch_object($result);

				$query = "SELECT m.id as id, m.first_name as first_name, m.middle_initial as middle_initial, m.last_name as last_name, m.added_by, m.status,
							a.id  as added_id, a.first_name as added_first, a.middle_initial as added_middle, a.last_name as added_last, DATE_FORMAT(m.joined_date, '%c/%e/%y') AS 'Date Joined', s.status as status
					FROM MEMBERS m
					INNER JOIN MEMBERS a ON m.added_by = a.id
					INNER JOIN STATUS s ON m.status = s.id
					WHERE m.status= $status AND m.id <> 1
					ORDER BY m.first_name";



		} else { //Check if there is a status for all Members
		// No Status means just show overall totals with Status shown All Members
			$query = "SELECT m.id as id, m.first_name as first_name, m.middle_initial as middle_initial, m.last_name as last_name, m.added_by, m.status,
				a.id  as added_id, a.first_name as added_first, a.middle_initial as added_middle, a.last_name as added_last, DATE_FORMAT(m.joined_date, '%c/%e/%y') AS 'Date Joined', s.status as status
				FROM MEMBERS m
				INNER JOIN MEMBERS a ON m.added_by = a.id
				INNER JOIN STATUS s ON m.status = s.id
				WHERE m.id <> 1
				ORDER BY m.first_name";


		} // End check of status of all members
	} // End Check if this is one member or all members
?>

<?php 

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die(" Main query for all or one member Database query failed");
	} 
?>


 <div class="main">
	<div class="grid_details">

		<h2>
			<?php if (!empty($_GET['id'])) {//check for existence of id and adjust if necessary ?>
			 <a href="member_details.php?id=<?php echo $id ;?>"> <?php echo $first_name . " " . $middle_initial . " " . $last_name ; ?></a> added
			<?php } ?>
		<?php if (!empty($_GET['status'])) {//check for existence of status and adjust if necessary
			 echo $total . " " . $status_name->status . " Members" ;
			} else {
			echo $total . " Members";
			}  
		?>
	
		</h2>

		<?php
		 if (mysqli_num_rows ($result) == 0){ ?>
		 
<?php
 } else { ?>
		<table class="grid_results">	
			<thead><td>Name</td><td>Date Joined</td><td>Added By</td>
			<?php 
				if (empty($_GET['status'])) { ?>
					<td>Status</td>

			<?php } ?>
			</thead>
<?php 
 }

	while ($members = mysqli_fetch_assoc($result)) {
		$id 			= $members["id"];
		$first_name 	= utf8_encode($members["first_name"]);
		$middle_initial	= utf8_encode($members["middle_initial"]);
		$last_name 		= utf8_encode($members["last_name"]);
		$Date_Joined 	= $members["Date Joined"];
		$added_id 		= $members["added_id"];
		$added_first 	= utf8_encode($members["added_first"]);
		$added_middle 	= utf8_encode($members["added_middle"]);
		$added_last		= utf8_encode($members["added_last"]);
		$member_status	= $members["status"];
?>
		<tr><td><a href="member_details.php?id=<?php echo $id ?>"><?php echo $first_name . " " . $middle_initial . " " . $last_name;?></a></td><td><?php echo $Date_Joined; ?></td><td><a href="member_details.php?id=<?php echo $added_id ?>"><?php echo $added_first . " " . $added_middle . " " . $added_last;  ?></a></td>
			<?php 
				if (empty($_GET['status'])) { ?>
					<td><?php echo $member_status; ?></td>
			<?php } ?>
		</tr>

<?php
} 
	mysqli_free_result($result);
?>
	
		</table>
	</div>
</div>

<?php include 'includes/footer.php'; ?>
