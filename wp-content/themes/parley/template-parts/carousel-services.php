<?php
$services = get_posts( array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'service',
	'posts_per_page' => -1,
) );

if ( ! $services ) {
	return;
}
?>
<section
	class="service-carousel section section--paper"
	aria-roledescription="carousel"
	aria-labelledby="service-carousel-label"
>
	<div class="container labelled">
		<h2 class="side-label" id="service-carousel-label">Services</h2>
		<div class="service-carousel__frame" data-carousel>
			<button class="service-carousel__arrow" type="button" data-carousel-previous aria-label="Previous services" hidden>
				<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-arrowLeft" /></svg>
			</button>
			<section
				class="service-carousel__track"
				data-carousel-track
				tabindex="0"
				aria-label="Services, scroll horizontally"
			>
				<ul class="service-carousel__cards">
					<?php foreach ( $services as $service ) : ?>
						<li class="service-card" data-carousel-slide>
							<span class="service-card__ring">
								<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-<?php echo esc_attr( parley_meta( 'icon', $service->ID ) ); ?>" /></svg>
							</span>
							<h3 class="service-card__title"><?php echo esc_html( get_the_title( $service ) ); ?></h3>
							<a class="service-card__link" href="<?php echo esc_url( get_permalink( $service ) ); ?>">
								View details
								<span class="visually-hidden">about <?php echo esc_html( get_the_title( $service ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
			<button class="service-carousel__arrow" type="button" data-carousel-next aria-label="Next services" hidden>
				<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-arrowRight" /></svg>
			</button>
		</div>
	</div>
</section>
