

<?php
include 'connectdb.php';
$conn = openConnection();

$userId = $_POST['email'];
$productId = $_POST['productId'];

$sql = "UPDATE products SET owner = 'no' where userId=? and productId=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userId, $productId);
$stmt->execute();


$stmt = $conn->prepare("SELECT ProductName FROM products WHERE userId = ? AND productId = ?");
$stmt->bind_param("ss", $userId, $productId);
$stmt->execute();
$stmt->bind_result($productName);

if ($stmt->fetch()) {
    echo $productName; 
} else {
    echo "Product not found 111";
}

$stmt->close();
$conn->close();
?>
