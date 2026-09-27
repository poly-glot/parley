<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => 'One team. Every channel that matters.',
	'title'    => 'Services',
	'variant'  => 'paper',
) );

$services = get_posts( array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'service',
	'posts_per_page' => -1,
) );

get_template_part( 'template-parts/loop-services', null, array( 'posts' => $services ) );
get_template_part( 'template-parts/cta-band' );
get_footer();
