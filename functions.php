<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

/*************************************/


// Add Quicktags
function custom_quicktags() {

	if ( wp_script_is( 'quicktags' ) ) {
	?>
	<script type="text/javascript">
	//QTags.addButton( 'ed', 'ed', '<ed>', '</ed>', '', 'ED', 111 );
	</script>
	<?php
	}

}
add_action( 'admin_print_footer_scripts', 'custom_quicktags' );



/**
 * Archive sort order
 */ 
add_action( 'pre_get_posts', 'archive_sort_order_cb'); 
function archive_sort_order_cb($query){
	if(is_post_type_archive()){
		switch ( get_queried_object () ){
			case 'fournisseur' :
		       $query->set( 'order', 'DESC' );
		       $query->set( 'orderby', 'modified' );
		       break;
    	}
	}
};