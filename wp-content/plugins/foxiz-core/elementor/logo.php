<?php

namespace foxizElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class
 * @package foxizElementor\Widgets
 */
class Logo extends Widget_Base {

	public function get_name() {

		return 'foxiz-logo';
	}

	public function get_title() {

		return esc_html__( 'Foxiz - Site Logo', 'foxiz-core' );
	}

	public function get_icon() {

		return 'eicon-header';
	}

	public function get_categories() {

		return array( 'foxiz_header' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'general', array(
				'label' => esc_html__( 'Logo Settings', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'logo',
			array(
				'label'       => esc_html__( 'Logo Image', 'foxiz-core' ),
				'description' => esc_html__( 'Select or upload a logo image.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->add_control(
			'dark_logo',
			array(
				'label'       => esc_html__( 'Dark Mode - Logo Image', 'foxiz-core' ),
				'description' => esc_html__( 'Select or upload a logo image in the dark mode.', 'foxiz-core' ),
				'type'        => Controls_Manager::MEDIA
			)
		);
		$this->add_control(
			'logo_link',
			array(
				'label'       => esc_html__( 'Custom Logo URL', 'foxiz-core' ),
				'description' => esc_html__( 'Input a custom URL for the logo, Default will return to the homepage.', 'foxiz-core' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url'               => '',
					'is_external'       => false,
					'nofollow'          => false,
					'custom_attributes' => '',
				),
				'label_block' => true,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'logo-style-section', array(
				'label' => esc_html__( 'Styles', 'foxiz-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'logo_width', array(
				'label'       => __( 'Logo Width', 'foxiz-core' ),
				'description' => esc_html__( 'Set a max width for your logo', 'foxiz-core' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 800,
					),
				),
				'selectors'   => array( '{{WRAPPER}} .the-logo img' => 'max-width: {{SIZE}}px; width: {{SIZE}}px' )
			)
		);
		$this->add_responsive_control(
			'align', array(
				'label'     => esc_html__( 'Alignment', 'foxiz-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'foxiz-core' ),
						'icon'  => 'eicon-align-start-h',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'foxiz-core' ),
						'icon'  => 'eicon-align-center-h',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'foxiz-core' ),
						'icon'  => 'eicon-align-end-h',
					),
				),
				'selectors' => array( '{{WRAPPER}} .the-logo' => 'text-align: {{VALUE}};', ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * render layout
	 */
	protected function render() {

		$settings = $this->get_settings();
		if ( empty( $settings['logo']['url'] ) ) {
			return false;
		}
		if ( empty( $settings['logo_link']['url'] ) ) {
			$settings['logo_link']['url'] = home_url( '/' );
		}
		$this->add_link_attributes( 'logo_link', $settings['logo_link'] );
		?>
        <div class="the-logo">
            <a <?php echo $this->get_render_attribute_string( 'logo_link' ); ?>>
				<?php if ( ! empty( $settings['dark_logo']['url'] ) ) : ?>
                    <img data-mode="default" src="<?php echo $settings['logo']['url']; ?>" alt="<?php echo ( ! empty( $settings['logo']['alt'] ) ) ? esc_attr( $settings['logo']['alt'] ) : ''; ?>">
                    <img data-mode="dark" src="<?php echo $settings['dark_logo']['url']; ?>" alt="<?php echo ( ! empty( $settings['dark_logo']['alt'] ) ) ? esc_attr( $settings['dark_logo']['alt'] ) : ''; ?>">
				<?php else : ?>
                    <img src="<?php echo $settings['logo']['url']; ?>" alt="<?php echo ( ! empty( $settings['logo']['alt'] ) ) ? esc_attr( $settings['logo']['alt'] ) : ''; ?>">
				<?php endif; ?>
            </a>
        </div>
		<?php
	}
}