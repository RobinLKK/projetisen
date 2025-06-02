<?php
	$servername = "robeuxw977.mysql.db"; 
	$username = "robeuxw977"; 
	$password ="Robaxel1209"; 
	$database = "robeuxw977";
	
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
?>