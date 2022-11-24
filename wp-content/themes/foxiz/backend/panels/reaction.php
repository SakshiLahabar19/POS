<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_reaction' ) ) {
	/**
	 * @return array
	 * reaction settings
	 */
	function foxiz_register_options_reaction() {

		return array(
			'id'     => 'foxiz_theme_ops_section_reaction',
			'title'  => esc_html__( 'User Reaction', 'foxiz' ),
			'desc'   => esc_html__( 'Select options for the reaction section.', 'foxiz' ),
			'icon'   => 'el el-smiley',
			'fields' => array(
				array(
					'id'       => 'single_post_reaction',
					'type'     => 'switch',
					'title'    => esc_html__( 'Reaction Section', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable the reaction section at the end of single post pages.', 'foxiz' ),
					'switch'   => true,
					'default'  => '0'
				),
				array(
					'id'       => 'single_post_reaction_title',
					'type'     => 'text',
					'title'    => esc_html__( 'Reaction Heading', 'foxiz' ),
					'subtitle' => esc_html__( 'Input a title for the reaction section. Leave blank to set it as the default.', 'foxiz' ),
					'default'  => ''
				),
				array(
					'id'       => 'reaction_items',
					'title'    => esc_html__( 'Reaction Items', 'foxiz' ),
					'subtitle' => esc_html__( 'Select reaction items you would like to show.', 'foxiz' ),
					'type'     => 'sorter',
					'options'  => array(
						'enabled'  => array(
							'love'   => esc_html__( 'Love', 'foxiz' ),
							'sad'    => esc_html__( 'Sad', 'foxiz' ),
							'happy'  => esc_html__( 'Happy', 'foxiz' ),
							'sleepy' => esc_html__( 'Sleepy', 'foxiz' ),
							'angry'  => esc_html__( 'Angry', 'foxiz' ),
							'dead'   => esc_html__( 'Dead', 'foxiz' ),
							'wink'   => esc_html__( 'Wink', 'foxiz' )
						),
						'disabled' => array(
							'cry'       => esc_html__( 'Cry', 'foxiz' ),
							'embarrass' => esc_html__( 'Embarrass', 'foxiz' ),
							'joy'       => esc_html__( 'Joy', 'foxiz' ),
							'shy'       => esc_html__( 'Shy', 'foxiz' ),
							'surprise'  => esc_html__( 'Surprise', 'foxiz' )
						)
					),
				)
			)
		);
	}
}



