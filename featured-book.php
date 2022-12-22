<?php 
/*
** Template Name: Fetured Book
*/
get_header()
?>

<!-- s-content
================================================== -->
<section class="s-content">
    <h1 class="text-center">
        <?php _e("Featured Book","philosophy"); ?>
    </h1>

    <div class="row masonry-wrap">
        <div class="masonry">
            <div class="grid-sizer"></div>

            <?php
            $paged = get_query_var('paged')? get_query_var('paged'): 1;
            $posts_per_page = 3;
            $philo_books = new WP_Query(array(
                'post_type' => 'book',
                // 'meta_key' => 'is_featured',
                // 'meta_value' => true,
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
            ));
            while($philo_books->have_posts()){
                $philo_books->the_post();
                get_template_part("template-parts/post-formats/featuredbook");
            }
            wp_reset_query();
            ?>

        </div> <!-- end masonry -->
    </div> <!-- end masonry-wrap -->

    <div class="row">
        <div class="col-full">
    <nav class="pgn">
        <?php
            echo paginate_links(array(
                'prev_next' => false,
                'current' => $paged,
                'total' => $philo_books->max_num_pages,
            ));
        ?>
    </nav>
        </div>
    </div>
    <?php //echo apply_filters("philo_dparam","poltu ka","ma"); ?>


</section> <!-- s-content -->


<?php get_footer(); ?>