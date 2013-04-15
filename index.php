<?php

require_once('nest.class.php');

/*--------------------------------------------------------------------------*/
// your nest username and password
/*--------------------------------------------------------------------------*/

define('USERNAME', 'YOUR USERNAME HERE');
define('PASSWORD', 'YOUR PASSWORD HERE');

/*--------------------------------------------------------------------------*/
// set timezone. this makes php very happy.
/*--------------------------------------------------------------------------*/

date_default_timezone_set('America/Chicago');

/*--------------------------------------------------------------------------*/
// create a new nest object
/*--------------------------------------------------------------------------*/

$nest = new Nest();

/*--------------------------------------------------------------------------*/
// get device info
/*--------------------------------------------------------------------------*/

$location_info 		= $nest->getUserLocations();
$device_info 		= $nest->getDeviceInfo();

/*--------------------------------------------------------------------------*/
// set appropriate variables
/*--------------------------------------------------------------------------*/

$location_temp 		= round($location_info[0]['outside_temperature'], 0);
$device_mode		= $device_info['current_state']['mode'];
$device_temp 		= round($device_info['current_state']['temperature'], 0);
$device_ac			= $device_info['current_state']['ac'];
$device_heat		= $device_info['current_state']['heat'];
$device_humidity 	= round($device_info['current_state']['humidity'], 0);
$device_leaf 		= $device_info['current_state']['leaf'];
$device_fan 		= $device_info['current_state']['fan'];
$device_auto_away 	= $device_info['current_state']['auto_away'];
$device_manual_away = $device_info['current_state']['manual_away'];
$target_mode 		= $device_info['target']['mode'];
$target_temp 		= round($device_info['target']['temperature'], 0);

/*--------------------------------------------------------------------------*/
// set away status
/*--------------------------------------------------------------------------*/

//unit is in away mode, either automatically or manually
if ($device_auto_away or $device_manual_away) {
	$device_away = 'On';
}
//unit is not in away mode
else {
	$device_away = 'Off';
}

/*--------------------------------------------------------------------------*/
// style the 'set temp' appropriately. display 'off' if unit is off.
/*--------------------------------------------------------------------------*/

//unit is in range-mode. style the temperature range appropriately
if ($target_mode == 'range') {
	$target_temp = '<div class="temp-range">' . round($device_info['target']['temperature'][0], 0) . '&deg;</div><div class="temp-range">' . round($device_info['target']['temperature'][1], 0) . '&deg;</div>';
}
//unit is off, instead of displaying set temp, we'll display 'off'
elseif ($target_mode == 'off') {
	$target_temp = '<span class="temp-off">Off</span>';
}
//it's either in cool-only or heat-only mode. carry on.
else {
	$target_temp .= '&deg;';
}

/*--------------------------------------------------------------------------*/
// set fan status
/*--------------------------------------------------------------------------*/

//if the fan's running, let's animate it by adding this css class
if ($device_fan) {
	$fan_status = 'class="fan-status-running"';
}
else {
	$fan_status = null;
}

/*--------------------------------------------------------------------------*/
// get current 'mode' - ex. heat is running or ac is running. 
/*--------------------------------------------------------------------------*/

// ac is running. display blue color bar.
if ($device_ac) {
	$mode_status = ' cold';
}
// heat is running. display red color bar.
elseif ($device_heat) {
	$mode_status = ' hot';
}
// nothing is running. display neutral color bar.
else {
	$mode_status = ' off';
}

/*--------------------------------------------------------------------------*/
// determine appropriate color for 'outside temp' color bar
/*--------------------------------------------------------------------------*/

// it's warm. display red color bar
if ($location_temp >= 70) {
	$location_color = ' hot';
}
// it's cold. display blue color bar
elseif ($location_temp <= 60) {
	$location_color = ' cold';
}
// it's between our 'hot' and 'cold' definitions. display neutral color bar.
else {
	$location_color = ' off';
}

/*--------------------------------------------------------------------------*/

?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="refresh" content="30">
		
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		
	</head>
	
	<body>
		<div class="container">
			<div class="header">Nest</div>
			
			<div class="current-temp"><?php echo($device_temp); ?><span>&deg;</span></div>
			
			<div class="secondary-info">
				<div class="temp-label">Set <br>Temp</div>
				<div class="temp<?php echo($mode_status); ?>"><?php echo($target_temp); ?></div>
				
				<div class="temp-label">Outside <br>Temp</div>
				<div class="temp<?php echo($location_color); ?>"><?php echo($location_temp); ?>&deg;</div>
			</div>
			
			<div class="secondary-info">
				<div class="fan-status"><img src="fan.png" <?php echo($fan_status); ?> /></div>
				<div class="humidity"><?php echo($device_humidity); ?>&#37;</div>
				<div class="away-status"><?php echo($device_away); ?></div>
			</div>
		</div>
	</body>
</html>