<?php get_header(); ?>

<?php the_post(); 

pageBanner();

?>

<div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php echo site_url('events'); ?>"><i class="fa fa-home"
                    aria-hidden="true"></i> Events home
            </a> <span class="metabox__main">
                <?php the_title(); ?>
            </span>
        </p>
    </div>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>

    <?php
    $relatedProgram = get_field('related_programs');

    if ($relatedProgram) {

        echo '<hr class="section-break">';

        echo '<h2 class="headline headline--medium">Related Program(s)</h2>';

        echo '<ul class="link-list min-list">';

        foreach ($relatedProgram as $program) { ?>

            <li><a href="<?php echo get_the_permalink($program); ?>">
                    <?php echo get_the_title($program); ?>
                </a></li>

            <?php
        }
        echo '</ul>';
    }
    ?>

</div>



<?php get_footer(); ?>