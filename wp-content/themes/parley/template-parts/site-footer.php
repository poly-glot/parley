<footer class="site-footer">
	<div class="site-footer__inner container">
		<div class="site-footer__brand">
			<a class="logo logo--dark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', home' ); ?>">
				<span class="logo__light" aria-hidden="true">PAR</span>
				<span class="logo__rule" aria-hidden="true"></span>
				<span class="logo__bold" aria-hidden="true">LEY</span>
			</a>
			<address class="site-footer__address">
				<?php echo wp_kses_post( nl2br( esc_html( (string) get_option( 'address' ) ) ) ); ?>
				<br />
				<a href="<?php echo esc_url( 'tel:' . get_option( 'phone_href' ) ); ?>"><?php echo esc_html( (string) get_option( 'phone' ) ); ?></a>
				<br />
				<a href="<?php echo esc_url( 'mailto:' . get_option( 'email' ) ); ?>"><?php echo esc_html( (string) get_option( 'email' ) ); ?></a>
			</address>
		</div>
		<nav class="site-footer__nav" aria-label="Footer">
			<?php
			wp_nav_menu( array(
				'container'      => false,
				'fallback_cb'    => false,
				'menu_class'     => 'site-footer__links',
				'theme_location' => 'footer-1',
			) );
			wp_nav_menu( array(
				'container'      => false,
				'fallback_cb'    => false,
				'menu_class'     => 'site-footer__links',
				'theme_location' => 'footer-2',
			) );
			?>
			<ul class="site-footer__social">
				<?php foreach ( (array) get_option( 'social' ) as $social ) : ?>
					<li>
						<a class="site-footer__social-link" href="<?php echo esc_url( $social['url'] ?? '' ); ?>" rel="noopener">
							<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-<?php echo esc_attr( $social['icon'] ?? '' ); ?>" /></svg>
							<span class="visually-hidden"><?php echo esc_html( $social['label'] ?? '' ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<form class="newsletter" action="#" method="post">
			<h2 class="newsletter__title" id="newsletter-title">The Parley Brief</h2>
			<p class="newsletter__text" id="newsletter-text">One email a month. What moved, what it means, what to do about it.</p>
			<div class="newsletter__row">
				<label class="visually-hidden" for="newsletter-email">Your email address</label>
				<input
					class="newsletter__input"
					id="newsletter-email"
					name="email"
					type="email"
					autocomplete="email"
					placeholder="Your email address"
					required
					aria-describedby="newsletter-text"
				/>
				<button class="newsletter__button" type="submit">Subscribe</button>
			</div>
		</form>
	</div>
	<div class="site-footer__legal container">
		<p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( (string) get_option( 'legal_name' ) ); ?>. Registered in England and Wales, no. <?php echo esc_html( (string) get_option( 'company_number' ) ); ?>.</p>
		<?php
		wp_nav_menu( array(
			'container'      => false,
			'fallback_cb'    => false,
			'menu_class'     => 'site-footer__legal-links',
			'theme_location' => 'legal',
		) );
		?>
	</div>
</footer>
