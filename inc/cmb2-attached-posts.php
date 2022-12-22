<?php
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function philo_drag_drop_order() {
    // ADMIN Current PAGE ID
    $post_id = 0;
    if ( isset( $_REQUEST['post'] ) || isset( $_REQUEST['post_ID'] ) ) {
        $post_id = empty( $_REQUEST['post_ID'] ) ? $_REQUEST['post'] : $_REQUEST['post_ID'];
    }

    $cmb = new_cmb2_box( array(
        'id'           => 'cmb2_attached_posts_field',
        'title'        => __( 'Attached Posts', 'philosophy' ),
        'object_types' => array( 'book' ),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => false,
    ) );

    $cmb->add_field( array(
        'name'    => __( 'Chapters', 'philosophy' ),
        'desc'    => __( 'Drag & Drop ORDER', 'philosophy' ),
        'id'      => 'attached_cmb2_attached_posts',
        'type'    => 'custom_attached_posts',
        'column'  => true,
        'options' => array(
            'show_thumbnails' => true,
            'filter_boxes'    => true,
            'query_args'      => array(
                'posts_per_page' => -1,
                'post_type'      => 'chapter',
                'meta_key'=>'parent_book',
                'meta_value'=> $post_id
            ),
        ),
    ) );
}
add_action( 'cmb2_init', 'philo_drag_drop_order' );