<?php
get_header();

$posts_page  = get_post( (int) get_option( 'page_for_posts' ) );
$sticky_ids  = array_map( 'intval', (array) get_option( 'sticky_posts' ) );
$featured    = null;

if ( $sticky_ids && ! is_paged() ) {
	$featured = get_posts( array( 'ignore_sticky_posts' => true, 'post__in' => $sticky_ids, 'posts_per_page' => 1 ) )[0] ?? null;
}

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => $posts_page ? parley_meta( 'subtitle', $posts_page->ID ) : '',
	'title'    => $posts_page ? get_the_title( $posts_page ) : 'Dispatches',
	'variant'  => 'plain',
) );

$listed = array();

while ( have_posts() ) {
	the_post();

	if ( ! $featured || get_the_ID() !== $featured->ID ) {
		$listed[] = get_post();
	}
}
?>
<div class="container dispatches-index">
	<?php get_template_part( 'template-parts/dispatch-toolbar' ); ?>
	<?php get_template_part( 'template-parts/dispatch-featured', null, array( 'post' => $featured ) ); ?>
	<h2 class="visually-hidden">Dispatches</h2>
	<div class="dispatches-index__list">
		<?php get_template_part( 'template-parts/loop-dispatches', null, array( 'images' => true, 'posts' => $listed ) ); ?>
	</div>
</div>
<?php
get_footer();
