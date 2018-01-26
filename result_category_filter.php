<?php include 'includes/header.php'; ?>

<?php 
	$category = $_POST['category'];
	$query = "SELECT category FROM CATEGORIES WHERE id = $category LIMIT 1";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Database query failed");
	} 
		$category_name = mysqli_fetch_object($result);
?>

<?php 
	
	$query = "SELECT Count(*) as count FROM MEMBERS WHERE category = $category";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Database query failed");
	} 
		$category_count = mysqli_fetch_object($result);
?>


<?php 
	$query = "SELECT m.id as id, m.first_name as first_name, m.middle_initial as middle_initial, m.last_name as last_name, m.added_by, m.category,
				a.id  as added_id, a.first_name as added_first, a.middle_initial as added_middle, a.last_name as added_last, DATE_FORMAT(m.joined_date, '%c/%e/%y') AS 'Date Joined', c.category
				FROM MEMBERS m
				INNER JOIN MEMBERS a ON m.added_by = a.id
				INNER JOIN CATEGORIES c ON m.category = c.id
				WHERE m.category= $category
				ORDER BY m.first_name";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Database query failed");
	} ?>

<?php
 if (mysqli_num_rows ($result) == 0){ ?>
 	<div class="main">
		<div class="grid_details">
			<p>No members have been found. <a href="index.php">Search again.</a></p>
		</div>
	</div>
<?php
 } else { ?>
 <div class="main">
	<div class="grid_details">
		<h2><?php echo $category_name->category . " matches "; ?>
			<?php if ( $category_count->count == '1'){
						echo $category_count->count . " Member" ;
					} else {
						echo $category_count->count  .  " Members" ;
					}
			  ?>
		</h2>
		<table class="grid_results">	
			<thead><td>Name</td><td>Date Joined</td><td>Added By</td></thead>
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
?>
		<tr><td><a href="member_details.php?id=<?php echo $id ?>"><?php echo $first_name . " " . $middle_initial . " " . $last_name;?></a></td><td><?php echo $Date_Joined; ?></td><td><a href="member_details.php?id=<?php echo $added_id ?>"><?php echo $added_first . " " . $added_middle . " " . $added_last;  ?></a></td></tr>

<?php
}

	mysqli_free_result($result);

?>
	
		</table>
	</div>
</div>

<?php include 'includes/footer.php'; ?>
















