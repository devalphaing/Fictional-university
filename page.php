<?php get_header() ?>

<?php the_post(); ?>

<h1>This is from page.php</h1>
<h1><?php the_title() ?></h1>
<p> <?php the_content() ?> </p> 


<?php get_footer() ?>