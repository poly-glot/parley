<?php
$members = $args['posts'] ?? array();
?>
<ul class="team-grid__list container" role="list">
	<?php foreach ( $members as $member ) : ?>
		<li class="team-card">
			<h2 class="team-card__name"><a href="<?php echo esc_url( get_permalink( $member ) ); ?>"><?php echo esc_html( get_the_title( $member ) ); ?></a></h2>
			<p class="team-card__role"><?php echo esc_html( parley_meta( 'role', $member->ID ) ); ?></p>

			<?php parley_portrait( $member->ID, 'team-card__portrait' ); ?>
		</li>
	<?php endforeach; ?>
</ul>
