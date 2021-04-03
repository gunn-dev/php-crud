<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "crud_pdo";

try {
	$con = new PDO("mysql:host=$servername", $username, $password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS crud_pdo";
	$con->exec($sql);
} catch (PDOException $e) {
	echo 'Error ' . $e->getMessage();
} finally {
	unset($con);
	echo 'Database created successfully.<br>';
}

try {
	$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql1 = "CREATE TABLE IF NOT EXISTS employees(
		id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(30) NOT NULL,
		address VARCHAR(80) NOT NULL,
		salary INT NOT NULL
		)";
	$conn->exec($sql1);
} catch (PDOException $e) {
	echo 'Error ' . $e->getMessage();
} finally {
	unset($conn);
	echo 'Table employees created successfully';
}
