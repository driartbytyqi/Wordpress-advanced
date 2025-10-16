<?php
require_once 'config.php';
$conn = getDBConnection();

// Get filter parameters
$make = isset($_GET['make']) ? $_GET['make'] : '';
$maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';

// Build query
$sql = "SELECT * FROM cars WHERE status = 'available'";
$params = [];
$types = '';

if ($make) {
    $sql .= " AND make = ?";
    $params[] = $make;
    $types .= 's';
}

if ($maxPrice) {
    $sql .= " AND price <= ?";
    $params[] = $maxPrice;
    $types .= 'd';
}

if ($transmission) {
    $sql .= " AND transmission = ?";
    $params[] = $transmission;
    $types .= 's';
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get unique makes for filter
$makesResult = $conn->query("SELECT DISTINCT make FROM cars ORDER BY make");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Auto Sales - Quality Used Cars</title>
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
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .tagline {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .filters {
            background: white;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .filter-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
        }
        
        .filter-item {
            flex: 1;
            min-width: 200px;
        }
        
        .filter-item label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }
        
        .filter-item select,
        .filter-item input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .filter-item select:focus,
        .filter-item input:focus {
            outline: none;
            border-color: #2a5298;
        }
        
        .btn {
            background: #2a5298;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #1e3c72;
        }
        
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .car-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .car-image {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }
        
        .car-details {
            padding: 1.5rem;
        }
        
        .car-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 0.5rem;
        }
        
        .car-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 1rem;
        }
        
        .car-specs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .spec-item {
            font-size: 0.9rem;
            color: #666;
        }
        
        .spec-label {
            font-weight: 600;
            color: #333;
        }
        
        .btn-view {
            display: block;
            width: 100%;
            text-align: center;
            background: #2a5298;
            color: white;
            padding: 0.75rem;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .btn-view:hover {
            background: #1e3c72;
        }
        
        .no-results {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .no-results h2 {
            color: #666;
            margin-bottom: 1rem;
        }
        
        footer {
            background: #1e3c72;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .admin-link {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #e74c3c;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
            transition: all 0.3s;
        }
        
        .admin-link:hover {
            background: #c0392b;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Premium Auto Sales</h1>
            <p class="tagline">Your trusted source for quality pre-owned vehicles</p>
        </div>
    </header>
    
    <div class="container">
        <div class="filters">
            <form method="GET" action="">
                <div class="filter-group">
                    <div class="filter-item">
                        <label for="make">Make</label>
                        <select name="make" id="make">
                            <option value="">All Makes</option>
                            <?php while ($makeRow = $makesResult->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($makeRow['make']); ?>" 
                                    <?php echo $make === $makeRow['make'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($makeRow['make']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="filter-item">
                        <label for="max_price">Max Price</label>
                        <input type="number" name="max_price" id="max_price" 
                               placeholder="Any price" value="<?php echo htmlspecialchars($maxPrice); ?>">
                    </div>
                    
                    <div class="filter-item">
                        <label for="transmission">Transmission</label>
                        <select name="transmission" id="transmission">
                            <option value="">All Types</option>
                            <option value="Automatic" <?php echo $transmission === 'Automatic' ? 'selected' : ''; ?>>Automatic</option>
                            <option value="Manual" <?php echo $transmission === 'Manual' ? 'selected' : ''; ?>>Manual</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Search</button>
                </div>
            </form>
        </div>
        
        <?php if ($result->num_rows > 0): ?>
            <div class="cars-grid">
                <?php while ($car = $result->fetch_assoc()): ?>
                    <div class="car-card">
                        <img src="<?php echo htmlspecialchars($car['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>" 
                             class="car-image">
                        <div class="car-details">
                            <h2 class="car-title">
                                <?php echo htmlspecialchars($car['year'] . ' ' . $car['make'] . ' ' . $car['model']); ?>
                            </h2>
                            <div class="car-price"><?php echo formatPrice($car['price']); ?></div>
                            <div class="car-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Mileage:</span> 
                                    <?php echo formatMileage($car['mileage']); ?>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Color:</span> 
                                    <?php echo htmlspecialchars($car['color']); ?>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Transmission:</span> 
                                    <?php echo htmlspecialchars($car['transmission']); ?>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Fuel:</span> 
                                    <?php echo htmlspecialchars($car['fuel_type']); ?>
                                </div>
                            </div>
                            <a href="car-details.php?id=<?php echo $car['id']; ?>" class="btn-view">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <h2>No vehicles found</h2>
                <p>Try adjusting your search filters to see more results.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 Premium Auto Sales. All rights reserved.</p>
        </div>
    </footer>
    
    <a href="admin/" class="admin-link">Admin Panel</a>
</body>
</html>
<?php
$conn->close();
?>
