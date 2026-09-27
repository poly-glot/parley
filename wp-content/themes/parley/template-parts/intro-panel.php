<?php $front_id = (int) get_option( 'page_on_front' ); ?>
<section class="intro-panel" aria-labelledby="approach-title">
	<div class="intro-panel__card">
		<h2 class="intro-panel__heading display display--light" id="approach-title"><?php echo esc_html( parley_meta( 'approach_heading', $front_id ) ); ?></h2>
		<div class="intro-panel__body">
			<?php echo wp_kses_post( wpautop( parley_meta( 'approach_body', $front_id ) ) ); ?>
			<a class="button button--light" href="<?php echo esc_url( parley_page_url( 'about' ) ); ?>">About Parley</a>
		</div>
	</div>
</section>
