<?php
include 'connectdb.php';
$conn = openConnection();

$email = $_POST['email'];
$username = $_POST['username'];
$prodname = $_POST['prodname'];
$productId = $_POST['productId'];
$role = $_POST['role'];
$owner="yes";

$stmt = $conn->prepare("INSERT INTO products (userId, userName, productName, productId,role,owner) VALUES (?, ?, ?, ?,?,?)");
$stmt->bind_param("ssssss", $email, $username, $prodname, $productId,$role,$owner);
$stmt->execute();
?>
