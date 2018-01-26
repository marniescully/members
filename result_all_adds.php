<?php include 'includes/header.php'; ?>


<div class="main">
	<div class="grid_details">
		<h2>Adds Per Member</h2>
		<table class="grid_results">	
			<thead><td>Name</td><td>Total Added</td></thead>

<?php 
	$query = "SELECT  a.id as added_id, a.first_name as added_first, a.middle_initial as added_middle, a.last_name as added_last, Count(*) AS totals
			FROM MEMBERS m
			INNER JOIN MEMBERS a on m.added_by = a.id
			WHERE a.id <> 1
			GROUP BY added_id
			ORDER by totals desc";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Database query failed");
	} 

	while ($members = mysqli_fetch_assoc($result)) {
		$id 			= $members["added_id"];
		$first_name 	= utf8_encode($members["added_first"]);
		$middle_initial	= utf8_encode($members["added_middle"]);
		$last_name 		= utf8_encode($members["added_last"]);
		$totals			= $members["totals"];
		
?>	
		
		<tr><td><a href="result_members_added.php?<?php echo 'id=' . urlencode($id) . '&total=' . urlencode($totals); ?>"><?php echo $first_name . " " . $middle_initial . " " . $last_name;?></a></td><td><?php echo $totals ;?></td></tr> 

<?php
}

	mysqli_free_result($result);

?>
	
		</table>
	</div>
</div>

<?php include 'includes/footer.php'; ?>



