<?php
$variant  = $args['variant'] ?? 'paper';
$title    = $args['title'] ?? get_the_title();
$subtitle = $args['subtitle'] ?? '';
$kicker   = $args['kicker'] ?? '';
$icon     = $args['icon'] ?? '';
$image_id = $args['image_id'] ?? 0;
?>
<header class="page-hero page-hero--<?php echo esc_attr( $variant ); ?>">
	<?php if ( 'image' === $variant && $image_id ) : ?>
		<?php echo wp_get_attachment_image( $image_id, 'hero', false, array( 'class' => 'page-hero__image', 'alt' => '' ) ); ?>
	<?php endif; ?>
	<div class="page-hero__inner container">
		<?php if ( $icon ) : ?>
			<div class="page-hero__eyebrow">
				<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-<?php echo esc_attr( $icon ); ?>" /></svg>
			</div>
		<?php endif; ?>
		<?php if ( $kicker ) : ?>
			<div class="page-hero__eyebrow"><p class="page-hero__kicker"><?php echo esc_html( $kicker ); ?></p></div>
		<?php endif; ?>
		<h1 class="page-hero__title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $subtitle ) : ?>
			<p class="page-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
		<?php endif; ?>
	</div>
</header>
