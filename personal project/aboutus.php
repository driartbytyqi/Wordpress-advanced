<?php

get_header();
?>
<main>
    <div class="card">
        <h1>About Us</h1>
        <?php
      
        $about_query = new WP_Query(array(
            'post_type' => 'about_us',
            'posts_per_page' => 1
        ));
        if ($about_query->have_posts()) {
            while ($about_query->have_posts()) {
                $about_query->the_post();
                echo '<h2>' . get_the_title() . '</h2>';
                echo '<div>' . apply_filters('the_content', get_the_content()) . '</div>';
            }
            wp_reset_postdata();
        } else {
        ?>
        <p>Welcome to Personal Finance Tracker! We are passionate about helping individuals take control of their financial future. Our platform provides easy-to-use tools for tracking expenses, managing crypto portfolios, and setting savings goals.</p>
        <h2>Our Mission</h2>
        <p>To empower everyone to achieve financial wellness through technology, education, and smart insights.</p>
        <h2>Meet the Team</h2>
        <ul>
            <li><strong>Alex Smith</strong> – Founder & CEO</li>
            <li><strong>Jamie Lee</strong> – Lead Developer</li>
            <li><strong>Pat Morgan</strong> – Financial Advisor</li>
        </ul>
        <blockquote style="font-style:italic; color:#4f8cff; border-left:4px solid #4f8cff; padding-left:1rem; margin-top:2rem;">“Empowering your financial journey, one step at a time.”</blockquote>
        <?php } ?>
    </div>
</main>
<?php
get_footer();
?>