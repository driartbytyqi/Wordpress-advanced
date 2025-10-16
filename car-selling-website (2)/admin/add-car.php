<?php
require_once '../config.php';
$conn = getDBConnection();

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
        $stmt = $conn->prepare("INSERT INTO cars (make, model, year, price, mileage, color, transmission, fuel_type, description, image_url, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssidissssss", $make, $model, $year, $price, $mileage, $color, $transmission, $fuelType, $description, $imageUrl, $status);
        
        if ($stmt->execute()) {
            $successMessage = 'Vehicle added successfully!';
            // Clear form
            $_POST = array();
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
    <title>Add Vehicle - Admin Panel</title>
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
            <h1>Add New Vehicle</h1>
        </div>
    </header>
    
    <div class="container">
        <div class="form-container">
            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>
            
            <?php if ($errorMessage): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="make">Make <span class="required">*</span></label>
                        <input type="text" id="make" name="make" required value="<?php echo isset($_POST['make']) ? htmlspecialchars($_POST['make']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="model">Model <span class="required">*</span></label>
                        <input type="text" id="model" name="model" required value="<?php echo isset($_POST['model']) ? htmlspecialchars($_POST['model']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="year">Year <span class="required">*</span></label>
                        <input type="number" id="year" name="year" min="1900" max="2025" required value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price <span class="required">*</span></label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="mileage">Mileage</label>
                        <input type="number" id="mileage" name="mileage" min="0" value="<?php echo isset($_POST['mileage']) ? htmlspecialchars($_POST['mileage']) : '0'; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" id="color" name="color" value="<?php echo isset($_POST['color']) ? htmlspecialchars($_POST['color']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="transmission">Transmission</label>
                        <select id="transmission" name="transmission">
                            <option value="Automatic" <?php echo (isset($_POST['transmission']) && $_POST['transmission'] === 'Automatic') ? 'selected' : ''; ?>>Automatic</option>
                            <option value="Manual" <?php echo (isset($_POST['transmission']) && $_POST['transmission'] === 'Manual') ? 'selected' : ''; ?>>Manual</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuel_type">Fuel Type</label>
                        <select id="fuel_type" name="fuel_type">
                            <option value="Gasoline" <?php echo (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Gasoline') ? 'selected' : ''; ?>>Gasoline</option>
                            <option value="Diesel" <?php echo (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                            <option value="Electric" <?php echo (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Electric') ? 'selected' : ''; ?>>Electric</option>
                            <option value="Hybrid" <?php echo (isset($_POST['fuel_type']) && $_POST['fuel_type'] === 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="available" <?php echo (isset($_POST['status']) && $_POST['status'] === 'available') ? 'selected' : ''; ?>>Available</option>
                        <option value="sold" <?php echo (isset($_POST['status']) && $_POST['status'] === 'sold') ? 'selected' : ''; ?>>Sold</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="text" id="image_url" name="image_url" value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>">
                    <div class="help-text">Enter a full URL or use placeholder format: /placeholder.svg?height=400&width=600&query=car+description</div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                
                <button type="submit" class="btn-submit">Add Vehicle</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
