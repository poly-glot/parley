<?php
$featured = $args['post'] ?? null;

if ( ! $featured ) {
	return;
}
?>
<article class="dispatch-featured">
	<?php echo get_the_post_thumbnail( $featured, 'card', array( 'class' => 'dispatch-featured__image', 'alt' => '' ) ); ?>
	<div class="dispatch-featured__body">
		<time class="date-badge date-badge--inverse" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $featured ) ); ?>">
			<span class="date-badge__day"><?php echo esc_html( get_the_date( 'j', $featured ) ); ?></span>
			<span class="date-badge__month"><?php echo esc_html( get_the_date( 'M', $featured ) ); ?></span>
		</time>
		<div class="dispatch-featured__text">
			<p class="dispatch-featured__label">Featured</p>
			<h2 class="dispatch-featured__title"><?php echo esc_html( get_the_title( $featured ) ); ?></h2>
			<p><?php echo esc_html( get_the_excerpt( $featured ) ); ?></p>
			<a class="button button--light" href="<?php echo esc_url( get_permalink( $featured ) ); ?>">
				Continue reading
				<span class="visually-hidden">: <?php echo esc_html( get_the_title( $featured ) ); ?></span>
			</a>
		</div>
	</div>
</article>
