<?php
/**
 * WebSocket Server
 * 
 * @author ZerglingGo <zerglinggo@zerglinggo.net>
 * @license http://opensource.org/licenses/MIT MIT License
 */

if(php_sapi_name() !== 'cli') {
	header("HTTP/1.1 403 Forbidden");
	echo "403 Forbidden";
	exit;
}

echo "WebSocket Server";
?>