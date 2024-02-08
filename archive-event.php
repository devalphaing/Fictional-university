<?php get_header(); 

    pageBanner(array(
        'title' => 'All Events',
        'subtitle' => 'See what is going on in our world.'
    ))

?>

<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post();
       
        get_template_part( '/template-parts/event-excerpt');
       } ?>

    <?php echo paginate_links(); ?>

    <hr class="section-break">
    <div><a href="<?php echo site_url('past-events') ?>" >Click here</a> to see all past Events</div>

</div>

<?php get_footer(); ?>