 <?php
	$Message = $_POST[('message')];
	$conn = new mysqli('localhost','root','','chat');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into message(message) values(?)");
		$stmt->bind_param("s", $Message );
		$execval = $stmt->execute();
		echo $execval;
		$stmt->close();
		$conn->close();
	}
	?>