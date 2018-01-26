<?php include 'includes/header.php'; ?>


<?php $added_id = ''; 
	if( isset( $_GET['id'])) {
		$added_id= mysqli_real_escape_string($connection,$_GET['id']); 

			$query 			= "SELECT first_name, middle_initial, last_name FROM MEMBERS  WHERE id = $added_id ";
			$added_id_result= mysqli_query($connection, $query);

			$adder 			= mysqli_fetch_assoc($added_id_result);
			$adder_first 	= utf8_encode($adder['first_name']); 
			$adder_middle 	= utf8_encode($adder['middle_initial']); 
			$adder_last 	= utf8_encode($adder['last_name']); 
	}  
?>

<?php 
	
	if (isset($_POST['submit'])) {

		if(isset($_POST['high_profile']) &&  (!empty($_POST['high_profile']) &&  (($_POST['high_profile']) == "yes" ) )) {
			$high_profile = 1;
		}  else {
			$high_profile = 0;
		}

		if(isset($_POST['note']) &&  (!empty($_POST['note'])) ) {
			$note = utf8_decode(mysqli_real_escape_string($connection,$_POST['note']));
		}  else {
			$note = '';
		}

		if(isset($_POST['email']) &&  (!empty($_POST['email']))) {
			$email = utf8_decode(mysqli_real_escape_string($connection,$_POST['email']));
		}  else {
			$email = '';
		}

		if(isset($_POST['twitter']) &&  (!empty($_POST['twitter'])) ){
			$twitter = utf8_decode(mysqli_real_escape_string($connection,$_POST['twitter']));
		}  else {
			$twitter = '';
		}


		$first  		= utf8_decode(mysqli_real_escape_string($connection,$_POST['first_name']));
		$middle 		= utf8_decode(mysqli_real_escape_string($connection,$_POST['middle_initial']));
		$last   		= utf8_decode(mysqli_real_escape_string($connection,$_POST['last_name']));
		
		$university 	= mysqli_real_escape_string($connection,$_POST['university']);
		$profession 	= mysqli_real_escape_string($connection,$_POST['profession']);
		$employer 		= mysqli_real_escape_string($connection,$_POST['employer']);
		$modified_by 	= mysqli_real_escape_string($connection,$_POST['modified_by']);
		$status 		= 1;
		
		$query = "INSERT INTO `marniesc_members`.`MEMBERS` (`id`, `first_name`, `middle_initial`,
							 `last_name`, `added_by`, `joined_date`, `status`, `category`, 
							 `university`, `profession`, `employer`, `note`, `email`, 
							 `twitter`, `username`, `password`, `high_profile`, 
							 `modified_by`, `modified_date`) 
					VALUES (NULL, '{$first}', '{$middle}', '{$last}', '{$added_id}', CURRENT_TIMESTAMP,		
				 			'{$status}', '1', '{$university}', '{$profession}', '{$employer}',
				 			 '{$note}', '{$email}', '{$twitter}', '', '', '{$high_profile}',
				 			  '2710', CURRENT_TIMESTAMP)";

		$result = mysqli_query($connection, $query);

		if ($result) {
			//redirect to member details page with that id.
			$query 			= "SELECT id, first_name, middle_initial, last_name FROM MEMBERS ORDER BY id DESC LIMIT 1";
			$id_result		= mysqli_query($connection, $query);
			$member 		= mysqli_fetch_assoc($id_result);
			$member_id 		= $member['id']; 
			$member_first 	= utf8_encode($member['first_name']); 
			$member_middle 	= utf8_encode($member['middle_initial']); 
			$member_last 	= utf8_encode($member['last_name']); ?>


			<div id="add_member" class="main">
				<div class="details">
 					<a href="member_details.php?<?php echo 'id=' . urlencode($member_id);?>"> View <?php echo $member_first . " " . $member_middle . " " . $member_last . "'s page" ?> </a>
				</div>
			</div>
		<?php exit(); ?>		
			
	<?php	} else { ?>
				<div id="add_member" class="main">
					<div class="details">
						<?php //die(  "Insert failed". mysqli_error() );
						echo die("Insert failed: " . mysqli_error($connection) . " (" . mysqli_errno($connection) . ")");
						?>
					</div>
				</div>
		<?php } 
	} 
?>

<div id="add_member" class="main">
		<div class="details">
			<div id="add_member_details">
							
				<!-- Insert form for a member  -->
				<form method="POST" action="add_member.php?id=<?php echo $added_id ?>" >
					<h2> <a href="member_details.php?id=<?php echo $added_id?>"> <?php echo $adder_first . " " . $adder_middle . " " . $adder_last ?></a> is Adding a Member</h2> <div><input type="submit" name="submit" value="add member"></div>
					<table class="table_details">	
						<tr>
							<td><label for="first_name">first:</label></td>
							<td><input type="text" id="first_name" name="first_name" required="required"></td>
						</tr>			
						<tr>
							<td><label for="middle_initial">m.i.:</label></td>
							<td><input type="text" id="middle_initial" name="middle_initial"></td>
						</tr>
						<tr>
							<td><label for="last_name">last:</label></td>
							<td><input type="text" id="last_name" name="last_name" required="required"></td>
						</tr>
						
						<tr>
							<td><label for="university">university:</label></td>
							<td><select name="university">
						  			<?php 
									$query = "SELECT * FROM UNIVERSITIES";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die("university Database query failed");
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
							</td>
						</tr>
						<tr>
							<td><label for="profession">profession:</label></td>
							<td><select name="profession">
						  			<?php 
									$query = "SELECT * FROM PROFESSIONS";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die(" profession Database query failed");
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
							</td>
						</tr>
						<tr>
							<td><label for="employer">employer:</label></td>
							<td><select name="employer">
						  			<?php 
									$query = "SELECT * FROM EMPLOYERS";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die(" employers Database query failed");
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
							</td>
						</tr>
						<tr>
							<td><label for="email">email:</label></td>
							<td><input type="text" id="email" name="email"></td>
						</tr>
						<tr>
							<td><label for="twitter">twitter:</label></td>
							<td><input type="text" id="twitter" name="twitter"></td>
						</tr>
						<tr>
							<td><label for="note">note:</label></td>
							<td><textarea name="note" rows="5" cols="20" id="note"></textarea></td>
						</tr>
						<tr>
							<td>
		  						<input type="checkbox" id= "high_profile" name="high_profile" value="yes"><label for="high_profile">&nbsp;high profile</label><br><br>
								<input type="hidden" name="modified_by" >
								<input type="hidden" id="joined_date" name="joined_date">
							</td>
							
						</tr>
					</table>	
				</form>
			</div>
		</div>
	</div>


	


<?php include 'includes/footer.php'; ?>
