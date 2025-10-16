<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'car_dealership');

// Create database connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Format price
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

// Format mileage
function formatMileage($mileage) {
    return number_format($mileage) . ' miles';
}
?>
