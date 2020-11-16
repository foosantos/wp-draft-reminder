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

include_once plugin_dir_path( __FILE__ ) . '/includes/options-page.php';

include_once plugin_dir_path( __FILE__ ) . '/includes/helpers.php';

add_action( 'sender', 'send_email' );

function draftreminder_activation() {
    wp_schedule_event( time(), 'weekly', 'sender' );
}

register_activation_hook( __FILE__, 'draftreminder_activation' );

function draftreminder_deactivation() {
    wp_clear_scheduled_hook( 'sender' );
}

register_deactivation_hook( __FILE__, 'draftreminder_deactivation' );

function get_drafts() {

	$drafts = new WP_Query(
		array(
			'posts_per_page' => get_option('draftreminder_posts_total', 50),
			'post_status'	=> 'draft',
			'order' => 'ASC',
			'orderby' => 'date',
			'post_type' => get_option( 'draftreminder_post_types', ['post'])
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

function send_email() {

	$drafts = get_drafts();
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
