<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foxiz_file_paths = array(

	'templates/template-helpers',
	'templates/parts',
	'templates/entry',
	'templates/popup',
	'templates/blog',
	'templates/page',
	'templates/ajax',

	'templates/header/templates',
	'templates/header/layouts',
	'templates/header/transparent',
	'templates/footer',

	/** single */
	'templates/single/templates',
	'templates/single/reviews',
	'templates/single/layouts',
	'templates/single/footer',
	'templates/single/related',
	'templates/single/custom-post-type',
	'templates/single/standard-1',
	'templates/single/standard-2',
	'templates/single/standard-3',
	'templates/single/standard-4',
	'templates/single/standard-5',
	'templates/single/standard-6',
	'templates/single/standard-7',
	'templates/single/standard-8',
	'templates/single/standard-9',
	'templates/single/video-1',
	'templates/single/video-2',
	'templates/single/video-3',
	'templates/single/video-4',
	'templates/single/audio-1',
	'templates/single/audio-2',
	'templates/single/audio-3',
	'templates/single/audio-4',
	'templates/single/gallery-1',
	'templates/single/gallery-2',
	'templates/single/gallery-3',

	/** module */
	'templates/modules/classic',
	'templates/modules/grid',
	'templates/modules/list',
	'templates/modules/overlay',
	'templates/modules/category',
	'templates/modules/author',

	/** blocks */
	'templates/blocks/heading',
	'templates/blocks/classic-1',
	'templates/blocks/grid-1',
	'templates/blocks/grid-2',
	'templates/blocks/grid-small-1',
	'templates/blocks/grid-box-1',
	'templates/blocks/grid-box-2',
	'templates/blocks/grid-flex-1',
	'templates/blocks/grid-flex-2',
	'templates/blocks/grid-recommended-1',
	'templates/blocks/grid-recommended-2',
	'templates/blocks/list-1',
	'templates/blocks/list-2',
	'templates/blocks/list-box-1',
	'templates/blocks/list-box-2',
	'templates/blocks/list-small-1',
	'templates/blocks/list-small-2',
	'templates/blocks/list-small-3',
	'templates/blocks/hierarchical-1',
	'templates/blocks/hierarchical-2',
	'templates/blocks/hierarchical-3',
	'templates/blocks/overlay-1',
	'templates/blocks/overlay-2',
	'templates/blocks/playlist',
	'templates/blocks/quick-links',
	'templates/blocks/breaking-news',
	'templates/blocks/categories',
	'templates/blocks/authors',
	'templates/blocks/newsletter'
);

/**
 * load file templates
 */
foreach ( $foxiz_file_paths as $foxiz_path ) {
	$foxiz_file = get_theme_file_path( $foxiz_path . '.php' );
	if ( file_exists( $foxiz_file ) ) {
		include_once $foxiz_file;
	}
}
