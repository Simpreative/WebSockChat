<?php
if(php_sapi_name() !== 'cli') {
	header("HTTP/1.1 403 Forbidden");
	echo "403 Forbidden";
	exit;
}

?>