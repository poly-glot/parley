<?php
$results       = (array) parley_meta( 'results' );
$service_ids   = array_filter( array_map( 'intval', (array) parley_meta( 'services' ) ) );
$service_names = implode( ', ', array_map( 'get_the_title', $service_ids ) );
$quote         = (string) parley_meta( 'quote' );
$chapters      = array(
	'challenge' => array( 'The challenge', (string) parley_meta( 'challenge' ) ),
	'approach'  => array( 'Our approach', (string) parley_meta( 'approach' ) ),
	'outcome'   => array( 'The outcome', (string) parley_meta( 'outcome' ) ),
);

$next = get_posts( array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'case_study',
	'posts_per_page' => -1,
) );
$ids  = array_map( static fn ( $post ) => $post->ID, $next );
$at   = array_search( get_the_ID(), $ids, true );
$next = false === $at || count( $next ) < 2 ? null : $next[ ( $at + 1 ) % count( $next ) ];
?>
<div class="case-study">
	<dl class="case-study__facts container">
		<div>
			<dt>Region</dt>
			<dd><?php echo esc_html( parley_region_label( (string) parley_meta( 'region' ) ) ); ?></dd>
		</div>
		<div>
			<dt>Services</dt>
			<dd><?php echo esc_html( $service_names ); ?></dd>
		</div>
		<div>
			<dt>Duration</dt>
			<dd><?php echo esc_html( parley_meta( 'duration' ) ); ?></dd>
		</div>
	</dl>
	<?php if ( $results ) : ?>
		<h2 class="visually-hidden" id="results-title">Results</h2>
		<dl class="case-study__results container" aria-labelledby="results-title">
			<?php foreach ( $results as $result ) : ?>
				<div class="case-study__result">
					<dt class="case-study__result-label"><?php echo esc_html( $result['label'] ?? '' ); ?></dt>
					<dd class="case-study__result-figure"><?php echo esc_html( $result['figure'] ?? '' ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	<?php endif; ?>
	<div class="case-study__chapters container container--narrow">
		<?php foreach ( $chapters as $key => [ $chapter_title, $chapter_body ] ) : ?>
			<?php if ( $chapter_body ) : ?>
				<section class="case-study__chapter" aria-labelledby="<?php echo esc_attr( $key ); ?>-title">
					<h2 class="case-study__chapter-title" id="<?php echo esc_attr( $key ); ?>-title"><?php echo esc_html( $chapter_title ); ?></h2>
					<div class="prose">
						<?php echo wp_kses_post( wpautop( $chapter_body ) ); ?>
					</div>
				</section>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php if ( $quote ) : ?>
		<figure class="case-study__quote container container--narrow">
			<svg class="icon case-study__quote-icon" aria-hidden="true" focusable="false"><use href="#icon-quote" /></svg>
			<blockquote>
				<p><?php echo esc_html( $quote ); ?></p>
			</blockquote>
			<figcaption><?php echo esc_html( parley_meta( 'quote_attribution' ) ); ?></figcaption>
		</figure>
	<?php endif; ?>
	<?php if ( $next ) : ?>
		<nav class="case-study__next container" aria-label="Next case study">
			<a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
				<span class="case-study__next-label">Next case study</span>
				<span class="case-study__next-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
				<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-arrowLong" /></svg>
			</a>
		</nav>
	<?php endif; ?>
</div>
