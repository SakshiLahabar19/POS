<?php
/*/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_register_options_membership' ) ) {
	/**
	 * @return array
	 */
	function foxiz_register_options_membership() {

		if ( ! class_exists( 'SimpleWpMembership' ) ) {
			return array(
				'id'     => 'foxiz_config_section_membership',
				'title'  => esc_html__( 'Membership', 'foxiz-core' ),
				'desc'   => esc_html__( 'Select options for the membership plugin.', 'foxiz-core' ),
				'icon'   => 'el el-group',
				'fields' => array(
					array(
						'id'    => 'membership_info_warning',
						'type'  => 'info',
						'desc'  => esc_html__( 'Simple WordPress Membership Plugin is missing!', 'foxiz-core' ),
						'style' => 'warning',
					),
					array(
						'id'    => 'membership_install_warning',
						'type'  => 'info',
						'style' => 'warning',
						'desc'  => html_entity_decode( esc_html__( 'Please install <a href=\'https://wordpress.org/plugins/simple-membership/\'>Simple WordPress Membership</a> plugin to enable the theme features.', 'foxiz-core' ) ),
					),
				)
			);
		}

		return array(
			'id'     => 'foxiz_config_section_membership',
			'title'  => esc_html__( 'Membership', 'foxiz-core' ),
			'desc'   => esc_html__( 'Select options for Simple WordPress Membership plugin.', 'foxiz-core' ),
			'icon'   => 'el el-group',
			'fields' => array(
				array(
					'id'     => 'section_start_restrict_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Content Restrict for New Users', 'foxiz-core' ),
					'indent' => true
				),
				array(
					'id'       => 'restrict_title',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Restrict Content Title', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your restrict content title, allow raw HTML.', 'foxiz-core' ),
					'default'  => '<strong>Unlimited digital access</strong> to all our <span>Premium</span> contents'
				),
				array(
					'id'       => 'restrict_desc',
					'type'     => 'textarea',
					'rows'     => 3,
					'title'    => esc_html__( 'Restrict Content Description', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your restrict content description, allow raw HTML.', 'foxiz-core' ),
					'default'  => 'Plans starting at less than $9/month. <strong>Cancel anytime.</strong>'
				),
				array(
					'id'       => 'join_us_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Join US Button Label', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input a join us button label.', 'foxiz-core' ),
					'default'  => esc_html__( 'Get Digital All Access', 'foxiz-core' )
				),
				array(
					'id'       => 'login_desc',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Login Description', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your login description.', 'foxiz-core' ),
					'default'  => esc_html__( 'Already a subscriber?', 'foxiz-core' )
				),
				array(
					'id'       => 'login_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Login Button Label', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input the login button label.', 'foxiz-core' ),
					'default'  => esc_html__( 'Sign In', 'foxiz-core' ),
				),
				array(
					'id'     => 'section_end_restrict_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_restrict_level_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Content Restrict for Logged Users', 'foxiz-core' ),
					'indent' => true
				),
				array(
					'id'       => 'restrict_level_title',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Upgrade Membership Title', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your upgrade membership level title, allow raw HTML.', 'foxiz-core' ),
					'default'  => '<strong>Upgrade Your Plan</strong> for even <span>Greater</span> benefits.'
				),
				array(
					'id'       => 'restrict_level_desc',
					'type'     => 'textarea',
					'rows'     => 2,
					'title'    => esc_html__( 'Upgrade Membership Description', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your upgrade membership level description, allow raw HTML.', 'foxiz-core' ),
					'default'  => 'This content is not permitted for your membership level.'
				),
				array(
					'id'     => 'section_end_restrict_level_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),
				array(
					'id'     => 'section_start_restrict_renewal_box',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Content Restrict for Expired Users', 'foxiz-core' ),
					'indent' => true
				),
				array(
					'id'       => 'restrict_renewal_title',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Renewal Membership Title', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your renewal membership title, allow raw HTML.', 'foxiz-core' ),
					'default'  => '<strong>Renew account</strong> to access <span>Premium</span> contents'
				),
				array(
					'id'       => 'restrict_renewal_desc',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Renewal Membership Description', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input your renewal membership description, allow raw HTML.', 'foxiz-core' ),
					'default'  => 'Your membership plan has expired.'
				),
				array(
					'id'       => 'renewal_label',
					'type'     => 'text',
					'title'    => esc_html__( 'Renewal Button Label', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Input a renewal button label.', 'foxiz-core' ),
					'default'  => esc_html__( 'Renewal Your MemberShip', 'foxiz-core' ),
				),
				array(
					'id'     => 'section_end_restrict_renewal_box',
					'type'   => 'section',
					'class'  => 'ruby-section-end',
					'indent' => false
				),

				array(
					'id'     => 'section_start_protected_title',
					'type'   => 'section',
					'class'  => 'ruby-section-start',
					'title'  => esc_html__( 'Exclusive Label', 'foxiz-core' ),
					'indent' => true
				),
				array(
					'id'          => 'exclusive_label',
					'type'        => 'text',
					'title'       => esc_html__( 'Member Only Label', 'foxiz-core' ),
					'subtitle'    => esc_html__( 'Input a Label for displaying before the post title listing.', 'foxiz-core' ),
					'description' => esc_html__( 'Leave blank to disable the label.', 'foxiz-core' ),
					'default'     => 'EXCLUSIVE',
				),
				array(
					'id'       => 'exclusive_style',
					'type'     => 'select',
					'title'    => esc_html__( 'Label Style', 'foxiz-core' ),
					'subtitle' => esc_html__( 'Select a style for the member only label.', 'foxiz-core' ),
					'options'  => array(
						'0'      => esc_html__( 'Background Color', 'foxiz' ),
						'border' => esc_html__( 'Border', 'foxiz' ),
						'text'   => esc_html__( 'Text with Color', 'foxiz' )
					),
					'default'  => '0'
				),
				array(
					'id'     => 'section_end_restrict_protected_title',
					'type'   => 'section',
					'class'  => 'ruby-section-end no-border',
					'indent' => false
				),
			)
		);
	}
}
