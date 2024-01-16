// Add to your existing JavaScript file or in a script tag at the end of the body
function addInventory() {
    var modal = document.getElementById('modal');
    modal.style.display = 'block';
}

function closeModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'none';
}

function submitForm() {
    var formData = new FormData(document.getElementById('addProductForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'home.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            closeModal(); // Optionally close the modal after successful submission
        }
    };

    xhr.send(formData);
}
// function submitForm() {
//     var formData = new FormData(document.getElementById('addProductForm'));
//     console.log('Form Data:', formData);

//     // rest of your code
// }
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        // Perform AJAX request to delete the product
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete.php', true); // Change the URL to your actual deletion script
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
                // Reload or update the table after deletion
                location.reload(); // You may consider updating the table dynamically without reloading the entire page
            } else {
                console.error('Error:', xhr.statusText);
            }
        };
        xhr.send('idproduct=' + productId);
    }
}

// Function to edit a product
function editProduct(productId) {
    // You can implement the edit functionality here
    // For example, open a modal with a form pre-filled with the product details for editing
    // You may need additional JavaScript or a library (e.g., jQuery) for handling modals and form submissions
    // This is a simplified example, and you should adapt it based on your specific requirements
    alert('Edit functionality will be implemented here. Product ID: ' + productId);
}

function submitInventoryForm() {
    var formData = new FormData(document.getElementById('addInventoryForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'inventory.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            closeModal(); // Optionally close the modal after successful submission
        }
    };

    xhr.send(formData);
}

function deleteinventory(idInventory) {
    if (confirm('Are you sure you want to delete this product?')) {
        // Perform AJAX request to delete the product
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'deleteinv.php', true); // Change the URL to your actual deletion script
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
                // Reload or update the table after deletion
                location.reload(); // You may consider updating the table dynamically without reloading the entire page
            } else {
                console.error('Error:', xhr.statusText);
            }
        };
        xhr.send('idinventory=' + idInventory);
    }
}
function submitTransactionForm() {
    // Fetch form data
    var formData = new FormData(document.getElementById('addTransactionForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'transaksi.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            closeModal(); // Optionally close the modal after successful submission
        }
    };

    xhr.send(formData);
}