
<?php
/*
Template Name: Submit a Car
*/

get_header();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_submit_nonce']) && wp_verify_nonce($_POST['car_submit_nonce'], 'car_submit_action')) {
    $title = sanitize_text_field($_POST['car_title']);
    $price = sanitize_text_field($_POST['car_price']);
    $mileage = sanitize_text_field($_POST['car_mileage']);
    $color = sanitize_text_field($_POST['car_color']);

    $car_id = wp_insert_post([
        'post_type' => 'car',
        'post_title' => $title,
        'post_status' => 'pending', // or 'publish' if you want it live immediately
        'post_content' => '',
    ]);

    if ($car_id && !is_wp_error($car_id)) {
        update_post_meta($car_id, 'price', $price);
        update_post_meta($car_id, 'mileage', $mileage);
        update_post_meta($car_id, 'color', $color);
        echo '<div style="background:#dff0d8;padding:1rem;border-radius:8px;margin-bottom:2rem;">Car submitted successfully! Awaiting approval.</div>';
    } else {
        echo '<div style="background:#f2dede;padding:1rem;border-radius:8px;margin-bottom:2rem;">Error submitting car. Please try again.</div>';
    }
}
?>

<div style="max-width:500px;margin:auto;">
    <h2>Submit a Car</h2>
    <form method="post">
        <?php wp_nonce_field('car_submit_action', 'car_submit_nonce'); ?>
        <label>Car Name/Model</label>
        <input type="text" name="car_title" required style="width:100%;margin-bottom:1rem;">
        <label>Price</label>
        <input type="text" name="car_price" required style="width:100%;margin-bottom:1rem;">
        <label>Mileage</label>
        <input type="text" name="car_mileage" required style="width:100%;margin-bottom:1rem;">
        <label>Color</label>
        <input type="text" name="car_color" required style="width:100%;margin-bottom:1rem;">
        <button type="submit" style="background:#4f8cff;color:#fff;padding:0.7rem 2rem;border:none;border-radius:8px;font-size:1.1rem;">Submit Car</button>
    </form>
</div>
<li><a href="<?php echo site_url('/submit-a-car'); ?>" style="color:#fff;text-decoration:none;font-size:1.15rem;font-weight:500;transition:color 0.2s;">Submit a Car</a></li>
<?php
get_footer();
?>