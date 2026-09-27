<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => 'Dispatches filed under this category',
	'title'    => single_cat_title( '', false ),
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
		<?php get_template_part( 'template-parts/loop-dispatches', null, array( 'images' => true, 'posts' => $listed ) ); ?>
	</div>
</div>
<?php
get_footer();
