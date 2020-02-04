<?php
error_reporting(0);
header("Content-Type: application/json;");
require('../../../../wp-load.php');

if ( ob_get_clean() ) {
	ob_clean();
}

echo get_option('live2d_customkoto');
