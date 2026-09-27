<section class="about-intro container" aria-label="Introduction">
	<div class="about-intro__monogram" aria-hidden="true">
		<span>P</span>
		<span class="about-intro__rule"></span>
		<span>Y</span>
	</div>
	<div class="about-intro__copy">
		<p class="about-intro__lead"><?php echo esc_html( parley_meta( 'intro_lead' ) ); ?></p>
		<div class="prose">
			<?php echo wp_kses_post( wpautop( parley_meta( 'intro_body' ) ) ); ?>
		</div>
	</div>
</section>
