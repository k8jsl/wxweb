<?

   //echo moon_phases_shortcode_handler();


/*
 *
 *	moon_phases_get_plugin_url
 *
 */

function moon_phases_get_plugin_url() {
	return '/';
}





/*
 *
 *	moon_phases_normalize
 *
 */

function moon_phases_normalize($v) {
	$v -= floor($v);
	if($v < 0) {
		$v += 1;
	}
	return $v;
}





/*
 *
 *	moon_phases_shortcode_handler
 *
 */

function moon_phases_shortcode_handler() {

	// Get date
	$y = date('Y');
	$m = date('n');
	$d = date('j');

	// Calculate julian day
	$yy = $y - floor((12 - $m) / 10);
	$mm = $m + 9;
	if($mm >= 12) {
		$mm = $mm - 12;
	}

	$k1 = floor(365.25 * ($yy + 4712));
	$k2 = floor(30.6 * $mm + 0.5);
	$k3 = floor(floor(($yy / 100) + 49) * 0.75) - 38;

	$jd = $k1 + $k2 + $d + 59;
	if($jd > 2299160) {
		$jd = $jd - $k3;
	}
	
	// Calculate the moon phase
	$ip = moon_phases_normalize(($jd - 2451550.1) / 29.530588853);
	$ag = $ip * 29.53;

	if($ag < 1.84566) {
		$phase = 'New Moon';
		$image = moon_phases_get_plugin_url() . 'images/new_moon.png';
	}
   	else if($ag < 5.53699) {
		$phase = 'Waxing Crescent Moon';
		$image = moon_phases_get_plugin_url() . 'images/waxing_crescent_moon.png';
	}
	else if($ag < 9.22831) {
		$phase = 'First Quarter Moon';
		$image = moon_phases_get_plugin_url() . 'images/first_quarter_moon.png';
	}
	else if($ag < 12.91963) {
		$phase = 'Waxing Gibbous Moon';
		$image = moon_phases_get_plugin_url() . 'images/waxing_gibbous_moon.png';
	}
	else if($ag < 16.61096) {
		$phase = 'Full Moon';
		$image = moon_phases_get_plugin_url() . 'images/full_moon.png';
	}
	else if($ag < 20.30228) {
		$phase = 'Waning Gibbous Moon';
		$image = moon_phases_get_plugin_url() . 'images/waning_gibbous_moon.png';
	}
	else if($ag < 23.99361) {
		$phase = 'Third Quarter Moon';
		$image = moon_phases_get_plugin_url() . 'images/third_quarter_moon.png';
	}
	else if($ag < 27.68493) {
		$phase = 'Waning Crescent Moon';
		$image = moon_phases_get_plugin_url() . 'images/waning_crescent_moon.png';
	}
	else {
		$phase = 'New Moon';
		$image = moon_phases_get_plugin_url() . 'images/new_moon.png';
	}

	// Convert phase to radians
	$ip = $ip * 2 * pi();

	// Calculate moon's distance
	$dp = 2 * pi() * moon_phases_normalize(($jd - 2451562.2) / 27.55454988);
	$di = 60.4 - 3.3 * cos($dp) - 0.6 * cos(2 * $ip - $dp) - 0.5 * cos(2 * $ip);

	// Calculate moon's ecliptic latitude
	$np = 2 * pi() * moon_phases_normalize(($jd - 2451565.2) / 27.212220817);
	$la = 5.1 * sin($np);

	// Calculate moon's ecliptic longitude
	$rp = moon_phases_normalize(($jd - 2451555.8) / 27.321582241);
	$lo = 360 * $rp + 6.3 * sin($dp) + 1.3 * sin(2 * $ip - $dp) + 0.7 * sin(2 * $ip);



	// Age
	$age = floor($ag);

	// Distance
	$distance = round(100 * $di) / 100;

	// Ecliptic latitude
	$latitude = round(100 * $la) / 100;

	// Ecliptic longitude
	$longitude = round(100 * $lo) / 100;
	if($longitude > 360) {
		$longitude -= 360;
	}

	return array($phase,$age);
}


