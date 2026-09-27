<?php $cta = parley_cta_args( $args ?? array() ); ?>
<section class="cta-band" aria-labelledby="cta-band-title">
	<div class="cta-band__inner container">
		<h2 class="cta-band__title display display--light" id="cta-band-title"><?php echo esc_html( $cta['heading'] ); ?></h2>
		<?php if ( $cta['body'] ) : ?>
			<p class="cta-band__body"><?php echo esc_html( $cta['body'] ); ?></p>
		<?php endif; ?>
		<a class="button button--white" href="<?php echo esc_url( $cta['button_url'] ); ?>"><?php echo esc_html( $cta['button_label'] ); ?></a>
	</div>
</section>
