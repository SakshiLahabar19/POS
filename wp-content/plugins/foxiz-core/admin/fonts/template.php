<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$settings     = get_option( 'rb_adobe_font_settings', array() );
$font_options = rbSubPageAdobeFonts::get_instance()->font_selection( $fonts );
?>
<div class="rb-panel-wrap rb-fonts">
	<div class="rb-panel-header">
		<div class="rb-panel-heading">
			<h1><?php echo esc_html__( 'Adobe (TypeKit) Fonts', 'foxiz-core' ); ?></h1>
			<p class="sub-heading"><?php echo esc_html__( 'The theme supports Adobe (TypeKit) Fonts. These settings below will override on Google Fonts settings in the Theme Options panel.', 'foxiz-core' ); ?></p>
		</div>
	</div>
	<div class="rb-panel">
		<div class="rb-project-id-header">
			<h2><?php esc_html_e( 'Project ID', 'foxiz-core' ); ?></h2>
			<p><?php printf( __( 'You can find the Project ID <a href=%1$s target="_blank" >here</a> from your Typekit Account.', 'foxiz-core' ), '//fonts.adobe.com/my_fonts?browse_mode=all#web_projects-section' ); ?></p>
		</div>
		<form name="rb-adobe-font" method="post" action="">
			<?php wp_nonce_field( 'rb-fonts', 'rb-fonts-nonce' ); ?>
			<?php if ( ! empty( $project_id ) ) : ?>
				<input class="rb-panel-input-text" type="text" name="rb_fonts_project_id" id="rb-project-id" readonly value="<?php echo esc_attr( $project_id ); ?>">
				<a href="#" id="rb-edit-project-id" class="rb-panel-button"><?php esc_html_e( 'Edit Project ID', 'foxiz-core' ); ?></a>
				<button type="submit" name="action" class="rb-panel-button" id="delete-project-id" value="delete"><?php echo esc_attr( $delete ); ?></button>
				<button type="submit" name="action" class="rb-panel-button is-hidden" id="submit-project-id" value="update"><?php echo esc_attr( $button ); ?></button>
			<?php else : ?>
				<input class="rb-panel-input-text" type="text" name="rb_fonts_project_id" id="rb-project-id" value="">
				<button type="submit" name="action" class="rb-panel-button" id="submit-project-id" value="update"><?php echo esc_attr( $button ); ?></button>
			<?php endif; ?>
		</form>
	</div>
	<div class="rb-panel font-details-wrap">
		<div class="rb-font-details-header">
			<h2><?php esc_html_e( 'Adobe Font Details', 'foxiz-core' ); ?></h2>
			<p><?php esc_html_e( 'The list below will display all fonts in your Adobe fonts account.', 'foxiz-core' ); ?></p>
		</div>
		<div class="font-details">
			<?php if ( empty( $project_id ) ) : ?>
				<p class="rb-font-notice"><?php esc_html_e( 'Emty project ID.', 'foxiz-core' ); ?></p>
			<?php elseif ( empty( $fonts ) ) : ?>
				<p class="rb-font-notice"><?php esc_html_e( 'No webfont found in your project.', 'foxiz-core' ); ?></p>
			<?php else : ?>
				<div class="rb-font-item is-top">
					<p class="rb-font-detail"><?php esc_html_e( 'Fonts', 'foxiz-core' ); ?></p>
					<p class="rb-family-detail"><?php esc_html_e( 'Font Family', 'foxiz-core' ); ?></p>
					<p class="rb-weight-detail"><?php esc_html_e( 'Weight & Style', 'foxiz-core' ); ?></p>
				</div>
				<?php foreach ( $fonts as $font ) : ?>
					<div class="rb-font-item">
						<p class="rb-font-detail"><?php echo esc_html( $font['family'] ); ?></p>
						<p class="rb-family-detail"><?php echo esc_html( $font['backup'] ); ?></p>
						<p class="rb-weight-detail"><?php echo esc_html( implode( ',', $font['variations'] ) ); ?></p>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
	<div class="rb-panel font-settings-wrap">
		<div class="rb-font-details-header">
			<h2><?php esc_html_e( 'Font Settings', 'foxiz-core' ); ?></h2>
			<p><?php esc_html_e( 'These settings below will override on Google Fonts settings in the Theme Options panel.', 'foxiz-core' ); ?></p>
		</div>
		<form name="rb-font-settings" method="post" action="">
			<?php wp_nonce_field( 'rb-font-settings', 'rb-font-settings-nonce' ); ?>
			<div class="font-settings">
				<?php
				/** @var settings elements $elements */
				$elements = array(
					'h1'   => esc_html__( 'H1 Tag', 'foxiz-core' ),
					'h2'   => esc_html__( 'H2 Tag', 'foxiz-core' ),
					'h3'   => esc_html__( 'H3 Tag', 'foxiz-core' ),
					'h4'   => esc_html__( 'H4 Tag', 'foxiz-core' ),
					'h5'   => esc_html__( 'H5 Tag', 'foxiz-core' ),
					'h6'   => esc_html__( 'H6 Tag', 'foxiz-core' ),
					'body' => esc_html__( 'Site Body', 'foxiz-core' )
				);
				foreach ( $elements as $element_id => $title ) : ?>
					<div class="font-setting-el">
						<p class="font-setting-title"><?php echo esc_html( $title ); ?></p>
						<select class="rb-font-setting" name="rb_font_settings[<?php echo esc_html( $element_id ); ?>]">
							<?php foreach ( $font_options as $id => $label ) {
								if ( isset( $settings[ $element_id ] ) && (string) $settings[ $element_id ] === (string)$id ) {
									echo '<option selected value="' . $id . '">' . $label . '</option>';
								} else {
									echo '<option value="' . $id . '">' . $label . '</option>';
								}
							} ?>
						</select>
					</div>
				<?php endforeach; ?>
			</div>
			<input id="submit-font-settings" class="rb-panel-button" type="submit" value="<?php esc_html_e( 'Save Changes', 'foxiz-core' ) ?> ">
		</form>
	</div>
</div>