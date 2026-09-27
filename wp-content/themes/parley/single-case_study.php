<?php
get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/hero-page', null, array(
		'image_id' => get_post_thumbnail_id(),
		'kicker'   => parley_region_label( (string) parley_meta( 'region' ) ),
		'subtitle' => (string) parley_meta( 'client_line' ),
		'title'    => get_the_title(),
		'variant'  => 'image',
	) );

	get_template_part( 'template-parts/case-study-body' );
	get_template_part( 'template-parts/cta-band' );
}

get_footer();
