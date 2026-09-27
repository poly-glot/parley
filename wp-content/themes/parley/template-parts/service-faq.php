<?php
$faqs = (array) parley_meta( 'faqs' );

if ( ! $faqs ) {
	return;
}
?>
<section class="faq section" aria-labelledby="faq-title">
	<div class="container container--narrow">
		<h2 class="title faq__heading" id="faq-title">Questions we’re often asked</h2>

		<?php foreach ( $faqs as $faq ) : ?>
			<details class="faq__item">
				<summary class="faq__question"><?php echo esc_html( $faq['question'] ?? '' ); ?></summary>
				<p class="faq__answer"><?php echo esc_html( $faq['answer'] ?? '' ); ?></p>
			</details>
		<?php endforeach; ?>
	</div>
</section>
