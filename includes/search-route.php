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
                    'permalink' => get_the_permalink()
                )
            );
        }else if(get_post_type() == 'professor'){
            array_push(
                $results['professors'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        }else if(get_post_type() == 'program'){
            array_push(
                $results['programs'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        }else if(get_post_type() == 'campus'){
            array_push(
                $results['campuses'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        }else if(get_post_type() == 'event'){
            array_push(
                $results['events'],
                array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        }


    }

    return $results;
}