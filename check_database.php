<?php
// Database check script
include('includes/config.php');

// Create connection
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>Database Connection: SUCCESS</h2>";
echo "<p>Connected to database: " . DATABASE_NAME . "</p>";

// Check invoices table
echo "<h3>Invoices Table Check:</h3>";
$result = $mysqli->query("SELECT invoice, COUNT(*) as count FROM invoices GROUP BY invoice HAVING COUNT(*) > 1");
if ($result->num_rows > 0) {
    echo "<p style='color:red;'><strong>DUPLICATE INVOICES FOUND:</strong></p>";
    echo "<table border='1' cellpadding='5'><tr><th>Invoice #</th><th>Count</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['invoice'] . "</td><td>" . $row['count'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:green;'>No duplicate invoices found.</p>";
}

// Check total invoices
$result = $mysqli->query("SELECT COUNT(*) as total FROM invoices");
$row = $result->fetch_assoc();
echo "<p>Total invoices in database: <strong>" . $row['total'] . "</strong></p>";

// Check latest invoice number
$result = $mysqli->query("SELECT MAX(CAST(invoice AS UNSIGNED)) as max_invoice FROM invoices");
$row = $result->fetch_assoc();
echo "<p>Highest invoice number: <strong>" . $row['max_invoice'] . "</strong></p>";

// Check users table
echo "<h3>Users Table Check:</h3>";
$result = $mysqli->query("SELECT username, email FROM users");
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr><th>Username</th><th>Email</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['username'] . "</td><td>" . $row['email'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red;'>No users found in database!</p>";
}

// Check customers table
echo "<h3>Customers Table Check:</h3>";
$result = $mysqli->query("SELECT COUNT(*) as total FROM customers");
$row = $result->fetch_assoc();
echo "<p>Total customers: <strong>" . $row['total'] . "</strong></p>";

// Check products table
echo "<h3>Products Table Check:</h3>";
$result = $mysqli->query("SELECT COUNT(*) as total FROM products");
$row = $result->fetch_assoc();
echo "<p>Total products: <strong>" . $row['total'] . "</strong></p>";

// Check invoice_items table
echo "<h3>Invoice Items Table Check:</h3>";
$result = $mysqli->query("SELECT COUNT(*) as total FROM invoice_items");
$row = $result->fetch_assoc();
echo "<p>Total invoice items: <strong>" . $row['total'] . "</strong></p>";

$mysqli->close();
?>
