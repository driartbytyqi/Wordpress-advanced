<?php
/**
 * Auto Dealership Theme Functions
 */

// Theme Setup
function auto_dealership_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'auto-dealership'),
    ));
    
    // Set thumbnail sizes
    add_image_size('car-thumbnail', 400, 300, true);
    add_image_size('car-large', 800, 600, true);
}
add_action('after_setup_theme', 'auto_dealership_setup');

// Register Custom Post Type: Cars
function auto_dealership_register_car_post_type() {
    $labels = array(
        'name'               => 'Cars',
        'singular_name'      => 'Car',
        'menu_name'          => 'Cars',
        'add_new'            => 'Add New Car',
        'add_new_item'       => 'Add New Car',
        'edit_item'          => 'Edit Car',
        'new_item'           => 'New Car',
        'view_item'          => 'View Car',
        'search_items'       => 'Search Cars',
        'not_found'          => 'No cars found',
        'not_found_in_trash' => 'No cars found in trash'
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'cars'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-car',
        'supports'            => array('title', 'editor', 'thumbnail'),
    );
    
    register_post_type('car', $args);
}
add_action('init', 'auto_dealership_register_car_post_type');

// Register Taxonomies
function auto_dealership_register_taxonomies() {
    // Car Make
    register_taxonomy('car_make', 'car', array(
        'label'        => 'Make',
        'rewrite'      => array('slug' => 'make'),
        'hierarchical' => true,
    ));
    
    // Car Type
    register_taxonomy('car_type', 'car', array(
        'label'        => 'Type',
        'rewrite'      => array('slug' => 'type'),
        'hierarchical' => true,
    ));
    
    // Condition
    register_taxonomy('car_condition', 'car', array(
        'label'        => 'Condition',
        'rewrite'      => array('slug' => 'condition'),
        'hierarchical' => true,
    ));
}
add_action('init', 'auto_dealership_register_taxonomies');

// Add Meta Boxes for Car Details
function auto_dealership_add_car_meta_boxes() {
    add_meta_box(
        'car_details',
        'Car Details',
        'auto_dealership_car_details_callback',
        'car',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'auto_dealership_add_car_meta_boxes');

// Meta Box Callback
function auto_dealership_car_details_callback($post) {
    wp_nonce_field('auto_dealership_save_car_details', 'auto_dealership_car_details_nonce');
    
    $price = get_post_meta($post->ID, '_car_price', true);
    $year = get_post_meta($post->ID, '_car_year', true);
    $mileage = get_post_meta($post->ID, '_car_mileage', true);
    $transmission = get_post_meta($post->ID, '_car_transmission', true);
    $fuel_type = get_post_meta($post->ID, '_car_fuel_type', true);
    $engine = get_post_meta($post->ID, '_car_engine', true);
    $color = get_post_meta($post->ID, '_car_color', true);
    $vin = get_post_meta($post->ID, '_car_vin', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="car_price">Price ($)</label></th>
            <td><input type="number" id="car_price" name="car_price" value="<?php echo esc_attr($price); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="car_year">Year</label></th>
            <td><input type="number" id="car_year" name="car_year" value="<?php echo esc_attr($year); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="car_mileage">Mileage</label></th>
            <td><input type="number" id="car_mileage" name="car_mileage" value="<?php echo esc_attr($mileage); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="car_transmission">Transmission</label></th>
            <td>
                <select id="car_transmission" name="car_transmission">
                    <option value="Automatic" <?php selected($transmission, 'Automatic'); ?>>Automatic</option>
                    <option value="Manual" <?php selected($transmission, 'Manual'); ?>>Manual</option>
                    <option value="CVT" <?php selected($transmission, 'CVT'); ?>>CVT</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="car_fuel_type">Fuel Type</label></th>
            <td>
                <select id="car_fuel_type" name="car_fuel_type">
                    <option value="Gasoline" <?php selected($fuel_type, 'Gasoline'); ?>>Gasoline</option>
                    <option value="Diesel" <?php selected($fuel_type, 'Diesel'); ?>>Diesel</option>
                    <option value="Electric" <?php selected($fuel_type, 'Electric'); ?>>Electric</option>
                    <option value="Hybrid" <?php selected($fuel_type, 'Hybrid'); ?>>Hybrid</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="car_engine">Engine</label></th>
            <td><input type="text" id="car_engine" name="car_engine" value="<?php echo esc_attr($engine); ?>" class="regular-text" placeholder="e.g., 2.0L Turbo" /></td>
        </tr>
        <tr>
            <th><label for="car_color">Color</label></th>
            <td><input type="text" id="car_color" name="car_color" value="<?php echo esc_attr($color); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="car_vin">VIN</label></th>
            <td><input type="text" id="car_vin" name="car_vin" value="<?php echo esc_attr($vin); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php
}

// Save Meta Box Data
function auto_dealership_save_car_details($post_id) {
    if (!isset($_POST['auto_dealership_car_details_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['auto_dealership_car_details_nonce'], 'auto_dealership_save_car_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('car_price', 'car_year', 'car_mileage', 'car_transmission', 'car_fuel_type', 'car_engine', 'car_color', 'car_vin');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'auto_dealership_save_car_details');

// Handle Inquiry Form Submission
function auto_dealership_handle_inquiry() {
    if (isset($_POST['car_inquiry_submit'])) {
        $car_id = intval($_POST['car_id']);
        $name = sanitize_text_field($_POST['inquiry_name']);
        $email = sanitize_email($_POST['inquiry_email']);
        $phone = sanitize_text_field($_POST['inquiry_phone']);
        $message = sanitize_textarea_field($_POST['inquiry_message']);
        
        $car_title = get_the_title($car_id);
        $admin_email = get_option('admin_email');
        
        $subject = "New Car Inquiry: " . $car_title;
        $body = "New inquiry received:\n\n";
        $body .= "Car: " . $car_title . "\n";
        $body .= "Name: " . $name . "\n";
        $body .= "Email: " . $email . "\n";
        $body .= "Phone: " . $phone . "\n";
        $body .= "Message: " . $message . "\n";
        
        wp_mail($admin_email, $subject, $body);
        
        wp_redirect(add_query_arg('inquiry', 'success', get_permalink($car_id)));
        exit;
    }
}
add_action('template_redirect', 'auto_dealership_handle_inquiry');

// Helper function to format price
function auto_dealership_format_price($price) {
    return '$' . number_format($price);
}

// Helper function to format mileage
function auto_dealership_format_mileage($mileage) {
    return number_format($mileage) . ' mi';
}

function auto_dealership_widgets_init() {
    register_sidebar(array(
        'name'          => 'Homepage Featured',
        'id'            => 'homepage-featured',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'auto_dealership_widgets_init');

function auto_dealership_enqueue_scripts() {
    wp_enqueue_style('auto-dealership-style', get_stylesheet_uri());
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
    // Enqueue custom scripts
    wp_enqueue_script('auto-dealership-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
    
    // Localize script for AJAX
    wp_localize_script('auto-dealership-main', 'autoDealership', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('auto_dealership_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'auto_dealership_enqueue_scripts');

function auto_dealership_ajax_filter_cars() {
    check_ajax_referer('auto_dealership_nonce', 'nonce');
    
    $args = array(
        'post_type' => 'car',
        'posts_per_page' => 12,
        'paged' => isset($_POST['page']) ? intval($_POST['page']) : 1,
    );
    
    $tax_query = array();
    
    if (!empty($_POST['make'])) {
        $tax_query[] = array(
            'taxonomy' => 'car_make',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['make']),
        );
    }
    
    if (!empty($_POST['type'])) {
        $tax_query[] = array(
            'taxonomy' => 'car_type',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['type']),
        );
    }
    
    if (!empty($_POST['condition'])) {
        $tax_query[] = array(
            'taxonomy' => 'car_condition',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['condition']),
        );
    }
    
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    
    $meta_query = array();
    
    if (!empty($_POST['min_price'])) {
        $meta_query[] = array(
            'key' => '_car_price',
            'value' => intval($_POST['min_price']),
            'compare' => '>=',
            'type' => 'NUMERIC',
        );
    }
    
    if (!empty($_POST['max_price'])) {
        $meta_query[] = array(
            'key' => '_car_price',
            'value' => intval($_POST['max_price']),
            'compare' => '<=',
            'type' => 'NUMERIC',
        );
    }
    
    if (!empty($_POST['min_year'])) {
        $meta_query[] = array(
            'key' => '_car_year',
            'value' => intval($_POST['min_year']),
            'compare' => '>=',
            'type' => 'NUMERIC',
        );
    }
    
    if (!empty($_POST['max_mileage'])) {
        $meta_query[] = array(
            'key' => '_car_mileage',
            'value' => intval($_POST['max_mileage']),
            'compare' => '<=',
            'type' => 'NUMERIC',
        );
    }
    
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }
    
    // Sorting
    if (!empty($_POST['orderby'])) {
        switch ($_POST['orderby']) {
            case 'price_low':
                $args['meta_key'] = '_car_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
            case 'price_high':
                $args['meta_key'] = '_car_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'year_new':
                $args['meta_key'] = '_car_year';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'mileage_low':
                $args['meta_key'] = '_car_mileage';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
        }
    }
    
    $car_query = new WP_Query($args);
    
    ob_start();
    
    if ($car_query->have_posts()) {
        while ($car_query->have_posts()) {
            $car_query->the_post();
            get_template_part('template-parts/car', 'card');
        }
    } else {
        echo '<p class="no-results">No cars found matching your criteria.</p>';
    }
    
    $html = ob_get_clean();
    
    wp_send_json_success(array(
        'html' => $html,
        'found' => $car_query->found_posts,
        'max_pages' => $car_query->max_num_pages
    ));
    
    wp_reset_postdata();
}
add_action('wp_ajax_filter_cars', 'auto_dealership_ajax_filter_cars');
add_action('wp_ajax_nopriv_filter_cars', 'auto_dealership_ajax_filter_cars');

function auto_dealership_add_comparison_meta_box() {
    add_meta_box(
        'car_features',
        'Car Features',
        'auto_dealership_car_features_callback',
        'car',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'auto_dealership_add_comparison_meta_box');

function auto_dealership_car_features_callback($post) {
    $features = get_post_meta($post->ID, '_car_features', true);
    ?>
    <p>Enter one feature per line:</p>
    <textarea name="car_features" rows="10" style="width: 100%;"><?php echo esc_textarea($features); ?></textarea>
    <?php
}

function auto_dealership_save_car_features($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['car_features'])) {
        update_post_meta($post_id, '_car_features', sanitize_textarea_field($_POST['car_features']));
    }
}
add_action('save_post_car', 'auto_dealership_save_car_features');

function auto_dealership_ajax_get_car_comparison() {
    check_ajax_referer('auto_dealership_nonce', 'nonce');
    
    $car_ids = isset($_POST['car_ids']) ? array_map('intval', $_POST['car_ids']) : array();
    
    if (empty($car_ids)) {
        wp_send_json_error('No cars selected');
    }
    
    $comparison_data = array();
    
    foreach ($car_ids as $car_id) {
        $car = get_post($car_id);
        if (!$car) continue;
        
        $comparison_data[] = array(
            'id' => $car_id,
            'title' => get_the_title($car_id),
            'image' => get_the_post_thumbnail_url($car_id, 'car-thumbnail'),
            'price' => get_post_meta($car_id, '_car_price', true),
            'year' => get_post_meta($car_id, '_car_year', true),
            'mileage' => get_post_meta($car_id, '_car_mileage', true),
            'transmission' => get_post_meta($car_id, '_car_transmission', true),
            'fuel_type' => get_post_meta($car_id, '_car_fuel_type', true),
            'engine' => get_post_meta($car_id, '_car_engine', true),
            'color' => get_post_meta($car_id, '_car_color', true),
            'features' => get_post_meta($car_id, '_car_features', true),
            'permalink' => get_permalink($car_id)
        );
    }
    
    wp_send_json_success($comparison_data);
}
add_action('wp_ajax_get_car_comparison', 'auto_dealership_ajax_get_car_comparison');
add_action('wp_ajax_nopriv_get_car_comparison', 'auto_dealership_ajax_get_car_comparison');

function auto_dealership_add_gallery_meta_box() {
    add_meta_box(
        'car_gallery',
        'Car Gallery',
        'auto_dealership_car_gallery_callback',
        'car',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'auto_dealership_add_gallery_meta_box');

function auto_dealership_car_gallery_callback($post) {
    $gallery_ids = get_post_meta($post->ID, '_car_gallery', true);
    ?>
    <div id="car-gallery-container">
        <input type="hidden" id="car_gallery" name="car_gallery" value="<?php echo esc_attr($gallery_ids); ?>">
        <button type="button" class="button" id="add-gallery-images">Add Images</button>
        <div id="gallery-preview" style="margin-top: 10px;">
            <?php
            if ($gallery_ids) {
                $ids = explode(',', $gallery_ids);
                foreach ($ids as $id) {
                    echo wp_get_attachment_image($id, 'thumbnail', false, array('style' => 'margin: 5px;'));
                }
            }
            ?>
        </div>
    </div>
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            if (frame) {
                frame.open();
                return;
            }
            frame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to gallery' },
                multiple: true
            });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var preview = '';
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    preview += '<img src="' + attachment.sizes.thumbnail.url + '" style="margin: 5px;">';
                });
                $('#car_gallery').val(ids.join(','));
                $('#gallery-preview').html(preview);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

function auto_dealership_save_car_gallery($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['car_gallery'])) {
        update_post_meta($post_id, '_car_gallery', sanitize_text_field($_POST['car_gallery']));
    }
}
add_action('save_post_car', 'auto_dealership_save_car_gallery');

function auto_dealership_enqueue_admin_scripts() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'auto_dealership_enqueue_admin_scripts');

function auto_dealership_add_featured_meta_box() {
    add_meta_box(
        'car_featured',
        'Featured',
        'auto_dealership_car_featured_callback',
        'car',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'auto_dealership_add_featured_meta_box');

function auto_dealership_car_featured_callback($post) {
    $featured = get_post_meta($post->ID, '_car_featured', true);
    ?>
    <label>
        <input type="checkbox" name="car_featured" value="1" <?php checked($featured, '1'); ?>>
        Mark as Featured
    </label>
    <?php
}

function auto_dealership_save_car_featured($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $featured = isset($_POST['car_featured']) ? '1' : '0';
    update_post_meta($post_id, '_car_featured', $featured);
}
add_action('save_post_car', 'auto_dealership_save_car_featured');

?>
