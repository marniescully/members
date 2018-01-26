<footer>
	<?php $current = basename($_SERVER['SCRIPT_NAME']); ?>

<div id="footer_totals">
	<!-- Totals for all members -->
	<?php 
		$query = "SELECT COUNT(*) as Total FROM MEMBERS";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total = mysqli_fetch_object($result);
	?>

	<?php 
		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 1";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_active = mysqli_fetch_object($result);
	?>

	<?php 
		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 2";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_removed = mysqli_fetch_object($result);
	?>

	<?php 
		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 3";
		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_blocked = mysqli_fetch_object($result);
	?>

	<?php 
		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 4";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_watchlist = mysqli_fetch_object($result);
	?>

<!-- Totals for specific member -->
<?php if (!empty($_GET['id'])) {
		$id = $_GET['id'];

		$query = "SELECT  Count(*) AS Total
					FROM MEMBERS WHERE added_by = $id ";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_member = mysqli_fetch_object($result);



		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 1 AND added_by = $id";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_active_member = mysqli_fetch_object($result);



		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 2 AND added_by = $id";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_removed_member = mysqli_fetch_object($result);



		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 3 AND added_by = $id";
		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_blocked_member = mysqli_fetch_object($result);



		$query = "SELECT COUNT(*) as Total FROM MEMBERS WHERE status = 4 AND added_by = $id";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_watchlist_member = mysqli_fetch_object($result);
} ?>

	<?php if (($current == 'member_details.php') || ($current == 'result_members_added.php') || ($current == 'add_member.php')) { ?>
		<?php $query = "SELECT first_name, middle_initial, last_name FROM MEMBERS WHERE id=$id";

			$result = mysqli_query($connection, $query);

			if (!$result) {
				die("Database query failed");
			} 
				$member = mysqli_fetch_assoc($result);
				$first 	= $member['first_name'];
				$middle = $member['middle_initial'];
				$last 	= $member['last_name'];
		?>
			
		<div id="member_totals">
			<div id="member_add_status" class="stats" >
				<table>
					<caption><a href="result_members_added.php?<?php echo 'id=' . urlencode($id) . '&total=' . urlencode($total_member->Total); ?>" class="link"> <?php echo $total_member->Total;?> members added by <?php echo $first . " " . $middle . " " . $last; ?></a> </caption>
					<thead><td>Active</td><td>Watchlist</td><td>Blocked</td><td>Removed</td></thead>
					<tr>
						<td><a href="result_members_added.php?<?php echo 'status=1&id=' . urlencode($id) . '&total=' . urlencode($total_active_member->Total);?>" class="link"> <?php echo $total_active_member->Total; ?></td>
						<td><a href="result_members_added.php?<?php echo 'status=4&id=' . urlencode($id) . '&total=' . urlencode($total_watchlist_member->Total);?>"class="link"><?php echo $total_watchlist_member->Total; ?></td>
						<td><a href="result_members_added.php?<?php echo 'status=3&id=' . urlencode($id) . '&total=' . urlencode($total_blocked_member->Total); ?>" class="link"><?php echo $total_blocked_member->Total; ?></td>
						<td><a href="result_members_added.php?<?php echo 'status=2&id=' . urlencode($id) . '&total=' . urlencode($total_removed_member->Total); ?>" class="link"><?php echo $total_removed_member->Total; ?></td>
					</tr>
				</table>
			</div>

			<div id="total_member_added" class="stats">

				<?php
					$query = "SELECT  DATE_FORMAT(m.joined_date,'%M - %Y') AS 'Date Joined' , Count(*) as total
						FROM MEMBERS m
						INNER JOIN MEMBERS a on m.added_by = a.id
						WHERE a.id <>1 AND a.id = $id
						GROUP BY MONTH(m.joined_date)
						ORDER BY m.joined_date";

					$result = mysqli_query($connection, $query);

					if (!$result) {
						die("Total Member added Database query failed");
					} 
				?>
<?php if (mysqli_num_rows($result) == 0){ ?>
		
<?php } else { ?>

				<table>
					<caption>Members Added Each Month</caption>
					<thead><td>Date Added</td><td>Total</td></thead>
				<?php					
					while ($totals = mysqli_fetch_assoc($result)) {
					$Date_Joined 	= $totals["Date Joined"];
					$total 			= $totals["total"];
				?>
					<tr><td><?php echo $Date_Joined;?></td><td><?php echo $total?></td></tr>
				<?php }
				?>			
				</table>
			</div>
		</div>
<?php } // No members ?> 
	<?php	} else {  // if not a member page?>
		<div id="members_totals">
			<div id="members_add_status" class="stats" >
				<table>
					<caption> <a href="result_status.php?total= <?php echo $total->Total ?>" class="link"><?php echo $total->Total; ?></a> Total Members </caption>
					<thead><td>Active</td><td>Watchlist</td><td>Blocked</td><td>Removed</td></thead>
					<tr><td><a href="result_status.php?<?php echo 'status=1&total=' . urlencode($total_active->Total);?>" class="link"><?php echo $total_active->Total;?></a></td><td><a href="result_status.php?<?php echo 'status=4&total=' . urlencode($total_watchlist->Total);?>" class="link"><?php echo $total_watchlist->Total;?></a></td><td><a href="result_status.php?<?php echo 'status=3&total=' . urlencode($total_blocked->Total);?>" class="link"><?php echo $total_blocked->Total;?></a></td><td><a href="result_status.php?<?php echo 'status=2&total=' .  urlencode($total_removed->Total);?>" class="link"><?php echo $total_removed->Total;?></td></a></tr>
				</table>
			</div>
		
			<div id="total_members_added" class="stats">
				<?php 
				$query = "SELECT  DATE_FORMAT(m.joined_date,'%M - %Y') AS 'Date Joined' , Count(*) as total
						FROM MEMBERS m
						INNER JOIN MEMBERS a on m.added_by = a.id
						WHERE a.id <>1
						GROUP BY MONTH(m.joined_date)
						ORDER BY m.joined_date";

				$result = mysqli_query($connection, $query);

				if (!$result) {
					die("Database query failed");
				} 
				?>
				<table>
					<caption>Members Added Each Month</caption>
					<thead><td>Date Added</td><td>Total</td></thead>
					<?php					
						while ($totals = mysqli_fetch_assoc($result)) {
						$Date_Joined 	= $totals["Date Joined"];
						$total 			= $totals["total"];
					?>
					<tr><td><?php echo $Date_Joined;?></td><td><?php echo $total; ?></td></tr>
			<?php } ?>		
		
		<?php } ?>	
				</table>
			</div>
		</div>
    </div>
    <?php mysqli_close($connection) ;?>
</footer>
</body>
</html>


