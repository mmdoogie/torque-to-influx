<?php
class Config {
	private static $pid_map = array(
		'kff1005_0' => 'lat',
		'kff1006_0' => 'lon',
		'kff1001_0' => 'gps_speed',
		'kff1007_0' => 'gps_bearing',
		'k220101_0' => 'aux_voltage',
		'k220105_0' => 'max_charge_power',
		'k220105_1' => 'max_discharge_power',
		'k220101_1' => 'battery_current',
		'k220101_2' => 'battery_voltage',
		'k220105_2' => 'battery_heater_temp',
		'k220101_3' => 'battery_max_temp',
		'k220101_4' => 'battery_min_temp',
		'k220101_5' => 'cumulative_energy_charged',
		'k220101_6' => 'cumulative_energy_discharged',
		'k220101_7' => 'drive_motor_speed_1',
		'k220101_8' => 'drive_motor_speed_2',
		'k220101_9' => 'hv_charging',
		'k220101_10' => 'cell_max_voltage',
		'k220101_11' => 'cell_min_voltage',
		'k220101_12' => 'total_operating_time',
		'k220101_13' => 'requested_charge_current',
		'k220101_14' => 'state_of_charge_bms',
		'k220105_3' => 'state_of_charge_display',
		'k220105_4' => 'state_of_health',
		'k220100_0' => 'indoor_temp',
		'k220100_1' => 'outdoor_temp',
		'k220100_2' => 'vehicle_speed',
		'ke77368_0' => 'battery_mean_temp',
		'k220101_15' => 'cell_mean_voltage',
	);

	private static $check_min = array(
		'cumulative_energy_charged' => 0,
		'cumulative_energy_discharged' => 0,
		'requested_charge_current' => 0,
		'state_of_health' => 25,
		'state_of_charge_bms' => 0,
		'state_of_charge_display' => 0,
		'indoor_temp' => -25,
		'outdoor_temp' => -25,
		'battery_voltage' => 400,
		'cell_max_voltage' => 2,
		'cell_min_volage' => 2,
		'cell_mean_voltage' => 2,
	);

	private static $check_max = array(
		'cumulative_energy_charged' => 100000,
		'cumulative_energy_discharged' => 100000,
	);

	public static function torqueId() {
		return '03499494994944943330303033333';
	}

	public static function datPath() {
		return '/var/www/html/torque.dat';
	}

	public static function influxMeasurement() {
		return 'ev,model=cool_car'
	}

	public static function mapPid($pid) {
		if (isset(Config::$pid_map[$pid])) {
			return Config::$pid_map[$pid];
		} else {
			return $pid;
		}
	}

	public static function checkRanges($dat){
		$ok = true;

		foreach (Config::$check_min as $key => $min) {
			if (isset($dat[$key]) && $dat[$key] < $min) $ok = false;
		}

		foreach (Config::$check_max as $key => $max) {
			if (isset($dat[$key]) && $dat[$key] > $max) $ok = false;
		}

		return $ok;
	}
}
?>
