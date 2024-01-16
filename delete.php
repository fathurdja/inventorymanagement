<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['idproduct'];

    // Validate and sanitize the input if necessary

    // Perform the deletion
    $sql = "DELETE FROM product WHERE idproduct = '$productId'";
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    exit;
}

?>
