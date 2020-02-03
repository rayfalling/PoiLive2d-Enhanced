<?php
require('../../../../wp-load.php');
header("Content-Type: application/json;");
ob_get_clean();
ob_clean();
echo get_option('live2d_custommsg');
?>