<?php

function register_options() {

	register_setting(
		'general',
		'draftreminder_posts_total',
		[
			'sanitize_callback' => function ($value) {
				if ($value < 1 || $value > 200) {
					add_settings_error(
						'draftreminder_posts_total',
						'less_than_one',
						'The total of posts for Draft Reminder needs to be more than 1 and less than 200.',
						'error'
					);
					return get_option('draftreminder_posts_total');
				}

				return $value;
			},
		]
	);

	add_settings_field(
		'draftreminder_posts_total',
		'Posts total',
		function ($args) {
			$value = get_option('draftreminder_posts_total', 50);
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

