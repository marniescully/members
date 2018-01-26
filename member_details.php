<?php include 'includes/header.php'; ?>

<?php $id = ''; 
	if( isset( $_GET['id'])) {
		$id = mysqli_real_escape_string($connection,$_GET['id']);
	} 
?>

<?php 
	if (isset($_POST['submit'])) {
		$first  		=  utf8_decode(mysqli_real_escape_string($connection,$_POST['member_first']));
		$middle 		=  utf8_decode(mysqli_real_escape_string($connection,$_POST['member_middle']));
		$last   		=  utf8_decode(mysqli_real_escape_string($connection,$_POST['member_last']));
		$date 			=  mysqli_real_escape_string($connection,date_format(date_create($_POST['member_date']), 'Y-m-d h:i:s'));

		$status 		=  mysqli_real_escape_string($connection,$_POST['member_status']);
		
		$university 	=  mysqli_real_escape_string($connection,$_POST['member_university']);
		$profession 	=  mysqli_real_escape_string($connection,$_POST['member_profession']);
		$employer 		=  mysqli_real_escape_string($connection,$_POST['member_employer']);

		if(isset($_POST['member_note']) &&  (!empty($_POST['member_note'])) ) {
			$note =  mysqli_real_escape_string($connection,$_POST['member_note']);
		}  else {
			$note = '';
		}

		if(isset($_POST['member_email']) &&  (!empty($_POST['member_email']))) {
			$email =  mysqli_real_escape_string($connection,$_POST['member_email']);
		}  else {
			$email = '';
		}

		if(isset($_POST['member_twitter']) &&  (!empty($_POST['member_twitter'])) ){
			$twitter =  mysqli_real_escape_string($connection,$_POST['member_twitter']);
		}  else {
			$twitter = '';
		}

		if(isset($_POST['member_high_profile']) &&  (!empty($_POST['member_high_profile']))) {
			$high_profile = '1';
		}  else {
			$high_profile = '0';
		}
		
		$query = "UPDATE MEMBERS
				SET  first_name ='{$first}', middle_initial ='{$middle}', last_name='{$last}', joined_date = '{$date}', status='{$status}', category= '1', university= '{$university}',
				 profession = '{$profession}', employer = '{$employer}', email ='{$email}', twitter ='{$twitter}', note ='{$note}', high_profile = '{$high_profile}'
				WHERE id = {$id}";

		$result = mysqli_query($connection, $query);

		if ($result) {
		} else {

				//die(  "Insert failed". mysqli_error() );
				die("Update failed: " . mysqli_error($connection) . " (" . mysqli_errno($connection) . ")");
		} 
	} 
?>

<!-- If Form has not been Submitted -->

<?php 
		$query = "SELECT  Count(*) AS Total
					FROM MEMBERS WHERE added_by = $id ";

		$result = mysqli_query($connection, $query);

		if (!$result) {
			die("Database query failed");
		} 
		$total_member = mysqli_fetch_object($result);
?>

<?php $id = $_GET['id'];?>
<?php 
	$query = "SELECT m.id as member_id, m.first_name as member_first, m.middle_initial as member_middle,
	 m.last_name as member_last, DATE_FORMAT(m.joined_date, '%M %d, %Y') AS member_date, m.status as member_status, m.category as member_category, m.employer as member_employer, 
	 m.university as member_university, m.profession as member_profession, m.note as member_note, m.email as member_email, m.twitter as member_twitter,
	  m.high_profile as member_high_profile,
	  a.id as added_id, a.first_name as added_first, a.middle_initial as added_middle,
	  a.last_name as added_last,
	   s.status as status, e.employer as employer, u.university as university, p.profession as profession, c.category as category
			FROM MEMBERS m
			INNER JOIN MEMBERS a on m.added_by = a.id
			INNER JOIN STATUS s on m.status = s.id
			INNER JOIN EMPLOYERS e on m.employer = e.id
			INNER JOIN UNIVERSITIES u on m.university = u.id
			INNER JOIN PROFESSIONS p on m.profession = p.id
			INNER JOIN CATEGORIES c on m.category = c.id
			WHERE m.id=$id LIMIT 1";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Main Database query failed");
	} 
		$member_and_added_by = mysqli_fetch_assoc($result);
		$member_id 					= $member_and_added_by['member_id'];
		$member_first 				= utf8_encode($member_and_added_by['member_first']);
		$member_middle				= utf8_encode($member_and_added_by['member_middle']);
		$member_last 				= utf8_encode($member_and_added_by['member_last']);
		$member_date 				= $member_and_added_by['member_date'];
		$member_status 				= $member_and_added_by['member_status'];
		$member_employer			= $member_and_added_by['member_employer'];
		$member_university 			= $member_and_added_by['member_university'];
		$member_profession 			= $member_and_added_by['member_profession'];
		$member_category 			= $member_and_added_by['member_category'];
		$member_email 				= utf8_encode($member_and_added_by['member_email']);
		$member_twitter 			= utf8_encode($member_and_added_by['member_twitter']);
		$member_note 				= utf8_encode($member_and_added_by['member_note']);
		$member_high_profile 		= $member_and_added_by['member_high_profile'];
		$added_id 					= $member_and_added_by['added_id'];
		$added_first 				= utf8_encode($member_and_added_by['added_first']);
		$added_middle				= utf8_encode($member_and_added_by['added_middle']);
		$added_last 				= utf8_encode($member_and_added_by['added_last']);

?>

	<div id="member_details" class="main">
		<div class="details">
				<ul id="member_links_lg" class="visible-lg visible-md visible-sm hidden-xs member_links_lg">
					<li><a href="add_member.php?id=<?php echo $member_id;?>">Add a New Member</a></li>
					<li><a href="member_details.php?id=<?php echo $added_id; ?>">Added by <?php echo $added_first . " " . $added_middle . " " . $added_last; ?></a></li>
					<li><a href="result_members_added.php?<?php echo 'id=' . urlencode($member_id) . '&total=' . urlencode($total_member->Total); ?>"> <?php echo $member_first . " " . $member_middle . " " . $member_last; ?> has added</a></li>
				</ul>	
			<div id="member_nav" class="dropdown hidden-md hidden-sm visible-xs">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
	  				<span class="caret"></span>
	  			</button>
				<ul id="member_links_sm" class="dropdown-menu dropdown-menu-left hidden-lg ">
					<li><a href="add_member.php?id=<?php echo $member_id;?>">Add a New Member</a></li>
					<li><a href="member_details.php?id=<?php echo $added_id; ?>">Added by <?php echo $added_first . " " . $added_middle . " " . $added_last; ?></a></li>
					<li><a href="result_members_added.php?<?php echo 'id=' . urlencode($member_id) . '&total=' . urlencode($total_member->Total); ?>"> <?php echo $member_first . " " . $member_middle . " " . $member_last; ?> has added</a></li>
				</ul>	
			</div>
			<div id="details">
				<h2><?php echo $member_first . " " . $member_middle . " " . $member_last; ?></h2>			
				<!-- Update form for a member  -->
				<form method="POST" action="member_details.php?id=<?php echo $id; ?>" >
					<table class="table_details">	
						<tr>
							<td><label for="member_first">first:</label></td>
							<td><input type="text" id="member_first" name="member_first" value="<?php echo $member_first; ?>"></td>
						</tr>			
						<tr>
							<td><label for="member_middle">m.i.:</label></td>
							<td><input type="text" id="member_middle" name="member_middle" value="<?php echo $member_middle; ?>"></td>
						</tr>
						<tr>
							<td><label for="member_last">last:</label></td>
							<td><input type="text" id="member_last" name="member_last" value="<?php echo $member_last; ?>"></td>
						</tr>
						<tr>
							<td><label for="member_date">date added:</label></td>
							<td> <input name="member_date" id="member_date" type="text" value="<?php echo $member_date; ?>"/>
									<script>
										$( "#member_date" ).datepicker({
											dateFormat: "yy-mm-dd",
										});
									</script>
							</td>
						</tr>		
						<tr>
							<td><label for="member_status">status:</label></td>
							<td><select name="member_status">
						  			<?php 
									$query = "SELECT * FROM STATUS";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die("Status Database query failed");
									} 

									while ($statuses = mysqli_fetch_assoc($result)) {
										$id 			= $statuses["id"];
										$status 		= $statuses["status"];
									?>
													
									<option value="<?php echo $id ; ?>"
									<?php 
										if ($id ==  $member_status) { ?>
										selected="selected"
									<?php } ?>	>
									<?php echo $status; ?>
									</option>
										
									<?php
									}
										mysqli_free_result($result);
										
									?>	
								</select>
							</td>
						</tr>
						
						<tr>
							<td><label for="member_university">university:</label></td>
							<td><select name="member_university">
						  			<?php 
									$query = "SELECT * FROM UNIVERSITIES";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die("University Database query failed");
									} 

									while ($universities = mysqli_fetch_assoc($result)) {
										$id 				= $universities["id"];
										$university_name 	= $universities["university"];
									?>
													
									<option value="<?php echo $id ; ?>"
									<?php 
										if ($id ==  $member_university) { ?>
										selected="selected"
									<?php } ?>	>
									<?php echo $university_name; ?>
									</option>
										
									<?php
									}
										mysqli_free_result($result);	
									?>		
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="member_profession">profession:</label></td>
							<td><select name="member_profession">
						  			<?php 
									$query = "SELECT * FROM PROFESSIONS";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die("Profession Database query failed");
									} 

									while ($professions = mysqli_fetch_assoc($result)) {
										$id 				= $professions["id"];
										$profession_name 	= $professions["profession"];
									?>
													
									<option value="<?php echo $id ; ?>"									
									<?php 
										if ($id ==  $member_profession) { ?>
										selected="selected"
									<?php } ?>	>
									<?php echo $profession_name; ?>
									</option>
										
									<?php
									}
										mysqli_free_result($result);	
									?>		
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="member_employer">employer:</label></td>
							<td><select name="member_employer">
						  			<?php 
									$query = "SELECT * FROM EMPLOYERS";
									$result = mysqli_query($connection, $query);
									
									if (!$result) {
										die("Employer Database query failed");
									} 

									while ($employers = mysqli_fetch_assoc($result)) {
										$id 			= $employers["id"];
										$employer_name 	= $employers["employer"];
									?>
													
									<option value="<?php echo $id ; ?>" 
									<?php 
										if ($id ==  $member_employer) { ?>
										selected="selected"
									<?php } ?>	>
									<?php echo $employer_name; ?>
									</option>
										
									<?php
									}
										mysqli_free_result($result);	
									?>		
							</td>
						</tr>
						<tr>
							<td><label for="member_email">email:</label></td>
							<td><input type="text" id="member_email" name="member_email" value="<?php echo $member_email; ?>"></td>
						</tr>
						<tr>
							<td><label for="member_twitter">twitter:</label></td>
							<td><input type="text" id="member_twitter" name="member_twitter" value="<?php echo $member_twitter;?>"></td>
						</tr>
						<tr>
							<td><label for="member_note">note:</label></td>
							<td><textarea name="member_note" rows="5" cols="20" id="member_note"><?php echo $member_note; ?></textarea></td>
						</tr>
						<tr>
							<td><label for="member_high_profile"> high profile:</label></td>

							<?php if ($member_high_profile == '1') { ?>
									<td><input type="checkbox" name="member_high_profile" checked="checked"></td>
							<?php } else { ?>
									<td><input type="checkbox" name="member_high_profile" ></td>
							<?php } ?>
						</tr>
						<tr>
							<td><input type="hidden" name="modified_by" value=""></td>
							<td><input type="submit" name="submit" value="update"></td>
						</tr>
					</table>	
				</form>
			</div>
		</div>
	</div>


<?php include 'includes/footer.php'; ?>

