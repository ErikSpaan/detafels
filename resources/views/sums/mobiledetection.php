<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['mobileDetection'])) {
	function isMobileDevice() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	if(isMobileDevice()){
		session(['mobileDetection' => 'yes']);
	}
	else {
		session(['mobileDetection' => 'no']);
	}
}
?>