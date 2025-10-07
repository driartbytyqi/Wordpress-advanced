<?php
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
        <div class="post-meta">
            <span>Posted on <?php the_date(); ?> by <?php the_author(); ?></span>
        </div>
    </div>
</main>
<?php
get_footer();
?>