<?php
/**
 * Template part for displaying posts
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package agami_2021
 */

	if (!is_front_page()) :
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
	endif;
	?>

	<?php agami_2021_post_thumbnail(); ?>

	<?php the_content(); ?>

	<?php agami_2021_entry_footer(); ?>
