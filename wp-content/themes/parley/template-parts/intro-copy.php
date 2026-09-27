<?php
$content = $args['content'] ?? '';
$variant = $args['variant'] ?? 'default';

if ( ! $content ) {
	return;
}
?>
<div class="intro-copy intro-copy--<?php echo esc_attr( $variant ); ?> container container--narrow">
	<div class="prose">
		<?php echo wp_kses_post( parley_lede( wpautop( $content ) ) ); ?>
	</div>
</div>
