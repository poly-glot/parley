<?php
get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/hero-page', null, array(
		'subtitle' => (string) parley_meta( 'subtitle' ),
		'title'    => get_the_title(),
		'variant'  => 'paper',
	) );

	the_content();
}

get_footer();
