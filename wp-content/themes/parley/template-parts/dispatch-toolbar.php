<div class="dispatch-toolbar">
	<nav aria-label="Dispatch categories">
		<ul class="dispatch-toolbar__filters">
			<li>
				<a class="dispatch-toolbar__filter" href="<?php echo esc_url( parley_dispatches_url() ); ?>"<?php echo is_home() ? ' aria-current="page"' : ''; ?>>All</a>
			</li>
			<?php foreach ( get_categories( array( 'hide_empty' => true ) ) as $category ) : ?>
				<li>
					<a class="dispatch-toolbar__filter" href="<?php echo esc_url( get_category_link( $category ) ); ?>"<?php echo is_category( $category->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $category->name ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
	<form class="dispatch-toolbar__search" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<label class="visually-hidden" for="dispatch-search">Search Dispatches</label>
		<svg class="icon dispatch-toolbar__search-icon" aria-hidden="true" focusable="false">
			<use href="#icon-search" />
		</svg>
		<input
			class="dispatch-toolbar__input"
			id="dispatch-search"
			name="s"
			type="search"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="What are you looking for?"
		/>
		<button class="visually-hidden" type="submit">Search</button>
	</form>
</div>
