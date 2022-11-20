
<?php
//Function that can convert timezone and time if time, country_iso, date and time zone(to conver to) given
function timeChange($time, $date ,$c_iso,$timeZoneTo){
    $a=[];
    $timezone_identifiers = DateTimeZone::listIdentifiers( DateTimeZone::PER_COUNTRY, $c_iso);
    foreach( $timezone_identifiers as $identifier ) {
        array_push($a,$identifier);
    }
    $date = new DateTime("$date $time", new DateTimeZone($a[0]));        
            $date->setTimezone(new DateTimeZone($timeZoneTo));
             return array(
             "newDate"=>$date->format('d.m.Y'),
             "newTime"=> $date->format('H:i:s')
             );

}
//Function that can convert string value with "," to float value with "." 
function floatvalue($val){
    $val = str_replace(",",".",$val);
    $val = preg_replace('/\.(?=.*\.)/', '', $val);
    return floatval($val);
}
//Can get distance between two points(km, meters, feets, yards) if lat and lng given
function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
	$theta = $lon1 - $lon2;
	$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
	$feet = $miles * 5280;
	$yards = $feet / 3;
	$kilometers = $miles * 1.609344;
	$meters = $kilometers * 1000;
	return compact('miles','feet','yards','kilometers','meters'); 
}
function convertDegreesToWindDirection($degrees) {
	$directions = array('N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N');
	return $directions[round($degrees / 22.5)];
}
function sortByKey(&$array, $key, $descending = false) { 
	usort($array, function($a, $b) use ($key, $descending) {
		if($a[$key] == $b[$key]) {
			return 0;
		}
		if($descending) {
			return ($a[$key] < $b[$key] ? 1 : -1);
		} else {
			return ($a[$key] > $b[$key] ? 1 : -1);
		}
	});	
}
?>
