<?php
const PARLEY_STYLES = array(
	'base/tokens',
	'base/base',
	'base/layout',
	'atoms/button',
	'atoms/heading',
	'atoms/icon',
	'atoms/logo',
	'atoms/prose',
	'atoms/side-label',
	'components/about-intro',
	'components/article',
	'components/bio',
	'components/case-carousel',
	'components/case-study',
	'components/checklist',
	'components/contact-aside',
	'components/contact-form',
	'components/credits-table',
	'components/cta-band',
	'components/dispatch-featured',
	'components/dispatch-list',
	'components/dispatch-toolbar',
	'components/dispatches-index',
	'components/faq',
	'components/home-hero',
	'components/image-panel',
	'components/intro-copy',
	'components/intro-panel',
	'components/page-hero',
	'components/process-steps',
	'components/region-list',
	'components/section-intro',
	'components/service-carousel',
	'components/service-list',
	'components/site-footer',
	'components/site-header',
	'components/statement',
	'components/portrait',
	'components/team-grid',
	'components/values',
	'components/venn',
);

const PARLEY_REGIONS = array(
	'latin-america' => 'Latin America',
	'africa'        => 'Africa',
	'europe'        => 'Europe',
	'middle-east'   => 'Middle East',
	'asia'          => 'Asia',
);

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus( array(
		'primary'  => 'Primary',
		'footer-1' => 'Footer 1',
		'footer-2' => 'Footer 2',
		'legal'    => 'Legal',
	) );

	add_image_size( 'hero', 2000, 790, true );
	add_image_size( 'panel', 1600, 610, true );
	add_image_size( 'card', 1200, 675, true );
	add_image_size( 'portrait', 800, 1000, true );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parley-fonts', 'https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600&display=swap', array(), null );

	$version = wp_get_theme()->get( 'Version' );
	$previous = array( 'parley-fonts' );

	foreach ( PARLEY_STYLES as $sheet ) {
		$handle = 'parley-' . str_replace( '/', '-', $sheet );
		wp_enqueue_style( $handle, get_theme_file_uri( 'assets/css/' . $sheet . '.css' ), $previous, $version );
		$previous = array( $handle );
	}

	wp_enqueue_script( 'parley-navigation', get_theme_file_uri( 'assets/js/navigation.js' ), array(), $version, array( 'strategy' => 'defer' ) );

	if ( is_front_page() ) {
		wp_enqueue_script( 'parley-carousel', get_theme_file_uri( 'assets/js/carousel.js' ), array(), $version, array( 'strategy' => 'defer' ) );
	}
} );

add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) {
	if ( 'primary' === $args->theme_location ) {
		$atts['class'] = 'site-nav__link';
	}

	return $atts;
}, 10, 3 );

function parley_page_url( string $slug ): string {
	$page = get_page_by_path( $slug );

	return $page ? get_permalink( $page ) : home_url( '/' );
}

function parley_dispatches_url(): string {
	$page_id = (int) get_option( 'page_for_posts' );

	return $page_id ? get_permalink( $page_id ) : home_url( '/' );
}

function parley_region_label( string $key ): string {
	return PARLEY_REGIONS[ $key ] ?? $key;
}

function parley_initials( string $name ): string {
	$words = preg_split( '/\s+/', trim( $name ) );
	$first = mb_substr( $words[0] ?? '', 0, 1 );
	$last  = count( $words ) > 1 ? mb_substr( end( $words ), 0, 1 ) : '';

	return mb_strtoupper( $first . $last );
}

function parley_reading_time( WP_Post $post ): string {
	$words = str_word_count( wp_strip_all_tags( $post->post_content ) );

	return max( 1, (int) ceil( $words / 230 ) ) . ' min read';
}

function parley_lede( string $html ): string {
	$position = strpos( $html, '<p>' );

	return false === $position ? $html : substr_replace( $html, '<p class="lede">', $position, 3 );
}

function parley_meta( string $name, ?int $post_id = null ) {
	return get_post_meta( $post_id ?? get_the_ID(), $name, true );
}

function parley_cta_args( array $overrides = array() ): array {
	$defaults = array(
		'heading'      => get_option( 'cta_default_heading' ) ?: 'Something brewing?',
		'body'         => get_option( 'cta_default_body' ) ?: '',
		'button_label' => 'Talk to us',
		'button_url'   => parley_page_url( 'contact' ),
	);

	if ( is_singular() ) {
		foreach ( array( 'heading' => 'cta_heading', 'body' => 'cta_body', 'button_label' => 'cta_button_label', 'button_url' => 'cta_button_url' ) as $arg => $meta ) {
			$value = parley_meta( $meta );

			if ( $value ) {
				$defaults[ $arg ] = $value;
			}
		}
	}

	return array_merge( $defaults, array_filter( $overrides ) );
}

function parley_portrait( int $post_id, string $extra_class ): void {
	$name = get_the_title( $post_id );

	if ( has_post_thumbnail( $post_id ) ) {
		echo '<div class="portrait ' . esc_attr( $extra_class ) . '">';
		echo get_the_post_thumbnail( $post_id, 'portrait' );
		echo '</div>';

		return;
	}
	?>
	<div class="portrait <?php echo esc_attr( $extra_class ); ?>" role="img" aria-label="<?php echo esc_attr( 'Portrait placeholder for ' . $name ); ?>">
		<span class="portrait__initials" aria-hidden="true"><?php echo esc_html( parley_initials( $name ) ); ?></span>
	</div>
	<?php
}

add_action( 'admin_post_nopriv_parley_enquiry', 'parley_handle_enquiry' );
add_action( 'admin_post_parley_enquiry', 'parley_handle_enquiry' );

function parley_handle_enquiry(): void {
	$back = wp_get_referer() ?: parley_page_url( 'contact' );

	if ( ! isset( $_POST['parley_enquiry_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['parley_enquiry_nonce'] ) ), 'parley_enquiry' ) ) {
		wp_safe_redirect( $back );
		exit;
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', $back ) );
		exit;
	}

	$fields = array(
		'name'         => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
		'organisation' => sanitize_text_field( wp_unslash( $_POST['organisation'] ?? '' ) ),
		'email'        => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'phone'        => sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ),
		'topic'        => sanitize_text_field( wp_unslash( $_POST['topic'] ?? '' ) ),
		'referral'     => sanitize_text_field( wp_unslash( $_POST['referral'] ?? '' ) ),
		'message'      => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
		'consent'      => empty( $_POST['consent'] ) ? '' : 'yes',
	);

	if ( '' === $fields['name'] || '' === $fields['email'] || '' === $fields['message'] ) {
		wp_safe_redirect( $back );
		exit;
	}

	wp_insert_post( array(
		'meta_input'  => $fields,
		'post_status' => 'private',
		'post_title'  => $fields['name'] . ' — ' . wp_date( 'j F Y H:i' ),
		'post_type'   => 'enquiry',
	) );

	wp_safe_redirect( add_query_arg( 'sent', '1', $back ) );
	exit;
}
