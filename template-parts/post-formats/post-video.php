    <?php 
    $philo_video = "";
    if(function_exists("the_field")){
        $philo_video = get_field("add_source_file");
    }
    ?>
<article class="masonry__brick entry format-video" data-aos="fade-up">
    <?php if($philo_video):?>
    <div class="entry__thumb video-image">
        <a href="<?php echo esc_url($philo_video); ?>" data-lity>
            <?php the_post_thumbnail("philosophy-home-square"); ?>
        </a>
    </div>
    <?php endif; ?>
    <?php get_template_part( "template-parts/common/post/summary" ); ?>
</article> <!-- end article -->