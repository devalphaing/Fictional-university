<?php get_header() ?>

<?php
while (have_posts()) {
    the_post();
    pageBanner();
?>



    <div class="container container--narrow page-section">
        <?php
        $theParent = wp_get_post_parent_id(get_the_ID());
        if ($theParent) {
            $parent_title = get_the_title($post->post_parent);
            ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($post->post_parent) ?>"><i
                            class="fa fa-home" aria-hidden="true"></i> Back to
                        <?php echo $parent_title; ?>
                    </a> <span class="metabox__main">
                        <?php echo the_title(); ?>
                    </span>
                </p>
            </div>
        <?php } ?>

        <?php
        $childArray = get_pages(
            array(
                'child_of' => get_the_ID()
            )
        );

        if ($theParent or $childArray) {
            ?>
            <div class="page-links">
                <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>">
                        <?php echo get_the_title($theParent) ?>
                    </a></h2>
                <ul class="min-list">
                    <?php

                    if ($theParent) {
                        $findChildrenOf = $theParent;
                    } else {
                        $findChildrenOf = get_the_ID();
                    }

                    wp_list_pages(
                        array(
                            'title_li' => NULL,
                            'child_of' => $findChildrenOf,
                            'sort_cloumn' => 'menu_order'
                        )
                    );

                    ?>
                </ul>
            </div>
        <?php } ?>



        <div class="generic-content">
            <?php echo the_content(); ?>
        </div>

    </div>

    <?php
}
get_footer() ?>