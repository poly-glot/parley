<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'title'   => get_the_archive_title() ?: get_bloginfo( 'name' ),
	'variant' => 'plain',
) );

$listed = array();

while ( have_posts() ) {
	the_post();

	$listed[] = get_post();
}
?>
<div class="container dispatches-index">
	<div class="dispatches-index__list">
		<?php get_template_part( 'template-parts/loop-dispatches', null, array( 'posts' => $listed ) ); ?>
	</div>
</div>
<?php
get_footer();
