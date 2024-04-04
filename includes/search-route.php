<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route(
        'university/v1',
        'search',
        array(
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => 'universitySearchResults'
        )
    );
}

function universitySearchResults($req)
{
    $mainQuery = new WP_Query(
        array(
            'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
            's' => sanitize_text_field($req['term']),
            'posts_per_page' => -1
        )
    );

    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push(
                $results['generalInfo'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'author' => get_the_author(),
                    'postType' => get_post_type()
                )
            );
        } else if (get_post_type() == 'professor') {
            array_push(
                $results['professors'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'thumbnail' => get_the_post_thumbnail_url(0, 'professorLandscape')
                )
            );
        } else if (get_post_type() == 'program') {
            array_push(
                $results['programs'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        } else if (get_post_type() == 'campus') {
            array_push(
                $results['campuses'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        } else if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 8);
            }
            array_push(
                $results['events'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'excerpt' => $description
                )
            );
        }
    }

    if($results['programs']){
        $programMetaQuery = array('relation' => 'OR');
    
        foreach ($results['programs'] as $item) {
            array_push(
                $programMetaQuery,
                array(
                    'key' => 'related_programs',
                    'compare' => 'Like',
                    'value' => '"' . $item['id'] . '"'
                )
            );
        }
    
        $programRelationshipQuery = new WP_Query(
            array(
                'post_type' => array('professor', 'event'),
                'meta_query' => $programMetaQuery
            )
        );
    
        while ($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();

            if (get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                $description = null;
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 8);
                }
                array_push(
                    $results['events'],
                    array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'month' => $eventDate->format('M'),
                        'day' => $eventDate->format('d'),
                        'excerpt' => $description
                    )
                );
            }
    
            if (get_post_type() == 'professor') {
                array_push(
                    $results['professors'],
                    array(
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'thumbnail' => get_the_post_thumbnail_url(0, 'professorLandscape')
                    )
                );
            }
        }
    
        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }


    return $results;
}