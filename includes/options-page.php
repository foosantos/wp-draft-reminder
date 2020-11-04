<?php

function draftreminder_options_page_html() {
	?>
	<h1>Draft Reminder Options</h1>
	<form action="options.php" method="post">
		<?php settings_fields('draftreminder_options') ?>
		<?php do_settings_sections('draftreminder_options') ?>
		<?php submit_button(); ?>
	</form>

	<?php
}

function draftreminder_options_page() {

add_options_page( 'Draft Reminder Options', 'Draft Reminder', 'manage_options', 'draft-reminder','draftreminder_options_page_html' );

}

add_action( 'admin_menu', 'draftreminder_options_page' );

function register_options() {

	register_setting(
		'draftreminder_options',
		'draftreminder_posts_total',
		[
			'sanitize_callback' => function ($value) {
				if ($value < 1 || $value > 200) {
					add_settings_error(
						'draftreminder_posts_total',
						'invalid_value',
						'The total of posts for Draft Reminder needs to be more than 1 and less than 200.',
						'error'
					);
					return get_option('draftreminder_posts_total');
				}

				return $value;
			},
		]
	);

	add_settings_section(
		'draftreminder_options_section',
		'',
		function () {},
		'draftreminder_options'
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
		'draftreminder_options',
		'draftreminder_options_section',
		[
			'label_for' => 'draftreminder_posts_total',
			'class' => 'draftreminder draftreminder_posts_total'
		]
	);

}


add_action( 'admin_init', 'register_options');

