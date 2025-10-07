<?php
/* Template Name: Custom Page */
get_header();
?>
<main>
    <div class="card">
        <h1><?php the_title(); ?></h1>
        <div>
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </div>
</main>
<?php
get_footer();
?>