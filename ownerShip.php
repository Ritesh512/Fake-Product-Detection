<?php
// Database connection
include 'connectdb.php';
$conn = openConnection();

// Product ID
$userId = $_POST['email'];
$productId = $_POST['productId'];
// SQL query to fetch the owner value based on the product ID
$sql = "SELECT owner FROM products WHERE  userId=? and productId=? ";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the product ID as a parameter
$stmt->bind_param("ss", $userId,$productId);

// Execute the query
$stmt->execute();

// Bind the result to a variable
$stmt->bind_result($owner);

// echo $owner; 
if ($stmt->fetch()) {
  echo $owner; 
} else {
    echo "Product not found 111";
}
$stmt->close();
$conn->close();

?>
