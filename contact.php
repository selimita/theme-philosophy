<?php
/**
 * Template Name: Contact Page
 */
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
        </div> <!-- end s-content__header -->

        <div class="s-content__media col-full">
            <?php
            if ( is_active_sidebar( "contact-maps" ) ) {
                dynamic_sidebar( "contact-maps" );
            }
            ?>
        </div> <!-- end s-content__media -->

        <div class="col-full s-content__main">

            <?php if(class_exists('WPCF7')): ?>
            <?php the_content(); ?>
            <?php endif; ?>
            
            <div class="row block-1-2 block-tab-full">
                <?php
                if ( is_active_sidebar( "contact-info" ) ) {
                    dynamic_sidebar( "contact-info" );
                }
                ?>
            </div>

            <?php if(class_exists('WPCF7')): ?>
            <h3><?php _e( "Say Hello PO", "philosophy" ); ?></h3>
            <h3><?php printf( __( "%s Hello MITA", "philosophy" ), __("Say","philosophy") ); ?></h3>

            <div>

                <?php
                if ( get_field( "add_shortcode" ) ) {
                    echo do_shortcode( get_field( "add_shortcode" ) );
                }
                ?>
            </div>
            <?php endif; ?>
        </div> <!-- end s-content__main -->
    </article>
</section> <!-- s-content -->
<?php get_footer(); ?>