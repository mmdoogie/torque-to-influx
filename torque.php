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

if (!isset($_GET['kff1005']) or !isset($_GET['time'])) {
	http_response_code(200);
	echo("OK!");
	exit;
}

$dat = [];
$used = [];
$kvps = explode('&', $_SERVER['QUERY_STRING']);

foreach ($kvps as $kvp) {
	$kv = explode('=', $kvp);
	$k = $kv[0];
	$v = $kv[1];

	if ($k[0] == 'k') {
		if (!isset($used[$k])) {
			$kx = 0;
		} else {
			$kx = $used[$k] + 1;
		}

		$pid = $k . "_" . $kx;
		$dat[Config::mapPid($pid)] = $v;
		$used[$k] = $kx;
	}
}

$ok = Config::checkRanges($dat);
if ($ok) {
	$line = Config::influxMeasurement() . ' ';
	foreach ($dat as $k => $v) {
		$line .= $k . "=" . $v . ",";
	}
	$line = rtrim($line, ',') . " " . $_GET['time'] . "\n";

	file_put_contents(Config::datPath(), $line, FILE_APPEND | LOCK_EX);
}

http_response_code(200);
echo("OK!");
exit;
?>
