<?php
get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/article-body' );

	$category = get_the_category()[0] ?? null;
	$related  = $category ? get_posts( array(
		'category'       => $category->term_id,
		'post__not_in'   => array( get_the_ID() ),
		'posts_per_page' => 2,
	) ) : array();

	if ( $related ) {
		?>
		<section class="section section--paper" aria-labelledby="related-title">
			<div class="container labelled">
				<p class="side-label" aria-hidden="true">Dispatches</p>
				<div class="section-intro__content">
					<h2 class="display section-intro__heading" id="related-title">More dispatches</h2>
					<?php get_template_part( 'template-parts/loop-dispatches', null, array( 'posts' => $related ) ); ?>
				</div>
			</div>
		</section>
		<?php
	}

	get_template_part( 'template-parts/cta-band', null, array(
		'body'         => 'Get The Parley Brief: one email a month on what moved, what it means and what to do about it.',
		'button_label' => 'Subscribe',
		'button_url'   => '#newsletter-email',
		'heading'      => 'Enjoyed this?',
	) );
}

get_footer();
