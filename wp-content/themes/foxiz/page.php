<?php
/** The template for displaying single page */
get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$document = false;
		if ( class_exists( 'Elementor\Plugin' ) ) {
			$document = Elementor\Plugin::$instance->documents->get( get_the_ID() );
		}
		if ( $document && $document->is_built_with_elementor() ) {
			the_content();
		} else {
			foxiz_single_page();
		}
	endwhile;
endif;

/** get footer */
get_footer();