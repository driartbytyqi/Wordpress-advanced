<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <div class="single-car-header">
        <div class="container">
            <h1 class="single-car-title"><?php the_title(); ?></h1>
            <?php 
            $price = get_post_meta(get_the_ID(), '_car_price', true);
            if ($price) : ?>
                <div class="single-car-price"><?php echo auto_dealership_format_price($price); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <main class="container">
        <div class="single-car-content">
            <div class="car-gallery">
                <?php
                $gallery_ids = get_post_meta(get_the_ID(), '_car_gallery', true);
                if ($gallery_ids) {
                    $ids = explode(',', $gallery_ids);
                    if (!empty($ids)) {
                        echo '<div class="gallery-main">';
                        echo wp_get_attachment_image($ids[0], 'car-large', false, array('class' => 'car-main-image', 'data-index' => '0'));
                        echo '</div>';
                        
                        if (count($ids) > 1) {
                            echo '<div class="gallery-thumbnails">';
                            foreach ($ids as $index => $id) {
                                echo wp_get_attachment_image($id, 'thumbnail', false, array(
                                    'class' => 'gallery-thumb' . ($index === 0 ? ' active' : ''),
                                    'data-index' => $index
                                ));
                            }
                            echo '</div>';
                        }
                    }
                } elseif (has_post_thumbnail()) {
                    echo '<div class="gallery-main">';
                    the_post_thumbnail('car-large', array('class' => 'car-main-image'));
                    echo '</div>';
                }
                ?>
                
                <div class="car-description">
                    <h2>Description</h2>
                    <?php the_content(); ?>
                    
                    <?php
                    $features = get_post_meta(get_the_ID(), '_car_features', true);
                    if ($features) :
                        $features_array = array_filter(explode("\n", $features));
                        if (!empty($features_array)) :
                    ?>
                    <h3>Features</h3>
                    <ul class="car-features-list">
                        <?php foreach ($features_array as $feature) : ?>
                            <li><?php echo esc_html(trim($feature)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                        endif;
                    endif;
                    ?>
                </div>
            </div>

            <aside class="car-details-box">
                <h3>Vehicle Details</h3>
                
                <?php
                $year = get_post_meta(get_the_ID(), '_car_year', true);
                $mileage = get_post_meta(get_the_ID(), '_car_mileage', true);
                $transmission = get_post_meta(get_the_ID(), '_car_transmission', true);
                $fuel_type = get_post_meta(get_the_ID(), '_car_fuel_type', true);
                $engine = get_post_meta(get_the_ID(), '_car_engine', true);
                $color = get_post_meta(get_the_ID(), '_car_color', true);
                $vin = get_post_meta(get_the_ID(), '_car_vin', true);
                
                $makes = get_the_terms(get_the_ID(), 'car_make');
                $types = get_the_terms(get_the_ID(), 'car_type');
                $condition = get_the_terms(get_the_ID(), 'car_condition');
                ?>
                
                <?php if ($year) : ?>
                <div class="detail-row">
                    <span class="detail-label">Year</span>
                    <span class="detail-value"><?php echo esc_html($year); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($makes && !is_wp_error($makes)) : ?>
                <div class="detail-row">
                    <span class="detail-label">Make</span>
                    <span class="detail-value"><?php echo esc_html($makes[0]->name); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($types && !is_wp_error($types)) : ?>
                <div class="detail-row">
                    <span class="detail-label">Type</span>
                    <span class="detail-value"><?php echo esc_html($types[0]->name); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($condition && !is_wp_error($condition)) : ?>
                <div class="detail-row">
                    <span class="detail-label">Condition</span>
                    <span class="detail-value"><?php echo esc_html($condition[0]->name); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($mileage) : ?>
                <div class="detail-row">
                    <span class="detail-label">Mileage</span>
                    <span class="detail-value"><?php echo auto_dealership_format_mileage($mileage); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($transmission) : ?>
                <div class="detail-row">
                    <span class="detail-label">Transmission</span>
                    <span class="detail-value"><?php echo esc_html($transmission); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($fuel_type) : ?>
                <div class="detail-row">
                    <span class="detail-label">Fuel Type</span>
                    <span class="detail-value"><?php echo esc_html($fuel_type); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($engine) : ?>
                <div class="detail-row">
                    <span class="detail-label">Engine</span>
                    <span class="detail-value"><?php echo esc_html($engine); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($color) : ?>
                <div class="detail-row">
                    <span class="detail-label">Color</span>
                    <span class="detail-value"><?php echo esc_html($color); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($vin) : ?>
                <div class="detail-row">
                    <span class="detail-label">VIN</span>
                    <span class="detail-value"><?php echo esc_html($vin); ?></span>
                </div>
                <?php endif; ?>
                
                <button id="show-calculator" class="btn btn-block" style="margin-top: 1rem;">Calculate Financing</button>
                
                <div id="financing-calculator" style="display: none; margin-top: 1rem; padding: 1rem; background: #f9fafb; border-radius: 8px;">
                    <h4>Financing Calculator</h4>
                    <div class="form-group">
                        <label>Down Payment ($)</label>
                        <input type="number" id="down-payment" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label>Interest Rate (%)</label>
                        <input type="number" id="interest-rate" value="5.5" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label>Loan Term (months)</label>
                        <select id="loan-term">
                            <option value="24">24 months</option>
                            <option value="36">36 months</option>
                            <option value="48">48 months</option>
                            <option value="60" selected>60 months</option>
                            <option value="72">72 months</option>
                        </select>
                    </div>
                    <button id="calculate-payment" class="btn btn-small">Calculate</button>
                    <div id="payment-result" style="margin-top: 1rem; display: none;">
                        <div style="font-size: 1.25rem; font-weight: 700; color: #059669;">
                            <span id="monthly-payment"></span>/mo
                        </div>
                        <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                            Total: <span id="total-payment"></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <div class="inquiry-form">
            <h3>Interested in this vehicle?</h3>
            
            <?php if (isset($_GET['inquiry']) && $_GET['inquiry'] == 'success') : ?>
                <div style="background: #10b981; color: white; padding: 1rem; border-radius: 6px; margin-bottom: 1rem;">
                    Thank you! Your inquiry has been sent successfully.
                </div>
            <?php endif; ?>
            
            <form method="post" action="">
                <input type="hidden" name="car_id" value="<?php echo get_the_ID(); ?>">
                
                <div class="form-group">
                    <label for="inquiry_name">Name *</label>
                    <input type="text" id="inquiry_name" name="inquiry_name" required>
                </div>
                
                <div class="form-group">
                    <label for="inquiry_email">Email *</label>
                    <input type="email" id="inquiry_email" name="inquiry_email" required>
                </div>
                
                <div class="form-group">
                    <label for="inquiry_phone">Phone</label>
                    <input type="tel" id="inquiry_phone" name="inquiry_phone">
                </div>
                
                <div class="form-group">
                    <label for="inquiry_message">Message</label>
                    <textarea id="inquiry_message" name="inquiry_message" placeholder="I'm interested in this vehicle..."></textarea>
                </div>
                
                <button type="submit" name="car_inquiry_submit" class="btn">Send Inquiry</button>
            </form>
        </div>
    </main>
<?php endwhile; ?>

<div id="lightbox-modal" class="modal" style="display: none;">
    <span class="modal-close">&times;</span>
    <div class="lightbox-content">
        <button class="lightbox-prev">‹</button>
        <img id="lightbox-image" src="/placeholder.svg" alt="">
        <button class="lightbox-next">›</button>
    </div>
</div>

<?php get_footer(); ?>
