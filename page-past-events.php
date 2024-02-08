<?php get_header();

pageBanner(
    array(
        'title' => 'Past Events',
        'subtitle' => 'See what is going on in our world.'
    )
)

    ?>

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

        get_template_part('template-parts/event-excerpt');

        echo paginate_links(
            array(
                'total' => $pastEvents->max_num_pages
            )
        );
    }
?>

</div>

<?php get_footer(); ?>