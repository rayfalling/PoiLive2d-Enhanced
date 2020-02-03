<?php
defined( 'ABSPATH' ) or exit;

add_action( 'wp_enqueue_scripts', 'live2d_scripts' );
function live2d_scripts() {
	if ( ! wp_is_mobile() ) {
		wp_enqueue_style( 'live2d-base', LIVE2D_URL . '/live2d/css/live2d.css.php', array(), LIVE2D_VERSION, 'all' );
		wp_enqueue_script( 'live2d-base', LIVE2D_URL . '/live2d/js/live2d.js', array(), LIVE2D_VERSION, true );
		wp_enqueue_script( 'live2d-message', LIVE2D_URL . '/live2d/js/message.js.php', array(), LIVE2D_VERSION, true );
		wp_enqueue_script( 'live2d-run', LIVE2D_URL . '/live2d/js/run_local.js', array(), LIVE2D_VERSION, true );
	}
}

add_action( 'wp_footer', 'live2d_footer' );
function live2d_footer() {
	if ( ! wp_is_mobile() ) {
		?>
        <div id="landlord">
            <div class="message" style="opacity:0"></div>
            <canvas id="live2d" width="280" height="250" class="live2d" style="opacity:0;"></canvas>
            <ul class="l2d-menu">
				<?php if ( get_option( 'live2d_catalog' ) == "checked" and is_single()): ?>
                    <li class="l2d-action" id="catalog-button">目录</li>
				<?php endif; ?>
                <li class="l2d-action" id="switch-button">变装</li>
                <li class="l2d-action" id="hide-button">隐藏</li>
            </ul>
        </div>
		<?php
	}
}

?>