<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => 'It may have moved, or it never existed.',
	'title'    => 'This page has left the room',
	'variant'  => 'plain',
) );
?>
<p class="not-found container">
	<a class="button button--solid" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>
	<a class="button" href="<?php echo esc_url( parley_dispatches_url() ); ?>">Read Dispatches</a>
</p>
<?php
get_footer();
