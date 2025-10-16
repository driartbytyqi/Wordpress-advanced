<?php get_header(); ?>

<div class="hero">
    <div class="container">
        <h1>Our Inventory</h1>
        <p>Browse our selection of quality vehicles</p>
    </div>
</div>

<main class="container">
     Enhanced filters with AJAX support 
    <div class="car-filters">
        <form id="car-filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="make">Make</label>
                    <select name="make" id="make">
                        <option value="">All Makes</option>
                        <?php
                        $makes = get_terms(array('taxonomy' => 'car_make', 'hide_empty' => true));
                        foreach ($makes as $make) {
                            echo '<option value="' . esc_attr($make->slug) . '">' . esc_html($make->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select name="type" id="type">
                        <option value="">All Types</option>
                        <?php
                        $types = get_terms(array('taxonomy' => 'car_type', 'hide_empty' => true));
                        foreach ($types as $type) {
                            echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="condition">Condition</label>
                    <select name="condition" id="condition">
                        <option value="">All Conditions</option>
                        <?php
                        $conditions = get_terms(array('taxonomy' => 'car_condition', 'hide_empty' => true));
                        foreach ($conditions as $condition) {
                            echo '<option value="' . esc_attr($condition->slug) . '">' . esc_html($condition->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="min_price">Min Price</label>
                    <input type="number" name="min_price" id="min_price" placeholder="$0">
                </div>
                
                <div class="filter-group">
                    <label for="max_price">Max Price</label>
                    <input type="number" name="max_price" id="max_price" placeholder="Any">
                </div>
                
                <div class="filter-group">
                    <label for="min_year">Min Year</label>
                    <input type="number" name="min_year" id="min_year" placeholder="Any">
                </div>
                
                <div class="filter-group">
                    <label for="max_mileage">Max Mileage</label>
                    <input type="number" name="max_mileage" id="max_mileage" placeholder="Any">
                </div>
                
                <div class="filter-group">
                    <label for="orderby">Sort By</label>
                    <select name="orderby" id="orderby">
                        <option value="">Default</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="year_new">Year: Newest First</option>
                        <option value="mileage_low">Mileage: Low to High</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn">Apply Filters</button>
                <button type="button" id="reset-filters" class="btn btn-secondary">Reset</button>
            </div>
        </form>
        
        <div id="results-count" style="margin-top: 1rem; font-weight: 600;"></div>
    </div>

     Comparison bar 
    <div id="comparison-bar" class="comparison-bar" style="display: none;">
        <div class="container">
            <div class="comparison-content">
                <span id="comparison-count">0 cars selected</span>
                <button id="compare-cars-btn" class="btn btn-small">Compare</button>
                <button id="clear-comparison" class="btn-link">Clear</button>
            </div>
        </div>
    </div>

     Loading indicator 
    <div id="loading-indicator" style="display: none; text-align: center; padding: 2rem;">
        <div class="spinner"></div>
        <p>Loading vehicles...</p>
    </div>

    <div id="car-results" class="car-grid">
        <?php
        $car_query = new WP_Query(array(
            'post_type' => 'car',
            'posts_per_page' => 12,
        ));
        
        if ($car_query->have_posts()) :
            while ($car_query->have_posts()) : $car_query->the_post();
                get_template_part('template-parts/car', 'card');
            endwhile;
        else :
            echo '<p>No cars found.</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div>
</main>

 Comparison modal 
<div id="comparison-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Compare Vehicles</h2>
        <div id="comparison-table"></div>
    </div>
</div>

<?php get_footer(); ?>
