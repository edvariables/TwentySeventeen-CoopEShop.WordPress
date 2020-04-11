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
		<header class="page-header archive-fournisseurs">
			<?php
		            $title = __("Tous les fournisseurs", 'coopeshop');
		            echo sprintf('<h1 class="page-title">%s</h1>', $title );

		            //Search form
					get_template_part( 'searchform', 'fournisseur' );

		            //Arbre des types de fournisseurs

					/**
					** this function is rendering terms RECURSIVELY
					**/
					function render_term_tree($termid, $taxonomy){

						$single_term = get_term($termid, $taxonomy);

					    echo '<li><a href="' . get_term_link( $termid, $taxonomy ) . '">' . $single_term->name . '</a>';

						$childrens = get_term_children($termid, $taxonomy);
						if($childrens){

							//pa_postfront($childrens);
							echo '<ul>';
							foreach ($childrens as $term_child) {

								//recursive call if children found
								render_term_tree($term_child, $taxonomy);					
							}
						echo "</ul>";	
						}
						'</li>';
					}

		            $taxonomy = 'type_fournisseur';
					//set these options as you required
					$terms_args = array( 
							'hide_empty'	=> false, 
							'parent'      	=> 0, );
							
					//now pulling terms against each taxonomy
					$terms = get_terms($taxonomy, $terms_args);
					if($terms){
						echo '<div class="taxonomy-type_fournisseur">';
						echo '<ul class="children-terms">';
						foreach ($terms as $term) {
							//defined below, this function will render the terms and li recursively
							render_term_tree($term->term_id, $taxonomy);					
						}
						echo "</ul></div>";
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
