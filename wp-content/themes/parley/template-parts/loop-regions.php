<?php
$case_studies = $args['posts'] ?? array();
?>
<ul class="region-list" role="list">
	<?php foreach ( $case_studies as $case_study ) : ?>
		<li class="region">
			<?php echo get_the_post_thumbnail( $case_study, 'hero', array( 'class' => 'region__image', 'alt' => '', 'loading' => 'lazy' ) ); ?>
			<article class="region__content container">
				<header class="region__header">
					<p class="region__coordinates"><?php echo esc_html( parley_meta( 'coordinates', $case_study->ID ) ); ?></p>
					<h2 class="region__title"><?php echo esc_html( parley_region_label( (string) parley_meta( 'region', $case_study->ID ) ) ); ?></h2>
					<p class="region__client"><?php echo esc_html( parley_meta( 'client_line', $case_study->ID ) ); ?></p>
				</header>
				<p class="region__summary"><?php echo esc_html( parley_meta( 'region_summary', $case_study->ID ) ); ?></p>
				<a class="region__link" href="<?php echo esc_url( get_permalink( $case_study ) ); ?>">
					Read the case study
					<span class="visually-hidden">: <?php echo esc_html( get_the_title( $case_study ) ); ?></span>
					<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-arrowLong" /></svg>
				</a>
			</article>
		</li>
	<?php endforeach; ?>
</ul>
