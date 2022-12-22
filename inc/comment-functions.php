<?php 

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