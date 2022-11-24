<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! current_user_can( 'install_plugins' ) ) {
	wp_die( '<div class="notice notice-warning"><p>'.esc_html__( 'Sorry, you are not allowed to install demos on this site.', 'foxiz-core' ).'</p></div>' );
}

if ( empty( $demos ) || ! is_array( $demos ) ) {
	wp_die( '<div class="notice notice-warning"><p>'.esc_html__('Something went wrong, Try to re-activate the theme again!', 'foxiz-core').'</p></div>');
};

$nonce = wp_create_nonce( 'rb-core' );
?>
<div class="rb-demos-wrap">
	<div class="importer-header">
		<h2 class="importer-headline"><i class="dashicons dashicons-download"></i><?php esc_html_e( 'Ruby Demo Importer', 'rb-importer' ); ?></h2>
		<div class="importer-desc">
			<p>Importing theme demo, It will allow you to quickly edit everything instead of creating content from
			   scratch. Please <strong>DO NOT navigate away</strong> from this page while the importer is
			   processing. This may take up to 5 ~ 7 minutes, Depend on the server speed.</p>
			<p>We do not have right to include some images of demos in the content due to copyright issue, so images
			   will look different with the demo. The structures of demos will still be left intact so can use your
			   own images in their places if you desire.</p>
		</div>
		<div class="importer-tips">
			<p><strong>Import Tips:</strong></p>
			<p>- Refresh this page and re-import if the process cannot complete after 5 minutes.</p>
			<p>- You can choose Only Pages, Widgets and Theme Options to import if you site already have data.</p>
			<p>- <strong>Don't need</strong> to install or activate Recommended & Optional plugins if you don't want to use it.</p>
			<p>- Install and activate Woocommerce plugin before importing if you would like setup shop.</p>
			<p>- Online Documentation: <a href="http://help.themeruby.com/foxiz" target="_blank">http://help.themeruby.com/foxiz</a></p>
		</div>
	</div>
	<div class="rb-demos">
		<?php foreach ( $demos as $directory => $demo ) :
			if ( ! empty( $demo['imported'] ) && is_array( $demo['imported'] ) ) {
				$imported       = true;
				$item_classes   = 'rb-demo-item active is-imported';
				$import_message = esc_html__( 'Already Imported', 'foxiz-core' );
			} else {
				$item_classes   = 'rb-demo-item not-imported';
				$imported       = false;
				$import_message = esc_html__( 'Import Demo', 'foxiz-core' );
			} ?>
			<div class="<?php echo esc_attr( $item_classes ); ?>" data-directory="<?php echo $directory; ?>" data-nonce="<?php echo $nonce ?>" data-action="rb_importer">
				<div class="inner-item">
					<div class="demo-preview">
						<div class="demo-process-bar"><span class="process-percent"></span></div>
						<img class="demo-image" src="<?php echo esc_html( $demo['preview'] ); ?>" alt="<?php esc_attr( $demo['name'] ); ?>"/>
						<span class="demo-status"><?php echo esc_html( $import_message ); ?></span>
						<span class="process-count">0%</span>
					</div>
					<div class="demo-content">
						<h3 class="demo-name"><?php echo $demo['name']; ?></h3>
						<?php if ( is_array( $demo['plugins'] ) ) : ?>
							<div class="demo-plugins">
								<h4><?php esc_html_e( 'Plugins Recommended', 'foxiz-core' ) ?></h4>
								<?php rb_importer_plugins_form( $demo['plugins'], $nonce ); ?>
							</div>
						<?php endif;
						rb_importer_select_form( $directory );
						?>
						<div class="import-actions">
							<?php if ( ! $imported ) : ?>
								<div class="rb-importer-btn-wrap">
									<span class="rb-wait"><span class="rb-loading"><i class="dashicons dashicons-update"></i></span><span><?php esc_html_e( 'Importing...', 'foxiz-core' ); ?></span></span>
									<span class="rb-do-import rb-importer-btn rb-disabled"><?php esc_html_e( 'Import Demo', 'foxiz-core' ) ?></span>
									<span class="rb-importer-completed"><?php esc_html_e( 'Import Complete', 'foxiz-core' ); ?></span>
								</div>
							<?php else : ?>
								<div class="rb-importer-btn-wrap">
									<span class="rb-wait"><span class="rb-loading"><i class="dashicons dashicons-update"></i></span><span><?php esc_html_e( 'Importing...', 'foxiz-core' ); ?></span></span>
									<span class="rb-do-reimport rb-importer-btn rb-disabled"><?php esc_html_e( 'Re-Import', 'foxiz-core' ); ?></span>
									<span class="rb-importer-completed"><?php esc_html_e( 'Import Complete', 'foxiz-core' ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		endforeach; ?>
	</div>
</div>
