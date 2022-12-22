<?php

require_once( get_theme_file_path( "/inc/tgm.php" ) );
require_once( get_theme_file_path( "/inc/attachments.php" ) );
require_once( get_theme_file_path( "/inc/cmb2-attached-posts.php" ) );
// require_once( get_theme_file_path( "/widgets/social-icons-widget.php" ) );

if ( site_url() == "http://demo.lwhh.com" ) {
    define( "VERSION", time() );
} else {
    define( "VERSION", wp_get_theme()->get( "Version" ) );
}

// Content Width
if ( ! isset( $content_width ) ) $content_width = 960; 

function philosophy_theme_setup() {
    $feature = add_theme_support('automatic-feed-links');
    load_theme_textdomain( "philosophy", get_theme_file_path("/languages") );
    add_theme_support( "post-thumbnails" );
    add_theme_support( "title-tag" );
    add_theme_support( $feature );
    add_theme_support( 'html5', array( 'search-form', 'comment-list' ) );
    add_theme_support( "post-formats", array( "image", "gallery", "quote", "audio", "video", "link" ) );
    add_editor_style( "/assets/css/editor-style.css" );

    register_nav_menu( "topmenu", __( "Top Menu", "philosophy" ) );
    register_nav_menus(array(
        "footer-left"=>__("Footer Left Menu","philosophy"),
        "footer-middle"=>__("Footer Middle Menu","philosophy"),
        "footer-right"=>__("Footer Right Menu","philosophy"),
     ));
    add_image_size("philosophy-home-square",400,400,true);
}

add_action( "after_setup_theme", "philosophy_theme_setup" );

function philosophy_assets() {
    wp_enqueue_style( "fontawesome-css", get_theme_file_uri( "/assets/css/font-awesome/css/font-awesome.css" ), null, "1.0" );
    wp_enqueue_style( "fonts-css", get_theme_file_uri( "/assets/css/fonts.css" ), null, "1.0" );
    wp_enqueue_style( "base-css", get_theme_file_uri( "/assets/css/base.css" ), null, "1.0" );
    wp_enqueue_style( "vendor-css", get_theme_file_uri( "/assets/css/vendor.css" ), null, "1.0" );
    wp_enqueue_style( "main-css", get_theme_file_uri( "/assets/css/main.css" ), null, "1.0" );
    wp_enqueue_style( "philosophy-css", get_stylesheet_uri(), null, VERSION );

    wp_enqueue_script( "modernizr-js", get_theme_file_uri( "/assets/js/modernizr.js" ), null, "1.0" );
    wp_enqueue_script( "pace-js", get_theme_file_uri( "/assets/js/pace.min.js" ), null, "1.0" );
    wp_enqueue_script( "plugins-js", get_theme_file_uri( "/assets/js/plugins.js" ), array( "jquery" ), "1.0", true );
    if ( is_singular() ) {
        wp_enqueue_script( "comment-reply" );
    }
    wp_enqueue_script( "main-js", get_theme_file_uri( "/assets/js/main.js" ), array( "jquery" ), "1.0", true );
}

add_action( "wp_enqueue_scripts", "philosophy_assets" );

    // Philosophy PAGINATION
    if(!function_exists("philosophy_pagination")){
        function philosophy_pagination() {
            global $wp_query;
            if ( $wp_query->max_num_pages <= 1 ) {
                return;
            }
            $links = paginate_links( array(
                'current'  => max( 1, get_query_var( 'paged' ) ),
                'total'    => $wp_query->max_num_pages,
                'type'     => 'list',
                'mid_size' => apply_filters("philo_mid_size",1)
            ) );
            $links = str_replace( "page-numbers", "pgn__num", $links );
            $links = str_replace( "<ul class='pgn__num'>", "<ul>", $links );
            $links = str_replace( "next pgn__num", "pgn__next", $links );
            $links = str_replace( "prev pgn__num", "pgn__prev", $links );
            echo wp_kses_post($links);
        }
    }
// MID Size Changing FUNCTION
function philo_mid_size($mid_size){
    $mid_size = 2;
    return $mid_size;
}
add_filter("philo_mid_size","philo_mid_size");

// Category Description AUTOP OFF
remove_action("term_description","wpautop");
// Default comments.php Value OFF
function philo_defaults( $defaults ) {
    if ( isset( $defaults[ 'comment_field' ] ) ) {
        $defaults[ 'comment_field' ] = '';
    }
    return $defaults;
}
//add_filter( 'comment_form_defaults', 'philo_defaults' );

// Move the comment text field to the bottom.
function philo_comment_field( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $author_field = $fields['author'];
    unset( $fields['author'] );
    $email_field = $fields['email'];
    unset( $fields['email'] );
    $url_field = $fields['url'];
    unset( $fields['url'] );

    $fields['author'] = $author_field;
    $fields['url'] = $url_field;
    $fields['email'] = $email_field;
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields','philo_comment_field', 10, 1 );

//Change default fields, add placeholder and change type attributes.
function philo_placeholder_aeu( $fields ) {
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="'
        . _x(
            'Your Name',
            'comment form placeholder',
            'philosophy'
            )
        . '"',
        $fields['author']
    );
    $fields['email'] = str_replace(
    '<input id="email" name="email" type="text"',
    '<input type="email" placeholder="contact@example.com"  id="email" name="email"',
    $fields['email']
    );
    $fields['url'] = str_replace(
        '<input id="url" name="url" type="text"',
        '<input placeholder="http://example.com" id="url" name="url" type="url"',
        $fields['url']
    );
    return $fields;
}
add_filter( 'comment_form_default_fields', 'philo_placeholder_aeu' );

/**
 * Comment Form Placeholder Comment Field
 */
function placeholder_comment_form_field($fields) {
    $replace_comment = __('Your Comment', 'philosophy');
    
    $fields['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'philosophy' ) .
    '</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.$replace_comment.'" aria-required="true"></textarea></p>';
    
    return $fields;
}
add_filter( 'comment_form_defaults', 'placeholder_comment_form_field' );

// Change [Submit Button Label]
function philo_label($fields) {
    $fields['label_submit'] = esc_html__( 'Submit Comment', 'philosophy' );
    return $fields;
}
//add_filter('comment_form_fields','philo_label');

function philosophy_widgets(){
    register_sidebar( array(
        'name' => __( 'About Us Page', 'philosophy' ),
        'id' => 'about-us',
        'description' => __( 'Widgets in this area will be shown on about us page.', 'philosophy' ),
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Add Google Maps', 'philosophy' ),
        'id' => 'contact-maps',
        'description' => __( 'Widgets in this area will be shown on contact page.', 'philosophy' ),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name' => __( 'Contact Page Information Section', 'philosophy' ),
        'id' => 'contact-info',
        'description' => __( 'Widgets in this area will be shown on contact page.', 'philosophy' ),
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );
}
add_action("widgets_init","philosophy_widgets");

// Search Form as Like HTML
function philosophy_search_form( $form ) {
    $homedir      = home_url( "/" );
    $label        = __( "Search for:", "philosophy" );
    $button_label = __( "Search", "philosophy" );
    $post_type = <<<PT
<input type="hidden" name="post_type" value="post" >
PT;
    if(is_post_type_archive("book")){
    $post_type = <<<PT
<input type="hidden" name="post_type" value="book" >
PT;
    }
    $newform      = <<<FORM
<form role="search" method="get" class="header__search-form" action="{$homedir}">
    <label>
        <span class="hide-content">{$label}</span>
        <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s"
                title="{$label}" autocomplete="off">
    </label>
    {$post_type}
    <input type="submit" class="search-submit" value="{$button_label}">
</form>
FORM;
    return $newform;
}
add_filter( "get_search_form", "philosophy_search_form" );


// HOOK ACTION & FILTER
function philo_action(){
    echo "Hello MITA";
}
add_action("philosophy_action_hook","philo_action");
remove_action("philosophy_action_hook","philo_action");

// HOOK ACTION & FILTER
function philo_cat_views($cat_total_views){
    if("arfa" == $cat_total_views){
        $cat_views = get_option("all_views");
        $cat_views = $cat_views?$cat_views:0;
        $cat_views++;
        update_option("all_views",$cat_views);
        echo $cat_views."Views";
    }
}
add_action("philo_cat_views","philo_cat_views");

// Filter HOOK
function philo_header_classes($header_class){
    if(is_home()){
        return $header_class;
    } else{
        return "";
    }
}
add_filter("philo_header_classes","philo_header_classes");

// MID Size Changing FUNCTION
function philo_dparam($param1,$param2){
    return ucwords($param1)." ".strtoupper($param2);
}
add_filter("philo_dparam","philo_dparam",10,2);
remove_filter("philo_dparam","philo_dparam",10,2);

// Default Priority FUNCTION
function philo_priority_default(){
    echo "Value 1";
}
add_filter("philo_hook","philo_priority_default",10);
// Before Priority FUNCTION
function philo_priority_before(){
    echo "Value 1";
}
add_filter("philo_hook","philo_priority_before",9);
// After Priority FUNCTION
function philo_priority_after(){
    echo "Value 1";
}
add_filter("philo_hook","philo_priority_after",11);

    // Rewrite Permalink Parent & Child CPT
    function philo_permalink($post_link, $id){
        $p = get_post($id); // Current Post Type
        if(is_object($p) && "chapter" == get_post_type($id)){
            $parent_post_id = get_field("parent_book");
            $parent_post = get_post($parent_post_id);
            if($parent_post){
                $post_link = str_replace("%book%",$parent_post->post_name,$post_link);
            }
        }
        if(is_object($p) && "book" == get_post_type($p)){
            $genre = wp_get_post_terms($p->ID,"genre");
            if( is_array($genre) && count($genre)>0 ){
                $slug = $genre[0]->slug;
                $post_link = str_replace("%genre%",$slug,$post_link);
            }else{
                $slug = "generic";
                $post_link = str_replace("%genre%",$slug,$post_link);
            }
        }
        return $post_link;
    }
    add_filter("post_type_link","philo_permalink",1,2);

    // Tags OR Terms NAME & lIST
    function philo_tags_title( $title ) {
        if ( is_post_type_archive( 'book' ) || is_tax('language') ) {
            $title = __( 'Languages', 'philosophy' );
        }
    
        return $title;
    }
    add_filter( 'philo_tags_title', 'philo_tags_title' );
    
    function philo_tags( $tags ) {
        if ( is_post_type_archive( 'book' ) || is_tax('language') ) {
            $tags = get_terms( array(
                'taxonomy'   => 'language',
                'hide_empty' => true
            ) );
        }
        return $tags;
    }
    add_filter( 'philo_tags', 'philo_tags' );