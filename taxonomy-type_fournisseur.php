<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<?php if ( have_posts() ) : ?>
		<header class="page-header taxonomy-type_fournisseur">
			<?php
				//the_archive_title( '<h1 class="page-title">', '</h1>' );
				//the_archive_description( '<div class="taxonomy-description">', '</div>' );
			    $term = get_queried_object();
		        if ( $term ) {

					$taxonomy_name = $term->taxonomy;

		            /* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term. */
		            $title = single_term_title( '', false );

					echo sprintf('<h1 class="page-title">%s</h1>', $title );
					$termchildren = get_term_children( $term->term_id, $taxonomy_name );
					 
					echo '<ul class="children-terms">';

		            if($term->parent){
					    $parent_term = get_term_by( 'id', $term->parent, $taxonomy_name );
					    echo sprintf('<li><a href="%s" class="goto-parent dashicons-before dashicons-arrow-left">%s</a></li>', get_term_link( $term->parent, $taxonomy_name ), $parent_term->name);
					}
					else {
					    echo sprintf('<li><a href="%s/fournisseur/" class="goto-parent dashicons-before dashicons-arrow-left">%s</a></li>',get_site_url(), __('All'));
					}

					foreach ( $termchildren as $child ) {
					    $child_term = get_term_by( 'id', $child, $taxonomy_name );
					    echo '<li><a href="' . get_term_link( $child, $taxonomy_name ) . '">' . $child_term->name . '</a></li>';
					}
					echo '</ul>';
		            
		        }
			?>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :
			?>
			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that
				 * will be used instead.
				 */
				get_template_part( 'template-parts/post/content', 'excerpt' );

			endwhile;

			the_posts_pagination(
				array(
					'prev_text'          => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
				)
			);

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php
get_footer();
