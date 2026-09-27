<?php
$panels   = (array) parley_meta( 'panel' );
$image_id = (int) parley_meta( 'panel_image' );

if ( ! $panels ) {
	return;
}
?>
<section class="image-panel" aria-label="<?php echo esc_attr( $panels[0]['heading'] ?? '' ); ?>">
	<?php if ( $image_id ) : ?>
		<?php echo wp_get_attachment_image( $image_id, 'panel', false, array( 'class' => 'image-panel__image', 'alt' => '', 'loading' => 'lazy' ) ); ?>
	<?php endif; ?>
	<div class="image-panel__content container container--narrow">
		<div class="prose prose--inverse">
			<?php foreach ( $panels as $panel ) : ?>
				<h2 class="image-panel__heading"><?php echo esc_html( $panel['heading'] ?? '' ); ?></h2>
				<?php echo wp_kses_post( wpautop( $panel['body'] ?? '' ) ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
