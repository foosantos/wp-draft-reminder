<?php

/**
 * Get all the days of the week
 *
 * @return array
 */
function get_days_of_the_week() {
	return [
		'sunday' => esc_html__('Sunday', 'draft-reminder'),
		'monday' => esc_html__('Monday', 'draft-reminder'),
		'tuesday' => esc_html__('Tuesday', 'draft-reminder'),
		'wednesday' => esc_html__('Wednesday', 'draft-reminder'),
		'thursday' => esc_html__('Thursday', 'draft-reminder'),
		'friday' => esc_html__('Friday', 'draft-reminder'),
		'saturday' => esc_html__('Saturday', 'draft-reminder')
	];
}
