<?php

// DBConnector class for database connection
class DBConnector {
    private $conn;

    public function __construct() {
        require_once 'connect.php';
        $this->conn = $conn;
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Interface for common CRUD operations
interface CRUDOperations {
    public function create($data);
    public function readAll();
}

// InventoryManager class implementing CRUDOperations interface
class InventoryManager implements CRUDOperations {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($data) {
        $idinventory = $data['idinventory'];
        $inventoryName = $data['inventoryName'];
        $inventoryQuantity = $data['inventoryQuantity'];
        $statusinventory = $data['inventoryStatus'];

        $sql = "INSERT INTO inventory (idinventaris, nama_inventaris, jumlah_inventaris, status_inventaris) 
                VALUES ('$idinventory', '$inventoryName', '$inventoryQuantity', '$statusinventory')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function readAll() {
        $sql = "SELECT idinventaris, nama_inventaris, jumlah_inventaris, status_inventaris FROM inventory";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}

// Create instances
$dbConnector = new DBConnector();
$conn = $dbConnector->getConnection();
$inventoryManager = new InventoryManager($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request
    $data = [
        'idinventory' => $_POST['idinventory'],
        'inventoryName' => $_POST['inventoryName'],
        'inventoryQuantity' => $_POST['inventoryQuantity'],
        'inventoryStatus' => $_POST['inventoryStatus']
    ];

    $inventoryManager->create($data);

    $conn->close();
    exit;
}

// Display data from the database
$rows = $inventoryManager->readAll();

$conn->close();

?>

<!-- Your HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <!-- Link to your CSS file here -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<header>
    <h1>Inventory Management System</h1>
</header>

<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="home.php">Products</a></li>
        <li><a href="inventory.php">Inventory</a></li>
        <li><a href="transaksi.php">Transactions</a></li>
        <!-- Add more navigation links as needed -->
    </ul>
</nav>

<section id="inventory">
    <h2>Inventory</h2>
    <div class="button-container">
    <button onclick="addInventory()">Tambah Data</button>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID Inventory</th>
                <th>Nama Inventory</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Display data from the database -->
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['idinventaris']; ?></td>
                    <td><?= $row['nama_inventaris']; ?></td>
                    <td><?= $row['jumlah_inventaris']; ?></td>
                    <td><?= $row['status_inventaris']; ?></td>
                    <td>
                        <button onclick="editProduct(<?= $row['idinventaris']; ?>)">Edit</button>
                        <button onclick="deleteinventory(<?= $row['idinventaris']; ?>)">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add Inventory</h2>
        <form id="addInventoryForm">
            <div class="form-group">
                <label for="idinventory"> ID Inventory:</label>
                <input type="text" id="id-inventory" name="idinventory" required>
            </div>
            <div class="form-group">
                <label for="inventoryName">Inventory Name:</label>
                <input type="text" id="inventoryName" name="inventoryName" required>
            </div>
            
            <div class="form-group">
                <label for="inventoryQuantity">Quantity:</label>
                <input type="number" id="inventoryQuantity" name="inventoryQuantity" required>
            </div>
            
            <div class="form-group">
    <label for="inventoryStatus">Inventory Status:</label>
    <select id="inventoryStatus" name="inventoryStatus" required>
        <option value="Available">Available</option>
        <option value="Not Available">Not Available</option>
    </select>
</div>

            
            <button type="button" onclick="submitInventoryForm()">Add Inventory</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
