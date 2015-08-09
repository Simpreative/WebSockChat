<?php
/**
 * Bootstrap Loader
 *
 * 부트스트랩 로더
 *
 * @author ZerglingGo <zerglinggo@zerglinggo.net>
 * @license http://opensource.org/licenses/MIT MIT License
 */

$bootstrap_dir = "/home/simpreative/public_html/WebSockChat/bootstrap/";
$version = isset($_GET["v"]) == true ? $_GET["v"] : false;
$filetype = isset($_GET["t"]) == true ? $_GET["t"] : false;

if($version && $filetype) {
	$bootstrap_dir .= $version;
	if(is_dir($bootstrap_dir)) {
		if($filetype == "css") {
			$cssfile = $bootstrap_dir."/css/bootstrap.min.css";
			$cssthemefile = $bootstrap_dir."/css/bootstrap-theme.min.css";
			
			header('Content-Type: text/css');
			header('Content-Length: '.(filesize($cssfile) + filesize($cssthemefile)));
			readfile($cssfile);
			readfile($cssthemefile);
			exit;
		} elseif($filetype == "js") {
			$jsfile = $bootstrap_dir."/js/bootstrap.min.js";
			
			header('Content-Type: text/javascript');
			header('Content-Length: '.filesize($jsfile));
			readfile($jsfile);
			exit;
		} else {
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
			exit;
		}
 	} else {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
		exit;
	}
} else {
	if($filetype) {
		$bootstrap_dir .= scandir($bootstrap_dir, 1)[0];
		if($filetype == "css") {
			$cssfile = $bootstrap_dir."/css/bootstrap.min.css";
			$cssthemefile = $bootstrap_dir."/css/bootstrap-theme.min.css";
			
			$data = file_get_contents($cssfile).file_get_contents($cssthemefile);
			$tmp = array(".." => explode("public_html", $bootstrap_dir)[1]);
			$data = strtr($data, $tmp);
			
			header('Content-Type: text/css');
			header('Content-Length: '.strlen($data));
			echo $data;
			exit;
		} elseif($filetype == "js") {
			$jsfile = $bootstrap_dir."/js/bootstrap.min.js";
			
			header('Content-Type: text/javascript');
			header('Content-Length: '.filesize($jsfile));
			readfile($jsfile);
			exit;
		}
	}
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	exit;
}
?>