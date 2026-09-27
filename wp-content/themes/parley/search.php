<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => 'Results for “' . get_search_query() . '”',
	'title'    => 'Search results',
	'variant'  => 'plain',
) );

$listed = array();

while ( have_posts() ) {
	the_post();

	$listed[] = get_post();
}
?>
<div class="container dispatches-index">
	<?php get_template_part( 'template-parts/dispatch-toolbar' ); ?>
	<h2 class="visually-hidden">Dispatches</h2>
	<div class="dispatches-index__list">
		<?php if ( $listed ) : ?>
			<?php get_template_part( 'template-parts/loop-dispatches', null, array( 'images' => true, 'posts' => $listed ) ); ?>
		<?php else : ?>
			<p>Nothing found. Try a different search.</p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
