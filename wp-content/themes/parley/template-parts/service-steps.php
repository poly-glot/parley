<?php
$steps = (array) parley_meta( 'steps' );

if ( ! $steps ) {
	return;
}
?>
<section class="process-steps section section--paper" aria-labelledby="process-title">
	<div class="container">
		<h2 class="title process-steps__heading" id="process-title">How we work</h2>
		<ol class="process-steps__list">
			<?php foreach ( $steps as $step ) : ?>
				<li class="process-steps__step">
					<h3 class="process-steps__title"><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $step['text'] ?? '' ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
