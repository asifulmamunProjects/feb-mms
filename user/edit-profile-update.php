<?php
	
	// Check Page Method
	if ($_SERVER['REQUEST_METHOD'] !== "POST") {
		header("Location: edit-profile.php");
		die();
	}else{
	
	// include configuration for database connection and other power
	include '../function/connection.php'; // connection
	include '../function/user_functions.php'; // include user function

	$feb_wp_get_current_user_id = $_SESSION['feb_wp_get_current_user_id']; // declare current user id in variable
	$feb_user_id_checks = feb_user_id_check($_SESSION['feb_wp_get_current_user_id']); // check this id stored in feb user table - if user stored result true or false with count 0 or 1

	// get permssion status from db if has permission or 1 it will can be possible update data
	if (feb_get_permission_edit_profile($_SESSION['feb_wp_get_current_user_id'])>0){
		// if wp_user_id is not exist in database return 0 and insert id with this condition
		if ($feb_user_id_checks == 1) {

			/*
				@Hidden Input
				If user edit there profile this will automatic permission denied for edit with this 0 value.
				If need again permission to edit profile need bellow process:
					* Permission give or give access from Admin Dashboard or
					* Change value coloumn 'permission_edit_profile' = 1 (From database table)	
	 		*/
			$permission_edit_profile = 0; // Permission false #default after edit user

			/*
				@Personal Information
			*/
			$name = $_POST['name']; // Name
			$fathersName = $_POST['fathersName']; // Father's Name
			$mothersName = $_POST['mothersName']; // Mother's Name
			$gender = $_POST['gender']; // Gender
			$religion = $_POST['religion']; // Relegion
			$region = $_POST['region']; // Region
			$country = $_POST['country']; // Country
			$email = $_POST['email']; // Email
			$mobileNumber = $_POST['mobileNumber']; // Mobile Number
			$nearestBangladeshMission = $_POST['nearestBangladeshMission']; // Nearest Bangladeshi Mission
			$nidSmartCardNo = $_POST['nidSmartCardNo']; // NID or Smart Card No

			/*
				@Present Address
			*/
			$pFlantHouseNo = $_POST['pFlantHouseNo']; // Flat/House No
			$pRoadNo = $_POST['pRoadNo']; // Road No
			$pCityTown = $_POST['pCityTown']; // City/Town
			$pZipPostCode = $_POST['pZipPostCode']; // Zip/Post Code

			/*
				@Parmanent Address
			*/
			$peFlatHouseNo = $_POST['peFlatHouseNo']; // Flat/House No
			$peRoadNo = $_POST['peRoadNo']; // Road No
			$peCityTown = $_POST['peCityTown']; // City/Town
			$peZipPostCode = $_POST['peZipPostCode']; // Zip/Post Code

			/*
				@Passport Details
			*/
			$passportNumber = $_POST['passportNumber']; // Passport Number

			/*
				@Convert Date of Birth
			*/
			$get_dateOfBirth = $_POST['dateOfBirth']; // Get from Input
			$convert_dateOfBirth = strtotime($get_dateOfBirth); // Convert Input
			$dateOfBirth = date('Y-m-d',$convert_dateOfBirth); // Date of Birth


			/*
				@Convert Passport Issue Date
			*/
			$get_passportIssueDate = $_POST['passportIssueDate']; // Passport Issue Date
			$convert_passportIssueDate = strtotime($get_passportIssueDate); // Passport Issue Date
			$passportIssueDate = date('Y-m-d',$convert_passportIssueDate); // Passport Issue Date

			/*
				@Convert Passport Expire Date
			*/
			$get_passportExpireDate = $_POST['passportExpireDate']; // Passport Expire Date
			$convert_passportExpireDate = strtotime($get_passportExpireDate); // Passport Expire Date
			$passportExpireDate = date('Y-m-d',$convert_passportExpireDate); // Passport Expire Date

				$update = "UPDATE $tprefix_feb_user_information SET
					`name`='$name',
					`date_of_birth`='$dateOfBirth',
					`fathers_name`='$fathersName',
					`mothers_name`='$mothersName',
					`gender`='$gender',
					`religion`='$religion',
					`region`='$region',
					`country`='$country',
					`email`='$email',
					`mobile`='$mobileNumber',
					`nearest_bangladeshi_mission`='$nearestBangladeshMission',
					`national_or_smart_id`='$nidSmartCardNo',
					`pr_flat_house_no`='$pFlantHouseNo',
					`pr_road_no`='$pRoadNo',
					`pr_city_town`='$pCityTown',
					`pr_zip_post`='$pZipPostCode',
					`pe_flat_house_no`='$peFlatHouseNo',
					`pe_road_no`='$peRoadNo',
					`pe_city_town`='$peCityTown',
					`pe_zip_post`='$peZipPostCode',
					`passport_number`='$passportNumber',
					`passport_issue`='$passportIssueDate',
					`passport_expire`='$passportExpireDate',
					`permission_edit_profile`='$permission_edit_profile'
					WHERE `wp_user_id`='$feb_wp_get_current_user_id'";

				if (mysqli_query($feb_db_connection, $update)) {
					header("Location: profile-update-success.php");
				} else {
				    echo "Error updating record:";
				} // If Update Msg

		} // User ID exist if feb_user_id_checks and If permission for edit profile
	}
	elseif(feb_get_permission_edit_profile($_SESSION['feb_wp_get_current_user_id'])==0){
?>
		<!-- Error Templete -->
		<body style="width:100%;max-height:100vh;color:#fff;background-color:#232222;">
			<br><link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<center>
			<h1 style="color:red;text-transform:uppercase;line-height:50px;">
				<span>
					<i style="font-size:220px" class="material-icons">sentiment_very_dissatisfied</i>
					</span>
					<br>You have not permission for edit your profile.
					<br>Every user can update there information only single time.
					<br><span style="color:#fff;">Please <a title="Click here for go to contact page." style="color:white;" href="../../contact-us">contact</a> with Administration.
					<br><br><a title="Click here for go to your profile page." style="color:#000;border:1px solid #000;text-decoration:none;padding:7px 10px;background-color:#fff;box-shadow: 5px 4px 8px #000;" href="../">Go to your Profile</a>
				</span>
			</h1>
		</center>
	</body><!-- Error Template end -->
<?php
	}// get permssion status if false or have not permission
	else{
		echo "Site error Unknow. Contact with Developer @asifulmamun.";
	} //if another error
} // Check Page Method GET or Post
 ?>
