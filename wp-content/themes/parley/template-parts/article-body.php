<?php
$author_id   = (int) parley_meta( 'author_profile' );
$author      = $author_id ? get_post( $author_id ) : null;
$author_name = $author ? get_the_title( $author ) : '';
$category    = get_the_category()[0] ?? null;
$share_url   = rawurlencode( get_permalink() );
$share_title = rawurlencode( get_the_title() );
?>
<article class="article" aria-labelledby="article-title">
	<?php if ( has_post_thumbnail() ) : ?>
		<?php the_post_thumbnail( 'card', array( 'class' => 'article__hero' ) ); ?>
	<?php endif; ?>
	<div class="article__layout container">
		<header class="article__header">
			<?php if ( $category ) : ?>
				<p class="article__category"><?php echo esc_html( $category->name ); ?></p>
			<?php endif; ?>
			<h1 class="article__title" id="article-title"><?php the_title(); ?></h1>

			<?php if ( $author ) : ?>
				<div class="article__byline">
					<span class="article__avatar" aria-hidden="true"><?php echo esc_html( parley_initials( $author_name ) ); ?></span>
					<p>
						<a href="<?php echo esc_url( get_permalink( $author ) ); ?>"><?php echo esc_html( $author_name ); ?></a>
						<br />
						<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
						<span aria-hidden="true">·</span>
						<?php echo esc_html( parley_reading_time( get_post() ) ); ?>
					</p>
				</div>
			<?php endif; ?>
		</header>

		<h2 class="visually-hidden" id="share-title">Share this dispatch</h2>
		<ul class="article__share" aria-labelledby="share-title">
			<li>
				<a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url ); ?>" rel="noopener">
					<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-linkedin" /></svg>
					<span class="visually-hidden">Share on LinkedIn</span>
				</a>
			</li>
			<li>
				<a href="<?php echo esc_url( 'https://x.com/intent/post?url=' . $share_url . '&text=' . $share_title ); ?>" rel="noopener">
					<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-x" /></svg>
					<span class="visually-hidden">Share on X</span>
				</a>
			</li>
			<li>
				<a href="<?php echo esc_url( 'mailto:?subject=' . $share_title . '&body=' . $share_url ); ?>">
					<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-mail" /></svg>
					<span class="visually-hidden">Share by email</span>
				</a>
			</li>
		</ul>
		<div class="article__body prose">
			<?php the_content(); ?>
		</div>
		<?php if ( $author ) : ?>
			<footer class="article__author">
				<p>
					<strong><?php echo esc_html( $author_name ); ?></strong>
					is <?php echo esc_html( parley_meta( 'role', $author->ID ) ); ?> at <?php echo esc_html( get_bloginfo( 'name' ) ); ?>.
					<a href="<?php echo esc_url( get_permalink( $author ) ); ?>">More about <?php echo esc_html( explode( ' ', $author_name )[0] ); ?></a>
				</p>
			</footer>
		<?php endif; ?>
	</div>
</article>
