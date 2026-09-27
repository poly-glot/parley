<?php
$front_id = (int) get_option( 'page_on_front' );
$line_1   = parley_meta( 'hero_line_1', $front_id );
$line_2   = parley_meta( 'hero_line_2', $front_id );
?>
<section class="home-hero" aria-labelledby="home-hero-title">
	<?php echo get_the_post_thumbnail( $front_id, 'hero', array( 'class' => 'home-hero__image', 'alt' => '', 'fetchpriority' => 'high' ) ); ?>
	<div class="home-hero__inner container">
		<h1 class="home-hero__title" id="home-hero-title">
			<span class="home-hero__line"><?php echo esc_html( $line_1 ); ?></span>
			<span class="home-hero__line"><?php echo esc_html( $line_2 ); ?></span>
		</h1>
		<div class="home-hero__actions">
			<a class="button button--light" href="<?php echo esc_url( parley_page_url( 'about' ) ); ?>">About us</a>
			<a class="button button--white" href="<?php echo esc_url( parley_page_url( 'contact' ) ); ?>">Start a conversation</a>
		</div>
	</div>
</section>
