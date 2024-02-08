<?php get_header(); 

pageBanner(array(
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone.'
))

?>

<div class="container container--narrow page-section">

    <ul class="link-list min-list">
        <?php
        while (have_posts()) {
            the_post();
            ?>

            <li><a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a></li>

        <?php } ?>


        <?php echo paginate_links(); ?>
    </ul>

    <!-- <hr class="section-break">
    <div><a href="<?php echo site_url('past-events') ?>">Click here</a> to see all past Events</div> -->

</div>

<?php get_footer(); ?>