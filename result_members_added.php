<?php include 'includes/header.php'; ?>

<?php $id = $_GET['id'];?>
<?php $total = $_GET['total'];?>



<?php 
//query for the H2
	$query = "SELECT first_name, middle_initial, last_name 
				FROM MEMBERS
				WHERE id = $id LIMIT 1";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Database query failed");
	} 
		$member_who_added = mysqli_fetch_object($result);
		$first_name 	= utf8_encode($member_who_added->first_name);
		$middle_initial	= utf8_encode($member_who_added->middle_initial);	
		$last_name 		= utf8_encode($member_who_added->last_name);
?>

<?php 
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
					WHERE m.status = $status AND a.id = $id
					ORDER BY m.first_name";

			

		} else { // No Status means just show overall totals with Status shown in table

	$query = "SELECT m.id, m.first_name as first_name, m.middle_initial as middle_initial,m.last_name as last_name,
			a.id as added_id, a.first_name as added_first, a.middle_initial as
			added_middle, a.last_name as added_last,  DATE_FORMAT(m.joined_date, '%c/%e/%y') AS 'Date Joined',s.status as status
			FROM MEMBERS m
			INNER JOIN MEMBERS a on m.added_by = a.id
			INNER JOIN STATUS s ON m.status = s.id
			WHERE a.id =$id
			ORDER BY m.first_name";


			
		}
?>

<?php  
	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Database query failed");
	} 
?>

<?php
 if (mysqli_num_rows ($result) == 0){ ?>

 	<div class="main">
		<div class="grid_details">
			<h2>
			<?php if (!empty($_GET['id'])) {//check for existence of id and adjust if necessary ?>
			 <a href="member_details.php?id=<?php echo $id ;?>"> <?php echo $first_name . " " . $middle_initial . " " . $last_name ; ?></a> added
			<?php } ?>
			<?php if (!empty($_GET['status'])) {//check for existence of status and adjust if necessary
					if ( $total == '1'){
						echo $total . " " . $status_name->status  . " Member" ;
					} else {
						echo $total . " " . $status_name->status  . " Members" ;
					}

			 } else {

			 	if ( $total == '1'){
						echo $total . " Member";
					} else {
						echo $total . " Members";
					}
			}  
		?>
	
		</h2>
		</div>
	</div>
<?php
 } else { ?>
 <div class="main">
	<div class="grid_details">
		<h2>
			<?php if (!empty($_GET['id'])) {//check for existence of id and adjust if necessary ?>
			 <a href="member_details.php?id=<?php echo $id ;?>"> <?php echo $first_name . " " . $middle_initial . " " . $last_name ; ?></a> added
			<?php } ?>
		<?php if (!empty($_GET['status'])) {//check for existence of status and adjust if necessary
			 		if ( $total == '1'){
						echo $total . " " . $status_name->status  . " Member" ;
					} else {
						echo $total . " " . $status_name->status  . " Members" ;
					}
			} else {
					if ( $total == '1'){
						echo $total . " Member";
					} else {
						echo $total . " Members";
					}
			}  
		?>
	
		</h2>
	
		<table class="grid_results">	
			<thead><td>Name</td><td>Date Joined</td><td>Status</td></thead>
<?php 
 }
	while ($members = mysqli_fetch_assoc($result)) {
		$id 			= $members["id"];
		$first_name 	= utf8_encode($members["first_name"]);
		$middle_initial	= utf8_encode($members["middle_initial"]);
		$last_name 		= utf8_encode($members["last_name"]);
		$Date_Joined 	= $members["Date Joined"];
		$status 		= $members["status"];
		 
?>

		<tr><td><a href="member_details.php?id=<?php echo $id; ?>"><?php echo $first_name . " " . $middle_initial . " " . $last_name;?></a></td><td><?php echo $Date_Joined; ?></td><td><?php echo $status;?></td></tr>

<?php
}

	mysqli_free_result($result);
	

?>
	
		</table>
	</div>
</div>

<?php include 'includes/footer.php'; ?>
















