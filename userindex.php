<?php
require_once "./email_send.php";
//userindex.php

//error_reporting(E_ALL);

session_start();

if(isset($_SESSION["user_id"]))
{
	header("location:home.php");
}

include('function.php');

$connect = new PDO("mysql:host=localhost; dbname=testing", "root", "");

$message = '';
$error_user_name = '';
$error_user_email = '';
$error_user_password = '';
$user_name = '';
$user_email = '';
$user_password = '';

if(isset($_POST["register"]))
{
	if(empty($_POST["user_name"]))
	{
		$error_user_name = "<label class='text-danger'>Enter Name</label>";
	}
	else
	{
		$user_name = trim($_POST["user_name"]);
		$user_name = htmlentities($user_name);
	}

	if(empty($_POST["user_email"]))
	{
		$error_user_email = '<label class="text-danger">Enter Email Address</label>';
	}
	else
	{
		$user_email = trim($_POST["user_email"]);
		if(!filter_var($user_email, FILTER_VALIDATE_EMAIL))
		{
			$error_user_email = '<label class="text-danger">Enter Valid Email Address</label>';
		}
	}

	if(empty($_POST["user_password"]))
	{
		$error_user_password = '<label class="text-danger">Enter Password</label>';
	}
	else
	{
		$user_password = trim($_POST["user_password"]);
		$user_password = md5($user_password);
	}

	if($error_user_name == '' && $error_user_email == '' && $error_user_password == '')
	{
		$user_activation_code = md5(rand());

		$user_otp = rand(100000, 999999);

		$data = array(
			':user_name'		=>	$user_name,
			':user_email'		=>	$user_email,
			':user_password'	=>	$user_password,
			':user_activation_code' => $user_activation_code,
			':user_email_status'=>	'not verified',
			':user_otp'			=>	$user_otp
		);

		$query = "
		INSERT INTO register_user 
		(user_name, user_email, user_password, user_activation_code, user_email_status, user_otp)
		SELECT * FROM (SELECT :user_name, :user_email, :user_password, :user_activation_code, :user_email_status, :user_otp) AS tmp
		WHERE NOT EXISTS (
		    SELECT user_email FROM register_user WHERE user_email = :user_email
		) LIMIT 1
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($connect->lastInsertId() == 0)
		{
			$message = '<label class="text-danger">Email Already Register</label>';
		}	
		else
		{
			$user_avatar = make_avatar(strtoupper($user_name[0]));

			$query = "
			UPDATE register_user 
			SET user_avatar = '".$user_avatar."' 
			WHERE register_user_id = '".$connect->lastInsertId()."'
			";

			$statement = $connect->prepare($query);

			$statement->execute();

			//print_r(error_get_last());
			
			//echo ("hi");

			

			if(mail_send($user_email,"Verify Code","For verify your email address, enter this verification code when prompted: ".$user_otp)){
				echo "check your email address";
			}else{
				echo "not send";
			}


		
		}

	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registration | Pāthika</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="asset/js/jquery.js"></script>
    	<script src="asset/js/bootstrap.min.js"></script>
    	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	</head>
	<body>
		<br />
		<div class="container">
			<h3 align="center">Registration for Pāthika</h3>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Registration</h3>
				</div>
				<div class="panel-body">
					<?php echo $message; ?>
					<form method="post">
						<div class="form-group">
							<label>Enter Your Name</label>
							<input type="text" name="user_name" class="form-control" />
							<?php echo $error_user_name; ?>
						</div>
						<div class="form-group">
							<label>Enter Your Email</label>
							<input type="text" name="user_email" class="form-control" />
							<?php echo $error_user_email; ?>
						</div>
						<div class="form-group">
							<label>Enter Your Password</label>
							<input type="password" name="user_password" class="form-control" />
							<?php echo $error_user_password; ?>
						</div>
						<div class="form-group">
							<input type="submit" name="register" class="btn btn-success" value="Click to Register" />&nbsp;&nbsp;&nbsp;
							<a href="resend_email_otp.php" class="btn btn-default">Resend OTP</a>
							&nbsp;&nbsp;&nbsp;
							<a href="login.php">Login</a>
						</div>
					</form>
				</div>
			</div>
		</div>
		<br />
		<br />
	</body>
</html>