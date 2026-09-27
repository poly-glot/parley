<?php
get_header();

get_template_part( 'template-parts/hero-page', null, array(
	'subtitle' => 'Small by design. Senior by default.',
	'title'    => 'Our team',
	'variant'  => 'brand',
) );
?>
<section class="statement container container--narrow" aria-label="About our team">
	<p class="statement__text">
		We’ve been foreign correspondents, parliamentary researchers, campaigners and designers. Now we do it for our clients.
	</p>
	<p class="statement__support">
		Between us we’ve worked in more than 30 countries and speak seven languages. Whoever you meet at Parley is someone
		who’ll be working on your account.
	</p>
</section>

<section class="team-grid section section--paper" aria-label="Team members">
	<?php
	get_template_part( 'template-parts/loop-team', null, array(
		'posts' => get_posts( array(
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_type'      => 'team_member',
			'posts_per_page' => -1,
		) ),
	) );
	?>
</section>
<?php
get_template_part( 'template-parts/cta-band', null, array(
	'body'         => 'We hire rarely and carefully. If you’re a journalist, campaigner, strategist or designer who wants to do serious work for clients who need it, we’d like to hear from you, even if we’re not advertising a role.',
	'button_label' => 'Send us your CV',
	'button_url'   => 'mailto:' . get_option( 'careers_email' ),
	'heading'      => 'Work with us',
) );
get_footer();
