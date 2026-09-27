<?php
$posts_to_list = $args['posts'] ?? array();
$with_images   = ! empty( $args['images'] );
?>
<ul class="dispatch-list<?php echo $with_images ? ' dispatch-list--images' : ''; ?>">
	<?php foreach ( $posts_to_list as $dispatch ) : ?>
		<?php $category = get_the_category( $dispatch )[0] ?? null; ?>
		<li class="dispatch-item">
			<article class="dispatch-item__article">
				<time class="date-badge" datetime="<?php echo esc_attr( get_the_date( 'Y-m-d', $dispatch ) ); ?>">
					<span class="date-badge__day"><?php echo esc_html( get_the_date( 'j', $dispatch ) ); ?></span>
					<span class="date-badge__month"><?php echo esc_html( get_the_date( 'M', $dispatch ) ); ?></span>
				</time>
				<div class="dispatch-item__body">
					<?php if ( $with_images && has_post_thumbnail( $dispatch ) ) : ?>
						<?php echo get_the_post_thumbnail( $dispatch, 'card', array( 'class' => 'dispatch-item__image', 'alt' => '', 'loading' => 'lazy' ) ); ?>
					<?php endif; ?>
					<h3 class="dispatch-item__title">
						<a href="<?php echo esc_url( get_permalink( $dispatch ) ); ?>"><?php echo esc_html( get_the_title( $dispatch ) ); ?></a>
					</h3>
					<p class="dispatch-item__excerpt"><?php echo esc_html( get_the_excerpt( $dispatch ) ); ?></p>
					<?php if ( $category ) : ?>
						<p class="dispatch-item__category"><a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></p>
					<?php endif; ?>
				</div>
			</article>
		</li>
	<?php endforeach; ?>
</ul>
