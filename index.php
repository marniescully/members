
<?php include 'includes/header.php'; ?>
<div id="search_members" class="main">
	<div class="details">
		<h2>Search for a Member</h2>

		<div id="search_universities" class="search_form">
			<form method="POST" action="result_university_filter.php" class="select" >
				<label for="university">university:</label>
				<div>
					<select name="university">
					<?php 
						$query = "SELECT * FROM UNIVERSITIES WHERE id <> 1 ORDER BY university";
						$result = mysqli_query($connection, $query);
						
						if (!$result) {
							die("Database query failed");
						} 

						while ($universities = mysqli_fetch_assoc($result)) {
							$id 			= $universities["id"];
							$university 	= $universities["university"];
						?>
					
						<option value="<?php echo $id; ?>"><?php echo $university; ?></option>
					
						<?php
						}
							mysqli_free_result($result);
						?>		
					</select>
					<input type="submit" name="submit" value="search">
				</div>
			</form>
		</div>
		<div id="search_professions" class="search_form">
			<form method="POST" action="result_profession_filter.php" class="select">
				<label for="profession">profession:</label>
				<div>
					<select name="profession">
						<?php 
						$query = "SELECT * FROM PROFESSIONS WHERE id <> 1 ORDER BY profession";
						$result = mysqli_query($connection, $query);
						
						if (!$result) {
							die("Database query failed");
						} 

						while ($professions = mysqli_fetch_assoc($result)) {
							$id 			= $professions["id"];
							$profession		= $professions["profession"];
						?>
					
						<option value="<?php echo $id; ?>"><?php echo $profession; ?></option>
					
						<?php
						}
							mysqli_free_result($result);
						?>	
					</select>
					<input type="submit" name="submit" value="search">
				</div>
			</form>
		</div>
		<div id="search_employers" class="search_form">
			<form method="POST" action="result_employer_filter.php" class="select" >
				<label for="employer">employer:</label>
				<div>
					<select name="employer">
					  <?php 
						$query = "SELECT * FROM EMPLOYERS WHERE id <> 1 ORDER BY employer";
						$result = mysqli_query($connection, $query);
						
						if (!$result) {
							die("Database query failed");
						} 

						while ($employers = mysqli_fetch_assoc($result)) {
							$id 		= $employers["id"];
							$employer	= $employers["employer"];
						?>
					
						<option value="<?php echo $id; ?>"><?php echo $employer; ?></option>
					
						<?php
						}
							mysqli_free_result($result);
						?>
					</select>
					<input type="submit" name="submit" value="search">
				</div>
			</form>
		</div>

		<div id="search_date" class="search_form">
			<form method="POST" action="result_specific_date.php" class="select" >
				<div class="calendar">
					<label for="datepicker">date added:</label><br>
					<input name="datepicker" id="datepicker" type="text"/>
					<script>
					$( "#datepicker" ).datepicker({
						dateFormat: "yy-mm-dd",
					});
					</script>
					<input type="submit" name="submit" value="search">
				</div>	
			</form>
		</div>
		
	</div>
</div>

<?php include 'includes/footer.php'; ?>

