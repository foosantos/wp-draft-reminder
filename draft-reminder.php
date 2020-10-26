<?php
/**
 * Plugin Name:     Draft Reminder
 * Description:     Draft Reminder notifications for WordPress.
 * Author:          Felipe Santos
 * Text Domain:     draft-reminder
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Draft_Reminder
 */

add_action( 'draftreminder_sender', 'draftreminder_send_email' );

function draftreminder_activation() {
    wp_schedule_event( time(), 'weekly', 'draftreminder_sender' );
}

register_activation_hook( __FILE__, 'draftreminder_activation' );

function draftreminder_deactivation() {
    wp_clear_scheduled_hook( 'draftreminder_sender' );
}

register_deactivation_hook( __FILE__, 'draftreminder_deactivation' );

function draftreminder_get_drafts() {

	$drafts = new WP_Query(
		array(
			'posts_per_page' => 50,
			'post_status'	=> 'draft',
			'order' => 'ASC',
			'orderby' => 'date',
			'post_type' => 'post'
		)
	);

	$drafts_data = array();

	if ( $drafts->have_posts() ) :
		while ( $drafts->have_posts() ) :
			$drafts->the_post();
			$drafts_data[get_the_author_meta('ID')][get_the_ID()] = array(
				'title' => get_the_title(),
				'date' => get_the_date(),
				'category' => get_the_category(),
				'permalink' => get_the_permalink(),
				'edit-link' => get_edit_post_link(),
				'author' => get_the_author_meta('ID')
			);
		endwhile;
	endif;

	return $drafts_data;
}

function draftreminder_send_email() {

	$drafts = draftreminder_get_drafts();
	$email_subject = 'The subject';
	$email_headers = array('Content-Type: text/html; charset=UTF-8');

	foreach ($drafts as $author_id => $posts) {

		$email_to = get_the_author_meta( 'user_email', $author_id );
		$email_body = 'Hey there,<br><br>';
		$email_body .= '<ul>';

		foreach ($posts as $post_id => $post_meta) {

			$email_body .= '<li>' . $post_meta['title'] . '</li>';

		}

		$email_body .= '</ul>';

		wp_mail( $email_to, $email_subject, $email_body, $email_headers );

	}
}
