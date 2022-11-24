<?php
if ( ! function_exists( 'foxiz_register_options_general' ) ) {
	/**
	 * @return array
	 * general settings
	 */
	function foxiz_register_options_general() {

		return array(
			'id'     => 'foxiz_config_section_general',
			'title'  => esc_html__( 'General', 'foxiz' ),
			'desc'   => esc_html__( 'General settings for your website.', 'foxiz' ),
			'icon'   => 'el el-icon-globe',
			'fields' => array(
				array(
					'id'       => 'site_tooltips',
					'type'     => 'switch',
					'title'    => esc_html__( 'Tooltips', 'foxiz' ),
					'subtitle' => esc_html__( 'Enable or disable tooltips when hovering on icons.', 'foxiz' ),
					'switch'   => true,
					'default'  => 1
				),
				array(
					'id'          => 'back_top',
					'type'        => 'switch',
					'title'       => esc_html__( 'Back to Top', 'foxiz' ),
					'subtitle'    => esc_html__( 'Enable or disable the back to top button.', 'foxiz' ),
					'description' => esc_html__( 'The back to top will be invisible on the mobile because it is not helpful.', 'foxiz' ),
					'switch'      => true,
					'default'     => 1
				),
				array(
					'id'          => 'search_placeholder',
					'type'        => 'textarea',
					'rows'        => 2,
					'title'       => esc_html__( 'Global Search Placeholder', 'foxiz' ),
					'subtitle'    => esc_html__( 'Input default placeholder text for the search form, leave blank to set it as the default.', 'foxiz' ),
					'placeholder' => esc_html__( 'Search Headlines, News...', 'foxiz' ),
				)
			)
		);
	}
}

/** backup & restore theme options */
if ( ! function_exists( 'foxiz_register_options_backup' ) ) {
	function foxiz_register_options_backup() {

		return array(
			'id'     => 'foxiz_config_section_backup',
			'title'  => esc_html__( 'Restore/Backup', 'foxiz' ),
			'desc'   => esc_html__( 'Backup all your settings to a file or restore your settings.', 'foxiz' ),
			'icon'   => 'el el-inbox',
			'fields' => array(
				array(
					'id'         => 'ruby-import-export',
					'type'       => 'import_export',
					'title'      => esc_html__( 'Restore/Backup Theme Options', 'foxiz' ),
					'subtitle'   => esc_html__( 'We recommend you should create a backup before updating or major changes.', 'foxiz' ),
					'full_width' => false,
				)
			)
		);
	}
}
