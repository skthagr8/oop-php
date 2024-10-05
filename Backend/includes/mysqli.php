<?php
	$servername = "localhost";
	$username = "root";
	$password = "1234567";
	$bdname = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $bdname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully";
?> 