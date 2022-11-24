<?php
/** Don't load directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="rb-panel-wrap">
    <div class="rb-panel-header">
        <div class="rb-panel-heading">
            <h1><?php echo esc_html__( 'Quick Translation', 'foxiz-core' ); ?></h1>
            <p class="sub-heading"><?php echo esc_html__( 'Search and find the string you would like to translate.', 'foxiz-core' ); ?></p>
        </div>
    </div>
    <div class="rb-translation">
        <form method="post" action="" id="rb-translation-form">
	    <?php wp_nonce_field( 'rb-core', 'rb-core-nonce' );
		if ( empty( $data ) || ! is_array( $data ) || ! count( $data ) ) : ?>
			<div class="fetch-translation">
				<input type="submit" class="rb-panel-button" value="<?php esc_html_e( 'Fetch Translation Data', 'foxiz-core' ) ?>" name="fetch-translation" id="rb-fetch-translation">
				<span class="rb-loading is-hidden fetch-translation-loader"><i class="dashicons dashicons-update"></i></span>
			</div>
            <p class="rb-notice"><?php esc_html_e( 'POT files not found.', 'foxiz-core' ); ?></p>
		<?php else : ?>
			<div class="fetch-translation">
				<input type="submit" class="re-fetch-translation" value="<?php esc_html_e( 'Re-fetch Translation Data', 'foxiz-core' ) ?>" name="fetch-translation" id="rb-fetch-translation">
				<span class="rb-loading is-hidden fetch-translation-loader"><i class="dashicons dashicons-update"></i></span>
			</div>
            <div class="rb-translation-form">
				<?php foreach ( $data as $item ) : ?>
                    <div class="item">
                        <label for="<?php esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['str'] ); ?></label>
                        <input type="text" name="<?php echo $item['id']; ?>" value="<?php echo ( ! empty( $item['translated'] ) ) ? esc_html( $item['translated'] ) : ''; ?>">
                    </div>
				<?php endforeach; ?>
                <div class="form-footer">
                    <p class="rb-info"></p>
                    <span class="rb-loading is-hidden update-translation-loader"><i class="dashicons dashicons-update"></i></span>
                    <input type="submit" class="rb-panel-button" value="<?php esc_html_e('Save Changes', 'foxiz-core') ?>" name="update-translation" id="rb-update-translation">
                </div>
            </div>
		<?php endif; ?>
            </form>
    </div>
</div>