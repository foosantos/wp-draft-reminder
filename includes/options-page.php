<?php

function register_options() {

	register_setting(
		'general',
		'draftreminder_posts_total',
		[
			'sanitize_callback' => 'intval',
		]
	);

	add_settings_field(
		'draftreminder_posts_total',
		'Posts total',
		function ($args) {
			$value = get_option('draftreminder_posts_total');
			?>
			<input type="number" name="draftreminder_posts_total" id="<?php echo $args['label_for']; ?>" value="<?php echo $value; ?>">
			<?php
			error_log( print_r($args, true) );
		},
		'general',
		'default',
		[
			'label_for' => 'draftreminder_posts_total',
			'class' => 'draftreminder draftreminder_posts_total'
		]
	);

}


add_action( 'admin_init', 'register_options');

