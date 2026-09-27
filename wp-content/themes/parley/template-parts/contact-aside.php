<aside class="contact-aside" aria-label="Other ways to reach us">
	<section class="contact-aside__urgent" aria-labelledby="urgent-title">
		<h2 class="contact-aside__urgent-title" id="urgent-title">Facing a crisis right now?</h2>
		<p>Call our 24-hour line. A senior member of the team will pick up.</p>
		<a class="contact-aside__phone" href="<?php echo esc_url( 'tel:' . get_option( 'phone_href' ) ); ?>">
			<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-phone" /></svg>
			<?php echo esc_html( (string) get_option( 'phone' ) ); ?>
		</a>
	</section>
	<section class="contact-aside__office" aria-labelledby="office-title">
		<h2 class="contact-aside__title" id="office-title">Our office</h2>
		<address>
			<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
			<br />
			<?php echo wp_kses_post( nl2br( esc_html( (string) get_option( 'address' ) ) ) ); ?>
		</address>
		<dl class="contact-aside__list">
			<div>
				<dt>General</dt>
				<dd><a href="<?php echo esc_url( 'mailto:' . get_option( 'email' ) ); ?>"><?php echo esc_html( (string) get_option( 'email' ) ); ?></a></dd>
			</div>
			<div>
				<dt>Press</dt>
				<dd><a href="<?php echo esc_url( 'mailto:' . get_option( 'press_email' ) ); ?>"><?php echo esc_html( (string) get_option( 'press_email' ) ); ?></a></dd>
			</div>
			<div>
				<dt>Careers</dt>
				<dd><a href="<?php echo esc_url( 'mailto:' . get_option( 'careers_email' ) ); ?>"><?php echo esc_html( (string) get_option( 'careers_email' ) ); ?></a></dd>
			</div>
		</dl>
		<p class="contact-aside__transport">Nearest stations: Holborn and Chancery Lane.</p>
	</section>
</aside>
