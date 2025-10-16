<?php
require_once '../config.php';
$conn = getDBConnection();

$carId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($carId === 0) {
    header('Location: index.php');
    exit;
}

// Get car details
$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $carId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php');
    exit;
}

$car = $result->fetch_assoc();

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $year = intval($_POST['year']);
    $price = floatval($_POST['price']);
    $mileage = intval($_POST['mileage']);
    $color = trim($_POST['color']);
    $transmission = $_POST['transmission'];
    $fuelType = $_POST['fuel_type'];
    $description = trim($_POST['description']);
    $imageUrl = trim($_POST['image_url']);
    $status = $_POST['status'];
    
    if (empty($make) || empty($model) || $year === 0 || $price === 0.0) {
        $errorMessage = 'Please fill in all required fields.';
    } else {
        $stmt = $conn->prepare("UPDATE cars SET make = ?, model = ?, year = ?, price = ?, mileage = ?, color = ?, transmission = ?, fuel_type = ?, description = ?, image_url = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssidissssssi", $make, $model, $year, $price, $mileage, $color, $transmission, $fuelType, $description, $imageUrl, $status, $carId);
        
        if ($stmt->execute()) {
            $successMessage = 'Vehicle updated successfully!';
            // Refresh car data
            $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
            $stmt->bind_param("i", $carId);
            $stmt->execute();
            $result = $stmt->get_result();
            $car = $result->fetch_assoc();
        } else {
            $errorMessage = 'An error occurred. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle - Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        header {
            background: #e74c3c;
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .back-link {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            transition: opacity 0.3s;
        }
        
        .back-link:hover {
            opacity: 0.8;
        }
        
        h1 {
            font-size: 2rem;
        }
        
        .form-container {
            background: white;
            margin: 2rem 0;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #e74c3c;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .required {
            color: #e74c3c;
        }
        
        .btn-submit {
            background: #27ae60;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-submit:hover {
            background: #229954;
        }
        
        .help-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="back-link">← Back to Admin</a>
            <h1>Edit Vehicle</h1>
        </div>
    </header>
    
    <div class="container">
        <div class="form-container">
            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?>
