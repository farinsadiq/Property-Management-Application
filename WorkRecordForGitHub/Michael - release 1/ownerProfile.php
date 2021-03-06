
<?php
include ('includes/functions/db.php');
include ('includes/functions/formControls.php');
include('includes/accountSessions.php');


$errors = array();
$loginId = $_SESSION['idLogin'];

if (isset($_POST['submit'])){
	
	require 'includes/functions/validate.php';
	
	validateEmail($errors,$_POST,'email');
	validateText($errors, $_POST,'firstName');
	validateText($errors, $_POST,'lastName');
	validateDOB($errors, $_POST, 'DOB');
	validateText($errors, $_POST, 'password');
	
	if (!$errors){
		
		$isMale = NULL;
		if (isset ($_POST['gender']) && $_POST['gender'] == 'male'){
			$isMale = 1;		
		} else {
			$isMale = 0;
		}
		db_updateOwner($loginId,$_POST['email'],$_POST['password'],$_POST['firstName'],$_POST['lastName'],$_POST['DOB'],$isMale);
		
		
		header("location: http://{$_SERVER['HTTP_HOST']}/property-Management-application/ownerProfile.php");
		exit();	
	}	
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<link href="css/theme.css" rel="stylesheet">
<title>Owner Profile</title>
</head>
<body>
<?php include('/includes/content/topNav.php'); ?>
<div class="page-header">
	<h1>Owner Profile</h1>
</div>
<div class="col-xs-offset-2"><div class="col-sm-9">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Profile</h3>
		</div>
	<div class="panel-body">
<?php include('/includes/content/topNav.php'); ?>
<form class= 'editForm' action = "ownerProfile.php" method = "POST" name = "updateOwnerAccount">
<?php

$ownerDetails = db_getOwnerDetails($loginId);

$selectedGender;
if ($ownerDetails['isMale'] == "1"){
	$selectedGender = 'male';
}else{
	$selectedGender = 'female';
}?>
<table class="table">

			<tbody>
	
<tr><td>Your Email</td><td><?php ctrl_input_field($errors,'text','REQUIRED','email','','txtEmail',$ownerDetails['email']);?></td></tr>
<tr><td>New Password</td><td><?php ctrl_input_field($errors, 'text','REQUIRED','password','','txtPassword',$ownerDetails['password']); ?></td></tr>
<tr><td>First Name</td><td><?php ctrl_input_field($errors,'text','REQUIRED','firstName','','txtFirstName',$ownerDetails['firstName']); ?></td></tr>
<tr><td>Last Name</td><td><?php ctrl_input_field($errors,'text','OPTIONAL','lastName','','txtLastName',$ownerDetails['lastName']); ?></td></tr>
<tr><td>Date of Birth</td><td><?php ctrl_input_field($errors,'date','OPTIONAL','DOB','','dtpDOB',$ownerDetails['DOB']);	?></td></tr>
<?php $genderValues = array('male','female');
$genderLabels = array('Male','Female');?>
<tr><td><?php ctrl_input_radio($errors,'gender',$genderValues,$genderLabels,'classNameNotImplemented',$selectedGender); ?></td></tr>
<tr><td><?php ctrl_submit('Save'); ?></td></tr>
</tbody>
</table>
</form>
</body>
</html>