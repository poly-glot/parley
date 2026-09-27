<?php
$services = $args['posts'] ?? array();
?>
<ol class="service-list container">
	<?php foreach ( $services as $service ) : ?>
		<li class="service-row">
			<span class="icon-ring service-row__ring">
				<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-<?php echo esc_attr( parley_meta( 'icon', $service->ID ) ); ?>" /></svg>
			</span>
			<div class="service-row__body">
				<h2 class="service-row__title"><?php echo esc_html( get_the_title( $service ) ); ?></h2>
				<p><?php echo esc_html( parley_meta( 'summary', $service->ID ) ); ?></p>
				<a class="button" href="<?php echo esc_url( get_permalink( $service ) ); ?>">
					View details
					<span class="visually-hidden">about <?php echo esc_html( get_the_title( $service ) ); ?></span>
				</a>
			</div>
		</li>
	<?php endforeach; ?>
</ol>
