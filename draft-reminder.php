<?php
/**
 * Plugin Name:     Draft Reminder
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Draft Reminder notifications for WordPress.
 * Author:          Felipe Santos
 * Author URI:      YOUR SITE HERE
 * Text Domain:     draft-reminder
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Draft_Reminder
 */

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








function testing() {
	var_dump(draftreminder_get_drafts());
}

add_action( 'wp_footer' , 'testing' );
