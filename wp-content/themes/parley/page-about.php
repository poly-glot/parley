<?php
get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/hero-page', null, array(
		'image_id' => get_post_thumbnail_id(),
		'subtitle' => (string) parley_meta( 'subtitle' ),
		'title'    => get_the_title(),
		'variant'  => 'image',
	) );

	get_template_part( 'template-parts/about-intro' );
	get_template_part( 'template-parts/about-venn' );

	$stories = (array) parley_meta( 'story' );

	if ( $stories ) {
		?>
		<div class="container container--narrow about-story">
			<?php foreach ( $stories as $index => $story ) : ?>
				<section class="prose" aria-labelledby="story-<?php echo esc_attr( $index ); ?>-title">
					<h2 id="story-<?php echo esc_attr( $index ); ?>-title"><?php echo esc_html( $story['heading'] ?? '' ); ?></h2>
					<?php echo wp_kses_post( wpautop( $story['body'] ?? '' ) ); ?>
				</section>
			<?php endforeach; ?>
		</div>
		<?php
	}

	get_template_part( 'template-parts/about-values' );
	get_template_part( 'template-parts/cta-band' );
}

get_footer();
