<?php
get_header();

while ( have_posts() ) {
	the_post();
	?>
	<div class="page-hero page-hero--brand bio-band" aria-hidden="true"><p class="page-hero__title">Our team</p></div>
	<?php
	get_template_part( 'template-parts/team-bio' );
	get_template_part( 'template-parts/cta-band' );
}

get_footer();
