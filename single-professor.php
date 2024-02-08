<?php get_header(); ?>

<?php the_post(); ?>

<?php pageBanner(); ?>

<div class="container container--narrow page-section">
    <div class="generic-content">
        <div class="row group">
            <div class="one-third">
                <?php the_post_thumbnail('professorPotrait'); ?>
            </div>
            <div class="two-third">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    <?php
    $relatedProgram = get_field('related_programs');

    if ($relatedProgram) {

        echo '<hr class="section-break">';

        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';

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