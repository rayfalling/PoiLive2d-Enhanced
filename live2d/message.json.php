<?php
require( '../../../../wp-load.php' );
header( "Content-Type: application/json;" );

if ( ob_get_clean() ) {
	ob_clean();
}

echo get_option( 'live2d_custommsg' );
