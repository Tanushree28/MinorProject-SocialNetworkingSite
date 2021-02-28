<?php

$connect =mysqli_connect("localhost","root","","testing");



if(!empty($_POST)){
	$code=$_POST['opt'];
	 $password=md5($_POST['user_password']);

	$query = "SELECT * FROM login_data WHERE otp='$code'";
	$data=	mysqli_query($connect,$query);

	$totalUsers=mysqli_num_rows($data);

	if($totalUsers>0){
		
		header("Location:login_verify.php");
	}else{
		echo "error";
	}
	
	


}


?>


<form action="">

<input type="text" name='opt'>
<button>Send</button>
</form>