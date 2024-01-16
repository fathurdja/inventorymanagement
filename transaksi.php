<?php
require_once 'connect.php';
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

        $sql = "INSERT INTO  (idinventaris, nama_inventaris, jumlah_inventaris, status_inventaris) 
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

<!-- Inside <body> -->
<!-- Inside <body> -->
    <section id="transactions">
        <h2>Transactions</h2>
        <button onclick="addInventory()">Add Transaction</button>
        <table>
            <thead>
                <tr>
                    <th>ID Transaction</th>
                    <th>Type Transaction</th>
                    <th>Quantity</th>
                    <th>Schedule</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display data from the database -->
                <tr>
                    <td>1</td>
                    <td>In</td>
                    <td>5</td>
                    <td>2022-01-01</td>
                </tr>
                <!-- Add more rows based on your data -->
            </tbody>
        </table>
    </section>
    
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Transaction</h2>
            <form id="addTransactionForm">
                <div class="form-group">
                    <label for="idtransaction">ID Transaction:</label>
                    <input type="text" id="id-transaction" name="idtransaction" required>
                </div>
                <div class="form-group">
                    <label for="typeTransaction">Type Transaction:</label>
                    <select id="typeTransaction" name="typeTransaction" required>
                        <option value="Pembelian inventaris">Pembelian Inventaris</option>
                        <option value="Penjualan inventaris">Penjualan Inventaris</option>
                        <option value="Penghapusan inventaris">Penghapusan Inventaris</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="schedule">Schedule:</label>
                    <input type="date" id="schedule" name="schedule" required>
                </div>
                
                <button type="button" onclick="submitTransactionForm()">Add Transaction</button>
            </form>
        </div>
    </div>
    
    <script src="script.js"></script>
    </body>
    </html>
    
