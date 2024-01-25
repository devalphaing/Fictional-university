<?php get_header() ?>

<?php
// Get the current page ID
$current_page_id = get_the_ID();

// Get child pages of the current page
$child_pages = get_pages(
    array(
        'child_of' => $current_page_id,
    )
);

// Loop through child pages
// foreach ($child_pages as $child_page) {
//     $child_page_id = $child_page->ID;
//     $child_page_title = $child_page->post_title;

//     // Output or use the child page ID and title as needed
//     echo "Child Page ID: $child_page_id, Title: $child_page_title<br>";
// }

?>

<?php
while (have_posts()) {
    the_post(); ?>

    <div class="page-banner">
        <div class="page-banner__bg-image"
            style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?php echo the_title(); ?>
            </h1>
            <div class="page-banner__intro">
                <p>Don't forget to replace me later.</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <?php if (wp_get_post_parent_id(get_the_ID())) {
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



        <!-- page_links div just below is my personal login which I found on google. -->
        <div class="page-links">
            <h2 class="page-links__title"><a href="#">
                    <?php the_title() ?>
                </a></h2>
            <ul class="min-list">

                <?php
                foreach ($child_pages as $child_page) {
                    $child_page_id = $child_page->ID;
                    $child_page_title = $child_page->post_title;

                    // Output or use the child page ID and title as needed
                    // echo "Child Page ID: $child_page_id, Title: $child_page_title<br>";                
                    ?>
                    <li><a href="<?php echo get_permalink($child_page_id); ?>">
                            <?php echo $child_page_title; ?>
                        </a></li>
                    <?php
                }
                ?>
                <!-- <li class="current_page_item"><a href="#">Our History</a></li>
                <li><a href="#">Our Goals</a></li> -->

            </ul>
        </div>


        <div class="generic-content">
            <?php echo the_content(); ?>
        </div>
    </div>



    <?php
}
get_footer() ?>