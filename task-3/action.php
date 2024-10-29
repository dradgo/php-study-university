<?php
header("Content-Type: application/json");
$user = 'root';
$password = 'mypass';
$db = 'php_study';
$host = '127.0.0.1';
$port = 3306;
$conn = mysqli_connect($host, $user, $password, $db);

$stmt = $conn->prepare("INSERT INTO my_users (name, age, text_comment) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $age, $comment);

$json = file_get_contents('php://input');

$data = json_decode($json);

$name = $_POST["user_name"];
$age = $_POST["user_age"];
$comment = $_POST["text_comment"];

$stmt->execute();

$response = new stdClass();
$response->result = "Success!";

$stmt->close();
$conn->close();
echo json_encode($response);
?>