<?php
$case_studies = get_posts( array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'case_study',
	'posts_per_page' => 4,
) );

if ( ! $case_studies ) {
	return;
}

$total = count( $case_studies );
?>
<section class="case-carousel section section--mist" aria-roledescription="carousel" aria-labelledby="case-carousel-label">
	<div class="container labelled">
		<h2 class="side-label" id="case-carousel-label">Our work</h2>
		<div class="case-carousel__frame" data-carousel>
			<section
				class="case-carousel__track"
				data-carousel-track
				tabindex="0"
				aria-label="Case studies, scroll horizontally"
			>
				<?php foreach ( $case_studies as $index => $case_study ) : ?>
					<?php $region = parley_region_label( (string) parley_meta( 'region', $case_study->ID ) ); ?>
					<div
						class="case-carousel__slide"
						data-carousel-slide
						role="group"
						aria-roledescription="slide"
						aria-label="<?php echo esc_attr( ( $index + 1 ) . ' of ' . $total . ': ' . $region ); ?>"
						id="case-slide-<?php echo esc_attr( $index ); ?>"
					>
						<div class="case-carousel__heading">
							<p class="case-carousel__coordinates"><?php echo esc_html( parley_meta( 'coordinates', $case_study->ID ) ); ?></p>
							<h3 class="case-carousel__region"><?php echo esc_html( $region ); ?></h3>
							<p class="case-carousel__client"><?php echo esc_html( parley_meta( 'client_line', $case_study->ID ) ); ?></p>
						</div>
						<p class="case-carousel__teaser"><?php echo esc_html( parley_meta( 'teaser', $case_study->ID ) ); ?></p>
						<a class="case-carousel__link" href="<?php echo esc_url( get_permalink( $case_study ) ); ?>">
							Read the case study
							<span class="visually-hidden">: <?php echo esc_html( get_the_title( $case_study ) ); ?></span>
							<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-arrowLong" /></svg>
						</a>
					</div>
				<?php endforeach; ?>
			</section>
			<p class="visually-hidden" id="case-carousel-dots-label">Choose a case study</p>
			<ul class="case-carousel__dots" aria-labelledby="case-carousel-dots-label" data-carousel-controls hidden>
				<?php foreach ( $case_studies as $index => $case_study ) : ?>
					<li>
						<button
							class="case-carousel__dot"
							type="button"
							data-carousel-dot
							aria-controls="case-slide-<?php echo esc_attr( $index ); ?>"
							aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						>
							<span class="visually-hidden">Show <?php echo esc_html( parley_region_label( (string) parley_meta( 'region', $case_study->ID ) ) ); ?></span>
						</button>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
