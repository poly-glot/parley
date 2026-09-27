<?php
$included = (array) parley_meta( 'included' );

if ( ! $included ) {
	return;
}
?>
<section class="checklist section" aria-labelledby="included-title">
	<div class="container">
		<h2 class="title checklist__title" id="included-title">What’s included</h2>
		<ul class="checklist__items">
			<?php foreach ( $included as $row ) : ?>
				<li class="checklist__item"><?php echo esc_html( $row['item'] ?? '' ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
