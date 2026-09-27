<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => 'Complex international issues, handled with care',
	'title'    => 'Our work',
	'variant'  => 'brand',
) );

get_template_part( 'template-parts/intro-copy', null, array(
	'content' => 'Much of our best work never carries our name, and many of our clients prefer it that way. What follows is shared with permission, with details changed where safety or confidentiality requires.',
	'variant' => 'spaced',
) );

$case_studies = get_posts( array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'case_study',
	'posts_per_page' => -1,
) );

get_template_part( 'template-parts/loop-regions', null, array( 'posts' => $case_studies ) );
get_template_part( 'template-parts/cta-band' );
get_footer();
