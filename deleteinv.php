<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idinventaris = $_POST['idinventory'];

    // Validate and sanitize the input if necessary

    // Perform the deletion
    $sql = "DELETE FROM inventory WHERE idinventaris = '$idinventaris'";
    if ($conn->query($sql) === TRUE) {
        echo "inventory deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    exit;
}

?>

