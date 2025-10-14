<?php
<?php
/*
Template Name: All Cars
*/
get_header();
?>

<div class="dealership-section" style="max-width:1100px;margin:auto;padding:2rem;">
    <h1 style="font-size:2.4rem;font-weight:800;text-align:center;margin-bottom:2rem;color:#003366;">
        All Cars
    </h1>
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
        gap:2.5rem;
        justify-items:center;
    ">
        <?php
        $cars = [
            // Copy the full $cars array from your index.php here (all 40 cars)
            ["Toyota Camry 2022", "https://images.unsplash.com/photo-1549921296-3a4bfe3b1d4a?auto=format&fit=crop&w=400&q=80", "$25,000", "15,000 miles", "Silver", "New"],
            ["Honda Accord 2021", "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=400&q=80", "$22,500", "20,000 miles", "Black", "Used"],
            ["Ford Mustang 2020", "https://images.unsplash.com/photo-1511918984145-48de785d4c4e?auto=format&fit=crop&w=400&q=80", "$30,000", "10,000 miles", "Red", "Featured"],
            ["BMW X5 2023", "https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80", "$55,000", "5,000 miles", "White", "Luxury"],
            ["Chevrolet Corvette 2019", "https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=400&q=80", "$45,000", "18,000 miles", "Yellow", "Sport"],
            ["Audi A4 2022", "https://images.unsplash.com/photo-1511391403515-ec7a7b43a6c7?auto=format&fit=crop&w=400&q=80", "$40,000", "12,000 miles", "Blue", "Premium"],
            ["Mercedes-Benz C-Class 2021", "https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=400&q=80", "$38,000", "14,000 miles", "Black", "Luxury"],
            ["Volkswagen Golf 2020", "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80", "$20,000", "22,000 miles", "White", "Used"],
            ["Hyundai Elantra 2022", "https://images.unsplash.com/photo-1461632830798-3adb3034e4c8?auto=format&fit=crop&w=400&q=80", "$19,500", "9,000 miles", "Blue", "New"],
            ["Kia Sportage 2021", "https://images.unsplash.com/photo-1515165562835-cf7747d3f7b1?auto=format&fit=crop&w=400&q=80", "$24,000", "17,000 miles", "Gray", "Used"],
            ["Mazda CX-5 2022", "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80", "$27,000", "8,000 miles", "Red", "New"],
            ["Subaru Outback 2020", "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80", "$26,000", "19,000 miles", "Green", "Featured"],
            ["Nissan Altima 2021", "https://images.unsplash.com/photo-1468421870903-4df1664ac249?auto=format&fit=crop&w=400&q=80", "$23,000", "16,000 miles", "Silver", "Used"],
            ["Jeep Wrangler 2019", "https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=400&q=80", "$35,000", "25,000 miles", "Orange", "Sport"],
            ["Tesla Model 3 2022", "https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?auto=format&fit=crop&w=400&q=80", "$48,000", "6,000 miles", "White", "Electric"],
            ["Porsche 911 2021", "https://images.unsplash.com/photo-1519648023493-d82b5f8d7b8a?auto=format&fit=crop&w=400&q=80", "$90,000", "4,000 miles", "Black", "Luxury"],
            ["Lexus RX 2020", "https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80", "$42,000", "13,000 miles", "Silver", "Premium"],
            ["Chevrolet Tahoe 2022", "https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=400&q=80", "$53,000", "7,000 miles", "Black", "New"],
            ["Honda Civic 2021", "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80", "$21,000", "18,000 miles", "Blue", "Used"],
            ["Ford Explorer 2020", "https://images.unsplash.com/photo-1461632830798-3adb3034e4c8?auto=format&fit=crop&w=400&q=80", "$32,000", "20,000 miles", "Gray", "Featured"],
            ["Toyota RAV4 2021", "https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=400&q=80", "$29,000", "12,000 miles", "White", "SUV"],
            ["Ford F-150 2022", "https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=400&q=80", "$40,000", "8,000 miles", "Blue", "Truck"],
            ["Chevrolet Malibu 2020", "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80", "$23,500", "21,000 miles", "Gray", "Sedan"],
            ["BMW 3 Series 2019", "https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80", "$35,000", "24,000 miles", "Black", "Luxury"],
            ["Audi Q5 2022", "https://images.unsplash.com/photo-1511391403515-ec7a7b43a6c7?auto=format&fit=crop&w=400&q=80", "$50,000", "7,000 miles", "Silver", "SUV"],
            ["Hyundai Tucson 2021", "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80", "$26,000", "15,000 miles", "Red", "SUV"],
            ["Kia Sorento 2020", "https://images.unsplash.com/photo-1461632830798-3adb3034e4c8?auto=format&fit=crop&w=400&q=80", "$28,000", "18,000 miles", "Blue", "SUV"],
            ["Mazda3 2022", "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80", "$22,000", "9,000 miles", "Gray", "Sedan"],
            ["Subaru Forester 2021", "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80", "$27,500", "13,000 miles", "Green", "SUV"],
            ["Nissan Rogue 2020", "https://images.unsplash.com/photo-1468421870903-4df1664ac249?auto=format&fit=crop&w=400&q=80", "$25,000", "20,000 miles", "White", "SUV"],
            ["Jeep Grand Cherokee 2022", "https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=400&q=80", "$44,000", "6,000 miles", "Black", "SUV"],
            ["Tesla Model S 2021", "https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?auto=format&fit=crop&w=400&q=80", "$85,000", "5,000 miles", "Red", "Electric"],
            ["Porsche Cayenne 2020", "https://images.unsplash.com/photo-1519648023493-d82b5f8d7b8a?auto=format&fit=crop&w=400&q=80", "$75,000", "11,000 miles", "Silver", "Luxury"],
            ["Lexus ES 2022", "https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80", "$41,000", "8,000 miles", "White", "Premium"],
            ["Chevrolet Equinox 2021", "https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=400&q=80", "$27,000", "14,000 miles", "Blue", "SUV"],
            ["Honda Pilot 2020", "https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80", "$33,000", "19,000 miles", "Gray", "SUV"],
            ["Ford Escape 2022", "https://images.unsplash.com/photo-1461632830798-3adb3034e4c8?auto=format&fit=crop&w=400&q=80", "$28,500", "7,000 miles", "Red", "SUV"],
            ["Volkswagen Passat 2021", "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80", "$24,000", "16,000 miles", "Silver", "Sedan"],
            ["Hyundai Santa Fe 2020", "https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80", "$29,500", "21,000 miles", "White", "SUV"],
            ["Kia Optima 2022", "https://images.unsplash.com/photo-1515165562835-cf7747d3f7b1?auto=format&fit=crop&w=400&q=80", "$23,000", "10,000 miles", "Black", "Sedan"],
        ];
        foreach ($cars as $car) {
            list($name, $img, $price, $mileage, $color, $tag) = $car;
            ?>
            <div class="car-card">
                <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
                <h3><?php echo $name; ?></h3>
                <ul>
                    <li>Price: <strong><?php echo $price; ?></strong></li>
                    <li>Mileage: <?php echo $mileage; ?></li>
                    <li>Color: <?php echo $color; ?></li>
                </ul>
                <a href="#" class="view-details">View Details</a>
                <span><?php echo $tag; ?></span>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>