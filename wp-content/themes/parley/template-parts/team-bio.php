<?php
$name      = get_the_title();
$linkedin  = (string) parley_meta( 'linkedin' );
$x_url     = (string) parley_meta( 'x' );
$email     = (string) parley_meta( 'email' );
$languages = (string) parley_meta( 'languages' );
?>
<article class="bio container" aria-labelledby="bio-name">
	<div class="bio__aside">
		<?php parley_portrait( get_the_ID(), 'bio__portrait' ); ?>
		<ul class="bio__links">
			<?php if ( $linkedin ) : ?>
				<li>
					<a href="<?php echo esc_url( $linkedin ); ?>" rel="noopener">
						<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-linkedin" /></svg>
						<span class="visually-hidden"><?php echo esc_html( $name ); ?> on LinkedIn</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $x_url ) : ?>
				<li>
					<a href="<?php echo esc_url( $x_url ); ?>" rel="noopener">
						<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-x" /></svg>
						<span class="visually-hidden"><?php echo esc_html( $name ); ?> on X</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<li>
					<a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
						<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-mail" /></svg>
						<span class="visually-hidden">Email <?php echo esc_html( $name ); ?></span>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<div class="bio__body">
		<h1 class="bio__name" id="bio-name"><?php echo esc_html( $name ); ?></h1>
		<p class="bio__role">
			<?php echo esc_html( parley_meta( 'role' ) ); ?>
			<?php if ( $languages ) : ?>
				<span aria-hidden="true">·</span>
				<span class="bio__languages">Speaks <?php echo esc_html( $languages ); ?></span>
			<?php endif; ?>
		</p>
		<p class="bio__lead"><?php echo esc_html( parley_meta( 'lead' ) ); ?></p>
		<div class="prose bio__text">
			<?php the_content(); ?>
		</div>
		<a class="button" href="<?php echo esc_url( get_post_type_archive_link( 'team_member' ) ); ?>">
			<svg class="icon button__icon" aria-hidden="true" focusable="false"><use href="#icon-arrowLeft" /></svg>
			Back to the team
		</a>
	</div>
</article>
