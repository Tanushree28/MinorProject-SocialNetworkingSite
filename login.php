<?php

$connect =mysqli_connect("localhost","root","","testing");
require_once "./email_send.php";




session_start();

if(isset($_SESSION["user_id"]))
{
	header("location:home.php");
}



if(!empty($_POST)){
	$email=$_POST['user_email'];
	 $password=md5($_POST['user_password']);

	$query = "SELECT * FROM register_user WHERE user_email='$email' AND  user_password='$password'";
	$data=	mysqli_query($connect,$query);

	$totalUsers=mysqli_num_rows($data);

	if($totalUsers>0){
		$opt=uniqid();

			
	if(mail_send($email,'test','your code is'.$opt)){
		// insert into tbl_logn (otp)
		header("Location:login_verify.php");
	}else{
		echo "error";
	}
	
	}else{
		echo "username & password not match";
	}



}


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login |  Pāthika</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="asset/js/jquery.js"></script>
    	<script src="asset/js/bootstrap.min.js"></script>
    	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	</head>
	<body>
		<br />
		<div class="container">
			<h3 align="center">Final Verification</h3>
			<br />

			<?php
			if(isset($_GET["register"]))
			{
				if($_GET["register"] == 'success')
				{
					echo '
					<h1 class="text-success">Email Successfully verified, Registration Process Completed...</h1>
					';
				}
			}

			if(isset($_GET["reset_password"]))
			{
				if($_GET["reset_password"] == 'success')
				{
					echo '<h1 class="text-success">Password change Successfully, Now you can login with your new password</h1>';
				}
			}
			?>

			<div class="row">
				<div class="col-md-3">&nbsp;</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Login</h3>
						</div>
						<div class="panel-body">
							<form method="POST" id="login_form">
								<div class="form-group" id="email_area">
									<label>Enter Email Address</label>
									<input type="text" name="user_email" id="user_email" class="form-control" />
									<span id="user_email_error" class="text-danger"></span>
								</div>
								<div class="form-group" id="password_area">
									<label>Enter password</label>
									<input type="password" name="user_password" id="user_password" class="form-control" />
									<span id="user_password_error" class="text-danger"></span>
								</div>
								<div class="form-group">
								<button>Login</button>
								</div>
							</form>
						</div>
					</div>
					<div align="center">
						<b><a href="forget_password.php?step1=1">Forgot Password</a></b>
					</div>
				</div>
			</div>
			
		</div>
		<br />
		<br />
	</body>
</html>

<script>

// $(document).ready(function(){
// 	$('#login_form').on('submit', function(event){
// 		event.preventDefault();
// 		var action = $('#action').val();
// 		$.ajax({
// 			url:"login_verify.php",
// 			method:"POST",
// 			data:$(this).serialize(),
// 			dataType:"json",
// 			beforeSend:function()
// 			{
// 				$('#next').attr('disabled', 'disabled');
// 			},
// 			success:function(data)
// 			{
// 				$('#next').attr('disabled', false);
// 				if(action == 'email')
// 				{
// 					if(data.error != '')
// 					{
// 						$('#user_email_error').text(data.error);
// 					}
// 					else
// 					{
// 						$('#user_email_error').text('');
// 						$('#email_area').css('display', 'none');
// 						$('#password_area').css('display', 'block');
// 					}
// 				}
// 				else if(action == 'password')
// 				{
// 					if(data.error != '')
// 					{
// 						$('#user_password_error').text(data.error);
// 					}
// 					else
// 					{
// 						$('#user_password_error').text('');
// 						$('#password_area').css('display', 'none');
// 						$('#otp_area').css('display', 'block');
// 					}
// 				}
// 				else
// 				{
// 					if(data.error != '')
// 					{
// 						$('#user_otp_error').text(data.error);
// 					}
// 					else
// 					{
// 						window.location.replace("home.php");
// 					}
// 				}

// 				$('#action').val(data.next_action);
// 			}
// 		})
// 	});
// });

// </script>