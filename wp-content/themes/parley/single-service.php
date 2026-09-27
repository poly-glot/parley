<?php
get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/hero-page', null, array(
		'icon'     => (string) parley_meta( 'icon' ),
		'subtitle' => (string) parley_meta( 'tagline' ),
		'title'    => get_the_title(),
		'variant'  => 'plain',
	) );

	get_template_part( 'template-parts/intro-copy', null, array( 'content' => (string) parley_meta( 'intro' ) ) );
	get_template_part( 'template-parts/service-panel' );
	get_template_part( 'template-parts/service-included' );
	get_template_part( 'template-parts/service-steps' );
	get_template_part( 'template-parts/service-faq' );
	get_template_part( 'template-parts/cta-band' );
}

get_footer();
