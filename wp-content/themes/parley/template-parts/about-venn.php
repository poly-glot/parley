<?php
$heading = (string) parley_meta( 'venn_heading' );
$caption = (string) parley_meta( 'venn_caption' );
$labels  = array();

foreach ( array( 'venn_label_1', 'venn_label_2', 'venn_label_3' ) as $meta_key ) {
	$label    = trim( (string) parley_meta( $meta_key ) );
	$words    = explode( ' ', $label );
	$labels[] = array( array_shift( $words ), implode( ' ', $words ) );
}

$positions = array(
	array( 72, 84, 102 ),
	array( 248, 84, 102 ),
	array( 160, 234, 252 ),
);
?>
<section class="venn container" aria-labelledby="venn-title">
	<h2 class="venn__heading title" id="venn-title"><?php echo esc_html( $heading ); ?></h2>
	<figure class="venn__figure">
		<svg class="venn__svg" viewBox="0 0 320 300" role="img" aria-labelledby="venn-title-desc">
			<desc id="venn-title-desc">
				Three overlapping circles labelled <?php echo esc_html( implode( ', ', array_map( static fn ( $pair ) => trim( $pair[0] . ' ' . $pair[1] ), $labels ) ) ); ?>. Parley sits where all three overlap.
			</desc>
			<path class="venn__overlap" d="M160 179.3A80 80 0 0 1 120.7 120.3A80 80 0 0 1 199.3 120.3A80 80 0 0 1 160 179.3Z" />
			<circle class="venn__circle" cx="120" cy="110" r="80" />
			<circle class="venn__circle" cx="200" cy="110" r="80" />
			<circle class="venn__circle" cx="160" cy="190" r="80" />
			<?php foreach ( $labels as $index => [ $line_1, $line_2 ] ) : ?>
				<text class="venn__label">
					<tspan x="<?php echo esc_attr( $positions[ $index ][0] ); ?>" y="<?php echo esc_attr( $positions[ $index ][1] ); ?>"><?php echo esc_html( $line_1 ); ?></tspan>
					<tspan x="<?php echo esc_attr( $positions[ $index ][0] ); ?>" y="<?php echo esc_attr( $positions[ $index ][2] ); ?>"><?php echo esc_html( $line_2 ); ?></tspan>
				</text>
			<?php endforeach; ?>
			<text class="venn__mark" x="160" y="150">P|Y</text>
		</svg>
		<?php if ( $caption ) : ?>
			<figcaption class="venn__caption"><?php echo esc_html( $caption ); ?></figcaption>
		<?php endif; ?>
	</figure>
</section>
