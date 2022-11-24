<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'foxiz_get_quick_links' ) ) {
	/**
	 * @param array $settings
	 *
	 * @return false|string
	 */
	function foxiz_get_quick_links( $settings = array() ) {

		$settings = wp_parse_args( $settings, array(
			'uuid'        => '',
			'name'        => 'quick-links',
			'header'      => '',
			'quick_links' => array(),
			'layout'      => '1',
            'hover_effect' => 'underline'
		) );

		$settings['classes'] = 'block-qlinks qlinks-layout-' . esc_attr( $settings['layout'] );
		if ( '1' == $settings['layout'] ) {
			$settings['classes'] .= ' qlinks-' . $settings['hover_effect'];
		}

		ob_start();
		foxiz_block_open_tag( $settings );
		?>
        <div class="block-qlinks-inner">
			<?php if ( ! empty( $settings['header'] ) ) : ?>
				<div class="qlinks-header"><span class="qlinks-heading"><?php echo wp_kses( $settings['header'], 'foxiz' ); ?></span></div>
			<?php endif; ?>
			<?php if ( is_array( $settings['quick_links'] ) && count( $settings['quick_links'] ) ) : ?>
            <div class="qlinks-content">
                <ul>
                <?php foreach ( $settings['quick_links'] as $item ) : ?>
                    <li class="qlink h5"><?php echo foxiz_render_elementor_link( $item['url'], $item['title'] ); ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
			<?php endif; ?>
        </div>
		<?php
		foxiz_block_close_tag();

		return ob_get_clean();
	}
}