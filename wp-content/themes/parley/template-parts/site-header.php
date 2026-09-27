<header class="site-header">
	<div class="site-header__inner container">
		<a class="logo logo--light" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', home' ); ?>">
			<span class="logo__light" aria-hidden="true">PAR</span>
			<span class="logo__rule" aria-hidden="true"></span>
			<span class="logo__bold" aria-hidden="true">LEY</span>
		</a>
		<nav class="site-nav" aria-label="Primary">
			<button class="site-nav__toggle" type="button" aria-expanded="false" aria-controls="site-nav-list" hidden>
				<svg class="icon site-nav__open-icon" aria-hidden="true" focusable="false"><use href="#icon-menu" /></svg
				><svg class="icon site-nav__close-icon" aria-hidden="true" focusable="false"><use href="#icon-close" /></svg>
				<span class="visually-hidden">Menu</span>
			</button>
			<?php
			wp_nav_menu( array(
				'container'      => false,
				'fallback_cb'    => false,
				'menu_class'     => 'site-nav__list',
				'menu_id'        => 'site-nav-list',
				'theme_location' => 'primary',
			) );
			?>
		</nav>
		<ul class="site-header__tools">
			<?php foreach ( (array) get_option( 'social' ) as $social ) : ?>
				<li>
					<a class="site-header__icon-link" href="<?php echo esc_url( $social['url'] ?? '' ); ?>" rel="noopener">
						<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-<?php echo esc_attr( $social['icon'] ?? '' ); ?>" /></svg>
						<span class="visually-hidden"><?php echo esc_html( $social['label'] ?? '' ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
			<li>
				<a class="site-header__icon-link" href="<?php echo esc_url( parley_dispatches_url() . '#dispatch-search' ); ?>">
					<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-search" /></svg>
					<span class="visually-hidden">Search Dispatches</span>
				</a>
			</li>
		</ul>
	</div>
</header>
