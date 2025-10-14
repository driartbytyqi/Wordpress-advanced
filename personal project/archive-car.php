
<?php
get_header();
?>
<div class="dealership-section" style="max-width:900px;margin:auto;padding:2rem;">
    <h1>All Cars</h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:2rem;">
        <?php if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <div class="car-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                    </a>
                    <p><strong>Price:</strong> <?php echo get_post_meta(get_the_ID(), 'price', true); ?></p>
                    <p><strong>Mileage:</strong> <?php echo get_post_meta(get_the_ID(), 'mileage', true); ?></p>
                    <p><strong>Color:</strong> <?php echo get_post_meta(get_the_ID(), 'color', true); ?></p>
                </div>
            <?php endwhile;
        else : ?>
            <p>No cars found.</p>
        <?php endif; ?>
    </div>
</div>
<?php
get_footer();
?>