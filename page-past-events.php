<?php get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            Past Events
        </h1>
        <div class="page-banner__intro">
            <p>See what is going on in our world.</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php

    $pastEvents = new WP_Query(
        array(
            'paged' => get_query_var('paged', 1),
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '<',
                    'value' => date('Ymd'),  // Today's date or greater
                    'type' => 'DATE',
                ),
            ),
        )
    );

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post();
        ?>

        <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
                <span class="event-summary__month">
                    <?php $eventDate = new DateTime(get_field('event_date'));
                    echo $eventDate->format('M');
                    ?>
                </span>
                <span class="event-summary__day">
                    <?php echo $eventDate->format('d'); ?>
                </span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a></h5>
                <p>
                    <?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>"
                        class="nu gray">Read more</a>
                </p>
            </div>
        </div>

        <!-- <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a></h2>

            <div class="metabox">
                <p>Posted by
                    <?php the_author_posts_link(); ?> on
                    <?php the_time('n.j.y'); ?> in
                    <?php echo get_the_category_list(', ') ?>.
                </p>
            </div>

            <div class="generic-content">
                <?php the_excerpt(); ?>
            </div>

            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
        </div> -->

    <?php } ?>

    <?php echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
    )); ?>

</div>

<?php get_footer(); ?>