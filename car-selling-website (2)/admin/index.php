<?php
require_once '../config.php';
$conn = getDBConnection();

// Handle delete action
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    header('Location: index.php');
    exit;
}

// Get all cars
$result = $conn->query("SELECT * FROM cars ORDER BY created_at DESC");

// Get inquiries count
$inquiriesResult = $conn->query("SELECT COUNT(*) as count FROM inquiries");
$inquiriesCount = $inquiriesResult->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Premium Auto Sales</title>
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        h1 {
            font-size: 2rem;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background 0.3s;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #e74c3c;
        }
        
        .actions {
            margin-bottom: 2rem;
        }
        
        .btn {
            display: inline-block;
            background: #27ae60;
            color: white;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #229954;
        }
        
        .cars-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .car-thumb {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-small {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 4px;
            transition: opacity 0.3s;
        }
        
        .btn-edit {
            background: #3498db;
            color: white;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        
        .btn-small:hover {
            opacity: 0.8;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-available {
            background: #d4edda;
            color: #155724;
        }
        
        .status-sold {
            background: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 768px) {
            .cars-table {
                overflow-x: auto;
            }
            
            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Admin Panel</h1>
                <div class="nav-links">
                    <a href="../index.php">View Site</a>
                    <a href="inquiries.php">Inquiries (<?php echo $inquiriesCount; ?>)</a>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Total Vehicles</div>
                <div class="stat-value"><?php echo $result->num_rows; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Inquiries</div>
                <div class="stat-value"><?php echo $inquiriesCount; ?></div>
            </div>
        </div>
        
        <div class="actions">
            <a href="add-car.php" class="btn">+ Add New Vehicle</a>
        </div>
        
        <div class="cars-table">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Vehicle</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Mileage</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($car = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($car['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?>" 
                                     class="car-thumb">
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($car['year']); ?></td>
                            <td><?php echo formatPrice($car['price']); ?></td>
                            <td><?php echo formatMileage($car['mileage']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $car['status']; ?>">
                                    <?php echo ucfirst($car['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="edit-car.php?id=<?php echo $car['id']; ?>" class="btn-small btn-edit">Edit</a>
                                    <a href="?delete=<?php echo $car['id']; ?>" 
                                       class="btn-small btn-delete" 
                                       onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
