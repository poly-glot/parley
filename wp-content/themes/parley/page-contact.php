<?php
get_header();

while ( have_posts() ) {
	the_post();

	get_template_part( 'template-parts/hero-page', null, array(
		'subtitle' => (string) parley_meta( 'subtitle' ),
		'title'    => get_the_title(),
		'variant'  => 'brand',
	) );
	?>
	<div class="contact-layout container">
		<section aria-labelledby="enquiry-title">
			<h2 class="title" id="enquiry-title">Send us a message</h2>
			<p class="contact-layout__intro">
				Every conversation with us is confidential and there’s no obligation. A partner will reply within one working day,
				usually much sooner.
			</p>

			<?php if ( isset( $_GET['sent'] ) ) : ?>
				<p class="contact-layout__intro"><strong>Thank you. Your message is with us, and a partner will reply within one working day.</strong></p>
			<?php else : ?>
				<?php get_template_part( 'template-parts/contact-form' ); ?>
			<?php endif; ?>
		</section>

		<?php get_template_part( 'template-parts/contact-aside' ); ?>
	</div>
	<?php
}

get_footer();
