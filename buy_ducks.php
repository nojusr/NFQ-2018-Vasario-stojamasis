
<?php
	# init
	$dbname = 'nfq';
	$dbuser = 'root';
	$dbpass = '******';
	$dbhost = 'localhost';
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($conn->connect_error){
			die("Connection failed: ". $conn->connect_error);
	}
	$name = $_POST['name'];
	$name = $conn->real_escape_string($name);
	$addr = $_POST['addr'];
	$addr = $conn->real_escape_string($addr);
	$amount = $_POST['amount'];
	
	$query = "SELECT * FROM variables";
	$result = $conn->query($query);
	$prices = $result->fetch_assoc();
	$dk = $prices["duck_price"];
	$sk = $prices["shipping_price"];
	
	$cost = $dk*$amount+$sk;
	
	$query ="INSERT INTO `orders`
	( `client_name`, `client_addr`, `amount_ordered`, `cost`) 
	VALUES ('".$name."','".$addr."','".$amount."','".$cost."')";
	$conn->query($query);
	
	echo "Užsakymas atliktas!";
	
	header("Location: http://nrnfqsubmission.tk/");
	die();
?>
