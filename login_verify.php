<?php

$connect =mysqli_connect("localhost","root","","testing");



if(!empty($_POST)){
	$code=$_POST['user_otp'];

	$query = "SELECT * FROM register_user WHERE user_otp='$code'";
	$data =	mysqli_query($connect,$query);

	$user = mysqli_num_rows($data);

	if($user>0){
		$query = "UPDATE register_user SET user_email_status = 'verified' WHERE user_otp = '$code'";
		$result = mysqli_query($connect, $query);

	
		if ($result > 0) {
			
			session_start();

			$row = mysqli_fetch_assoc($data);

			$_SESSION["user_id"] = $row["register_user_id"];

			header("location: profile.php");
		} else {
			echo "USer not verified";
		}
		
	}else{
		echo "error";
	}
	
	


}


?>





<!DOCTYPE html>
<html>
	<head>
		<title>OTP Verifiation | Pāthika</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="asset/js/jquery.js"></script>
    	<script src="asset/js/bootstrap.min.js"></script>
    	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	</head>
	<body>
		<br />
		<div class="container">
			<h3 align="center"> OTP Verifiation </h3>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Verify Your OTP From E-Mail</h3>
				</div>
				<div class="panel-body">
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                      <input type="text" name='user_otp'>
                      <button>Send</button>
                      </form>

				</div>
			</div>
		</div>
		<br />
		<br />
	</body>
</html>