<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if (!empty(username) || !empty(email)  ||  !empty(password)  ||  !empty(confirm_password) ) 
{
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbname = "assignment";

	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

	if (mysqli_connect_error())
	{
		die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
	}
	else
	{
		$SELECT = "SELECT email from register Where email = ? Limit 1 ";
		$INSERT = "INSERT Into register (username, email, password, confirm_password) values(?, ?, ?, ?)";


		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if (rnum==0)
		{
			$stmt->close();

			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("ssss", $username, $email, $password, $confirm_password);
			$stmt->execute();
			echo "New Record Inserted Successfully";
		}
		else
		{
			echo "Someone already regestered using this email";
		}
		$stmt->close();
		$conn->close();

	}	


}
else
{
		echo "All field are required";
		die();
}


?>