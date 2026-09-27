<?php
get_header();

get_template_part( 'template-parts/hero-home' );
get_template_part( 'template-parts/intro-panel' );
get_template_part( 'template-parts/carousel-case-studies' );
get_template_part( 'template-parts/carousel-services' );

$latest = get_posts( array( 'posts_per_page' => 4 ) );
?>
<section class="section" aria-labelledby="latest-dispatches-title">
	<div class="container labelled">
		<p class="side-label" aria-hidden="true">Dispatches</p>
		<div class="section-intro__content">
			<h2 class="display section-intro__heading" id="latest-dispatches-title">
				Latest
				<br />
				thinking
			</h2>

			<?php get_template_part( 'template-parts/loop-dispatches', null, array( 'posts' => $latest ) ); ?>
			<p class="section-intro__footer">
				<a class="button" href="<?php echo esc_url( parley_dispatches_url() ); ?>">
					All Dispatches
					<svg class="icon button__icon" aria-hidden="true" focusable="false"><use href="#icon-arrowLong" /></svg>
				</a>
			</p>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/cta-band' );
get_footer();
