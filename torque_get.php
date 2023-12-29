<?php

require 'torque_config.php';

if (!isset($_GET['id'])) {
	http_response_code(400);
	echo("Bad Request\n");
	exit;
}

if ($_GET['id'] != Config::torqueId()) {
	http_response_code(403);
	echo("Unauthorized\n");
	exit;
}

$fn = Config::datPath();
$fs = filesize($fn);

if ($fs == 0) {
	$dat = "";
} else {
	$f = fopen($fn, "r+");
	flock($f, LOCK_EX);
	$dat = fread($f, filesize($fn));
	rewind($f);
	ftruncate($f, 0);
	fclose($f);
}

http_response_code(200);
print($dat);
exit;
?>
