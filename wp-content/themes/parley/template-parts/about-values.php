<?php
$values = (array) parley_meta( 'values' );

if ( ! $values ) {
	return;
}
?>
<section class="values section section--mist" aria-label="Our values">
	<ul class="values__list container" role="list">
		<?php foreach ( $values as $value ) : ?>
			<li class="values__item">
				<h2 class="values__title"><?php echo esc_html( $value['title'] ?? '' ); ?></h2>
				<p><?php echo esc_html( $value['text'] ?? '' ); ?></p>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
