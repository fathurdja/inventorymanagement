<?php

// Database connection class
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

// Base class for specific operations related to products
class ProductOperations implements CRUDOperations {
    protected $conn;
    protected $table;

    public function __construct($conn, $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function create($data) {
        $idProduct = $data['idproduct'];
        $productName = $data['productName'];
        $productQuantity = $data['productQuantity'];
        $inventoryType = $data['inventoryType'];

        $sql = "INSERT INTO {$this->table} (idproduct, nama_product, jumlah_product, jenis_inventaris) 
                VALUES ('$idProduct', '$productName', '$productQuantity', '$inventoryType')";

        if ($this->conn->query($sql) === TRUE) {
            echo "Data added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function readAll() {
        $sql = "SELECT idproduct, nama_product, jumlah_product, jenis_inventaris FROM {$this->table}";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}

// ProductManager class extending ProductOperations for additional operations
class ProductManager extends ProductOperations {
    public function __construct($conn) {
        parent::__construct($conn, 'product');
    }

    // Additional methods specific to product management can be added here
}

// Create instances
$dbConnector = new DBConnector();
$conn = $dbConnector->getConnection();
$productManager = new ProductManager($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request
    $data = [
        'idproduct' => $_POST['idproduct'],
        'productName' => $_POST['productName'],
        'productQuantity' => $_POST['productQuantity'],
        'inventoryType' => $_POST['inventoryType']
    ];

    $productManager->create($data);

    $conn->close();
    exit;
}

// Display data from the database
$rows = $productManager->readAll();

$conn->close();

?>

<!-- Your HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <!-- Link ke file CSS Anda di sini -->
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
        <!-- Tambahkan lebih banyak tautan navigasi sesuai kebutuhan Anda -->
    </ul>
</nav>
<section id="products">
    <h2>Products</h2>
    <div class="button-container">
        <button onclick="addInventory()">Tambah Data</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Product</th>
                <th>Nama Product</th>
                <th>Jumlah Product</th>
                <th>Jenis Inventaris</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Display data from the database -->
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['idproduct']; ?></td>
                    <td><?= $row['nama_product']; ?></td>
                    <td><?= $row['jumlah_product']; ?></td>
                    <td><?= $row['jenis_inventaris']; ?></td>
                    <td>
                        <button onclick="editProduct(<?= $row['idproduct']; ?>)">Edit</button>
                        <button onclick="deleteProduct(<?= $row['idproduct']; ?>)">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add Product</h2>
        <form id="addProductForm">
            <div class="form-group">
                <label for="id-product"> ID Product:</label>
                <input type="text" id="id-product" name="idproduct" required>
            </div>
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
            </div>
            
            <div class="form-group">
                <label for="productQuantity">Quantity:</label>
                <input type="number" id="productQuantity" name="productQuantity" required>
            </div>
            
            <div class="form-group">
                <label for="inventoryType">Inventory :</label>
                <input type="text" id="inventoryType" name="inventoryType" required>
            </div>
            <!-- <td><input type="submit" name="proses" value="simpan"></td> -->
            <!-- <button type="button" onclick="submitForm()">Add Product</button> -->
            <button type="button" onclick="submitForm()">Add Product</button>
        </form>
    </div>
</div>


   <script src="script.js"></script>
</body>
</html>
