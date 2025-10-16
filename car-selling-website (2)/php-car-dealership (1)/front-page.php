<?php
/**
 * Homepage Template
 */
get_header();
?>

<div class="hero-home">
    <div class="container">
        <h1 class="hero-title">Find Your Perfect Vehicle</h1>
        <p class="hero-subtitle">Quality cars at unbeatable prices</p>
        
         Quick search 
        <div class="hero-search">
            <form action="<?php echo esc_url(get_post_type_archive_link('car')); ?>" method="get">
                <div class="search-grid">
                    <select name="make">
                        <option value="">Select Make</option>
                        <?php
                        $makes = get_terms(array('taxonomy' => 'car_make', 'hide_empty' => true));
                        foreach ($makes as $make) {
                            echo '<option value="' . esc_attr($make->slug) . '">' . esc_html($make->name) . '</option>';
                        }
                        ?>
                    </select>
                    <select name="type">
                        <option value="">Select Type</option>
                        <?php
                        $types = get_terms(array('taxonomy' => 'car_type', 'hide_empty' => true));
                        foreach ($types as $type) {
                            echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                        }
                        ?>
                    </select>
                    <input type="number" name="max_price" placeholder="Max Price">
                    <button type="submit" class="btn">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<main class="container">
     Featured Cars 
    <section class="featured-section">
        <h2 class="section-title">Featured Vehicles</h2>
        <div class="car-grid">
            <?php
            $featured_query = new WP_Query(array(
                'post_type' => 'car',
                'posts_per_page' => 6,
                'meta_key' => '_car_featured',
                'meta_value' => '1',
            ));
            
            if ($featured_query->have_posts()) :
                while ($featured_query->have_posts()) : $featured_query->the_post();
                    get_template_part('template-parts/car', 'card');
                endwhile;
            else :
                // Show latest cars if no featured
                $latest_query = new WP_Query(array(
                    'post_type' => 'car',
                    'posts_per_page' => 6,
                ));
                while ($latest_query->have_posts()) : $latest_query->the_post();
                    get_template_part('template-parts/car', 'card');
                endwhile;
                wp_reset_postdata();
            endif;
            wp_reset_postdata();
            ?>
        </div>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?php echo esc_url(get_post_type_archive_link('car')); ?>" class="btn">View All Inventory</a>
        </div>
    </section>
    
     Why Choose Us 
    <section class="features-section">
        <h2 class="section-title">Why Choose Us</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Quality Vehicles</h3>
                <p>Every vehicle is thoroughly inspected and certified</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Best Prices</h3>
                <p>Competitive pricing and flexible financing options</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3>Expert Service</h3>
                <p>Knowledgeable staff ready to help you find the perfect car</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✅</div>
                <h3>Warranty Included</h3>
                <p>Peace of mind with comprehensive warranty coverage</p>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
