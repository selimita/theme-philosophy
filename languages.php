    <?php 
    /*
    ** Template Name: Languages Template
    */

    $philo_query_args = array(
        'post_type' => 'book',
        'posts_per_page' => -1,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'language',
                    'field' => 'slug',
                    'terms' => array("bangla")
                ),
                array(
                    'taxonomy' => 'language',
                    'field' => 'slug',
                    'terms' => array("english"),
                    'operator' => 'NOT IN'
                )
            ),
            array(
                'taxonomy' => 'genre',
                'field' => 'slug',
                'terms' => array("horror")
            )
        )
    );
    $philo_posts = new WP_Query($philo_query_args);
    while($philo_posts-> have_posts()){
        $philo_posts-> the_post();
        the_title();
        echo '<br />';
    }
    wp_reset_query();