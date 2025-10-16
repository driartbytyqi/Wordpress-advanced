<?php get_header(); ?>

<div class="hero">
    <div class="container">
        <h1>Find Your Dream Car</h1>
        <p>Browse our extensive inventory of quality vehicles</p>
    </div>
</div>

<main class="container">
    <?php if (have_posts()) : ?>
        <div class="car-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article class="car-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('car-thumbnail'); ?>" alt="<?php the_title(); ?>" class="car-image">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/placeholder-car.jpg" alt="<?php the_title(); ?>" class="car-image">
                    <?php endif; ?>
                    
                    <div class="car-content">
                        <h2 class="car-title"><?php the_title(); ?></h2>
                        
                        <?php 
                        $price = get_post_meta(get_the_ID(), '_car_price', true);
                        if ($price) : ?>
                            <div class="car-price"><?php echo auto_dealership_format_price($price); ?></div>
                        <?php endif; ?>
                        
                        <div class="car-specs">
                            <?php 
                            $year = get_post_meta(get_the_ID(), '_car_year', true);
                            $mileage = get_post_meta(get_the_ID(), '_car_mileage', true);
                            $transmission = get_post_meta(get_the_ID(), '_car_transmission', true);
                            ?>
                            <?php if ($year) : ?>
                                <span class="car-spec">📅 <?php echo esc_html($year); ?></span>
                            <?php endif; ?>
                            <?php if ($mileage) : ?>
                                <span class="car-spec">🛣️ <?php echo auto_dealership_format_mileage($mileage); ?></span>
                            <?php endif; ?>
                            <?php if ($transmission) : ?>
                                <span class="car-spec">⚙️ <?php echo esc_html($transmission); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="btn">View Details</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <div class="pagination">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <p>No cars found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
