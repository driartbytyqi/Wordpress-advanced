-- Create cars table
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    mileage INT NOT NULL,
    color VARCHAR(50) NOT NULL,
    transmission VARCHAR(20) NOT NULL,
    fuel_type VARCHAR(20) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    status VARCHAR(20) DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create inquiries table
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO cars (make, model, year, price, mileage, color, transmission, fuel_type, description, image_url) VALUES
('Toyota', 'Camry', 2022, 28500.00, 15000, 'Silver', 'Automatic', 'Gasoline', 'Well-maintained Toyota Camry with low mileage. Perfect for daily commuting.', '/placeholder.svg?height=400&width=600'),
('Honda', 'Civic', 2023, 26900.00, 8000, 'Blue', 'Automatic', 'Gasoline', 'Nearly new Honda Civic with excellent fuel economy and modern features.', '/placeholder.svg?height=400&width=600'),
('Ford', 'F-150', 2021, 42000.00, 25000, 'Black', 'Automatic', 'Gasoline', 'Powerful Ford F-150 pickup truck. Great for work and adventure.', '/placeholder.svg?height=400&width=600'),
('Tesla', 'Model 3', 2023, 45000.00, 5000, 'White', 'Automatic', 'Electric', 'Premium electric sedan with autopilot and long range battery.', '/placeholder.svg?height=400&width=600'),
('BMW', '3 Series', 2022, 48500.00, 12000, 'Gray', 'Automatic', 'Gasoline', 'Luxury sports sedan with premium interior and advanced technology.', '/placeholder.svg?height=400&width=600'),
('Chevrolet', 'Silverado', 2020, 38000.00, 35000, 'Red', 'Automatic', 'Diesel', 'Reliable work truck with towing capacity and spacious cabin.', '/placeholder.svg?height=400&width=600');
