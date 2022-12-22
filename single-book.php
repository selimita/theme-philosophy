<?php
the_post();
get_header();
?>
<!-- s-content
================================================== -->
<section class="s-content s-content--narrow s-content--no-padding-bottom">
    <article class="row format-standard">

        <div class="s-content__header col-full">
            <h1 class="s-content__header-title">
                <?php the_title() ?>
            </h1>
            <ul class="s-content__header-meta">
                <li class="date"><?php the_date() ?></li>
                <li class="cat">
                    In
                    <?php the_category( " " ); ?>
                </li>
                <?php comments_number(); ?>
                
            </ul>
        </div> <!-- end s-content__header -->

        <div class="s-content__media col-full">
            <div class="s-content__post-thumb">
                <?php the_post_thumbnail( "large" ); ?>
            </div>
        </div> <!-- end s-content__media -->

        <div class="col-full s-content__main">

            <?php
            do_action("philosophy_action_hook");
            the_content();
            wp_link_pages( ); // MUST ADD
            ?>

            <?php if(class_exists('ACF')): ?>
            <div class="chapter-order">
                <?php 
                $philo_chapter_args = array(
                    'post_type' => 'chapter',
                    'posts_per_page' => -1,
                    'meta_key' => 'parent_book',
                    'meta_value' => get_the_ID(),
                );
                $philo_chapters = new WP_Query($philo_chapter_args);
                if($philo_chapters->have_posts()):
                echo "<h3>";
                _e('All Chapters','philosophy');
                echo "</h3>";
                while($philo_chapters->have_posts()){
                    $philo_chapters->the_post();
                    $philo_cp = get_the_permalink();
                    $philo_ct = get_the_title();
                    if($philo_cp && $philo_ct){
                        printf("<a href='%s'>%s</a><br />",$philo_cp,$philo_ct);
                    }
                }
                wp_reset_query();
                endif;
                ?>
            </div>
            <?php endif; ?>

            <?php if(class_exists('CMB2')): ?>
            <div class="chapter-otder-cmb2">
                <?php 
                $philo_cmb2_chapters = get_post_meta( get_the_ID(), 'attached_cmb2_attached_posts', true );
                if($philo_cmb2_chapters){
                    echo "<h3>";
                    _e('All Chapters CMB2','philosophy');
                    echo "</h3>";
                    foreach($philo_cmb2_chapters as $pch){
                    $philo_chl = get_the_permalink($pch);
                    $philo_cht = get_the_title($pch);
                        printf("<a href='%s'>%s</a><br/>",$philo_chl,$philo_cht);
                    }
                }
                ?>
            </div>
            <?php endif; ?>
            
            <p class="s-content__tags">
    <span><?php _e("Language","philosophy"); ?></span>

    <span class="s-content__tag-list">
        <?php
        the_terms( get_the_ID(), "language", "", "", "" );
        ?>
    </span>
            </p> <!-- end s-content__tags -->
            <p class="s-content__tags">
                <span>Post Tags</span>

                <span class="s-content__tag-list">
                    <?php
                    the_tags( "", "", "" );
                    ?>
                </span>
            </p> <!-- end s-content__tags -->

            <div class="s-content__author">
                <?php echo get_avatar( get_the_author_meta( "ID" ) ); ?>

                <div class="s-content__author-about">
                    <h4 class="s-content__author-name">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ); ?>">
                            <?php the_author(); ?>
                        </a>
                    </h4>

                    <p>
                        <?php the_author_meta( "description" ); ?>
                    </p>
                    <?php if(function_exists("the_field")): ?>
                        
                    <?php endif; ?>
                    <ul class="s-content__author-social">
                    <?php
                    $philosophy_author_facebook  = get_field( "facebook", "user_" . get_the_author_meta( "ID" ) );
                    $philosophy_author_twitter   = get_field( "twitter", "user_" . get_the_author_meta( "ID" ) );
                    $philosophy_author_instagram = get_field( "instagram", "user_" . get_the_author_meta( "ID" ) );
                    ?>
                    <?php if ( $philosophy_author_facebook ): ?>
                        <li><a href="<?php echo esc_url( $philosophy_author_facebook ); ?>">Facebook</a></li>
                    <?php endif; ?>
                    <?php if ( $philosophy_author_twitter ): ?> 
                        <li><a href="<?php echo esc_url( $philosophy_author_twitter ); ?>">Twitter</a></li>
                    <?php endif; ?>
                    <?php if ( $philosophy_author_instagram ): ?>
                        <li><a href="<?php echo esc_url( $philosophy_author_instagram ); ?>">Instagram</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="s-content__pagenav">
                <div class="s-content__nav">
                    <div class="s-content__prev">
                        <?php
                        $philosophy_prev_post = get_previous_post();
                        if ( $philosophy_prev_post ):
                            ?>
                            <a href="<?php echo get_the_permalink( $philosophy_prev_post ); ?>" rel="prev">
                                <span><?php _e( "Previous Post", "philosophy" ); ?></span>
                                <?php echo get_the_title( $philosophy_prev_post ); ?>
                            </a>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div class="s-content__next">
                        <?php
                        $philosophy_next_post = get_next_post();
                        if ( $philosophy_next_post ):
                            ?>
                            <a href="<?php echo get_the_permalink( $philosophy_next_post ); ?>" rel="next">
                                <span><?php _e( "Next Post", "philosophy" ); ?></span>
                                <?php echo get_the_title( $philosophy_next_post ); ?>
                            </a>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div> <!-- end s-content__pagenav -->
        </div> <!-- end s-content__main -->
    </article>
    <!-- comments
    ================================================== -->
    <?php
    if(!post_password_required()){
        comments_template();
    }
    ?>
</section> <!-- s-content -->
<?php get_footer(); ?>