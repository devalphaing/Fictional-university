<?php get_header(); ?>

<?php the_post(); 

pageBanner();

?>

<div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php echo site_url('programs'); ?>"><i class="fa fa-home"
                    aria-hidden="true"></i> All Programs
            </a> <span class="metabox__main">
                <?php the_title(); ?>
            </span>
        </p>
    </div>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>

    <?php

    $relatedProfessors = new WP_Query(
        array(
            'posts_per_page' => -1,
            'post_type' => 'professor',          // Specify the custom post type
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                )
            ),

        )
    );

    if ($relatedProfessors->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Professors</h2>';



        echo '<ul class="professor-cards">'; 
        while ($relatedProfessors->have_posts()) {
            $relatedProfessors->the_post();
            ?>

            <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                    <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
                    <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
            </li>

        <?php }
        echo '</ul>';
        wp_reset_postdata();
    }


    $homePageEvents = new WP_Query(
        array(
            'post_type' => 'event',          // Specify the custom post type
            'posts_per_page' => -1,
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => date('Ymd'),  // Today's date or greater
                    'type' => 'DATE',
                ),
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"'
                )
            ),

        )
    );

    if ($homePageEvents->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' events</h2>';



        while ($homePageEvents->have_posts()) {
            $homePageEvents->the_post();
            get_template_part('template-parts/event-excerpt');
        }
        wp_reset_postdata();
    } ?>

</div>

<?php get_footer(); ?>