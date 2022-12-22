<?php 
$philo_audio = "";
if(function_exists("the_field")){
    $philo_audio = get_field("add_source_file");
}
?>
<article class="masonry__brick entry format-audio" data-aos="fade-up">

    <div class="entry__thumb">
        <a href="<?php the_permalink(); ?>" class="entry__thumb-link">
            <?php the_post_thumbnail("philosophy-home-square"); ?>
        </a>
        <?php if($philo_audio): ?>
        <div class="audio-wrap">
            <audio id="player" src="<?php echo esc_url($philo_audio); ?>" width="100%" height="42" controls="controls"></audio>
        </div>
        <?php endif; ?>
    </div>

    <?php get_template_part( "template-parts/common/post/summary" ); ?>

</article> <!-- end article -->