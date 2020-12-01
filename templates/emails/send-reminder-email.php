<?php do_action( 'draftreminder_email_header', $author_id ); ?>

<p> <?php esc_html_e( 'Hey there,', 'draftreminder' ); ?> </p>
<br><br>
<ul>
	<?php foreach ($posts as $post_id => $post_meta) { ?>

		<li> <?php echo $post_meta['title'] ?> </li>

	<?php } ?>
</ul>

<?php do_action( 'draftreminder_email_footer', $author_id ); ?>
