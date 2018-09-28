<?php
include('PhoogleMap3.php');
class map extends PhoogleMap3
{
	#	internal variables
	var $last_error = "";            // last error message set by this class
	var $last_time = 0;              // last function execution time (debug info)
	var $units = "m";                // m = miles, k = kilometers
	var $decimals = 2;               // decimal places for returned distance
	// 
	// #	Constructor
	// function __construct ( argument )
	// {
	// 	
	// }
	// ###	

function sd_providersearch_map_fit_points ($zip,$range,$county) {
   $ziparray = $this->sd_providersearch_get_orgs_in_range($zip,$range,$county);
   $returnarray = array();
   foreach($ziparray as $key => $value) {
      $returnarray []= $key;}
      $queryrange = implode(',',$returnarray);
      
      $coordquery = "select MIN(`lat`) swlat,MIN(`long`) swlong, MAX(`lat`) nelat,MAX(`long`) nelong,AVG(`lat`) avglat,AVG(`long`) avglong from {ps_orgs_wa} WHERE `lat` IS NOT NULL AND `long` IS NOT NULL AND id in ($queryrange)";
     $coordrange = db_query($coordquery)->fetch(PDO::FETCH_ASSOC);
      return $coordrange;
   }
	function sd_providersearch_get_distance ($zip1, $zip2)
	{
		// returns the distance between to zip codes.  If there is an error, the 
		// function will return -1 and set the $last_error variable.

		$this->sd_providersearch_chronometer();         // start the clock

		if ($zip1 == $zip2) return 0; // same zip code means 0 miles between. :)


		// get details from database about each zip and exit if there is an error

		$details1 = $this->sd_providersearch_get_zip_point($zip1);
		$details2 = $this->sd_providersearch_get_zip_point($zip2);
		if (empty($details1)) 
		{
		$this->last_error = "No details found for zip code: $zip1";
		return -1;
		}
		if (empty($details2)) 
		{
			$this->last_error = "No details found for zip code: $zip2";
			return -1;
		}     
		// calculate the distance between the two points based on the latitude
		// and longitude pulled out of the database.
		$miles = $this->sd_providersearch_calculate_mileage($details1[0], $details2[0], $details1[1], $details2[1]);
		$this->last_time = $this->sd_providersearch_chronometer();
		if ($this->units == 'k') return round($miles * 1.609344, $this->decimals);
		else return round($miles, $this->decimals);       // assumed $units = 'm'
		
	}
	function sd_providersearch_get_zip_details ($zip)
	{
		// This function pulls the details from the database for a 
		// given zip code.

		$sql = "SELECT latitude, longitude, Name, state.state_prefix, state_name,  from  ps_cities, ps_state WHERE zipcode=$zip AND
		zipcode.state_prefix=state.state_prefix";

		$r = mysql_query($sql);
		if (!$r) {
		   $this->last_error = mysql_error();
		   return;
		} else {
		   $row = mysql_fetch_array($r, MYSQL_ASSOC);
		   mysql_free_result($r);
		   return $row;       
		}
	}
	function sd_providersearch_get_zip_point ( $zip )
	{
		
	
         $entries =  db_query('SELECT `latitude`,`longitude` FROM `{ps_cities}` WHERE `zipcode` = :zip', array(':zip' => "$zip"))->fetch(PDO::FETCH_ASSOC);

          if (!empty($entries)) {
          
   
  
            $zip_result = $entries;
        
		   return $zip_result;  
   
      }
         else return;     
	      
         }
	function sd_providersearch_chronometer()
	{
		// chronometer function taken from the php manual.  This is used primarily
		// for debugging and anlyzing the functions while developing this class.  

		$now = microtime(TRUE);  // float, in _seconds_
		$now = $now + time();
		$malt = 1;
		$round = 7;

		if ($this->last_time > 0) 
		{
		    /* Stop the chronometer : return the amount of time since it was started,
		    in ms with a precision of 3 decimal places, and reset the start time.
		    We could factor the multiplication by 1000 (which converts seconds
		    into milliseconds) to save memory, but considering that floats can
		    reach e+308 but only carry 14 decimals, this is certainly more precise */

		    $retElapsed = round($now * $malt - $this->last_time * $malt, $round);

		    $this->last_time = $now;

		    return $retElapsed;
		} 
		else {
		    // Start the chronometer : save the starting time

		    $this->last_time = $now;

		    return 0;
		}
	}
	function sd_providersearch_get_zips_in_range($zip, $range) 
	{

	   // returns an array of the zip codes within $range of $zip. Returns
	   // an array with keys as zip codes and values as the distance from 
	   // the zipcode defined in $zip.

	   $this->sd_providersearch_chronometer();                     // start the clock

	   $details = $this->sd_providersearch_get_zip_point($zip);  // base zip details
	   if (empty($details)) return;
      

	   $return = array();    // declared here for scope

$r =  db_query('SELECT `zipcode`,`latitude`,`longitude` FROM `{ps_cities}` WHERE `zipcode` <>:zip', array(':zip' => "$zip"));

	  
	   // $r = mysql_query($sql);

	   if (!$r) {    // sql error

	    
	      return;

	   } else {

	      while ($row = $r->fetch(PDO::FETCH_ASSOC)) {

	         // loop through all 40 some thousand zip codes and determine whether
	         // or not it's within the specified range.

	         $dist = $this->sd_providersearch_calculate_mileage($details['latitude'],$row['latitude'],$details['longitude'],$row['longitude']);
          
	         if ($this->units == 'k') $dist = $dist * 1.609344;
	         if ($dist <= $range) {
	            $return[str_pad($row[0], 5, "0", STR_PAD_LEFT)] = round($dist, $this->decimals);
	         }
	      }
	      
	   }

	   $this->last_time = $this->sd_providersearch_chronometer();

	   return $return;
	}

	function sd_providersearch_get_orgs_in_range($zip, $range,$county) 
	{

	   // returns an array of the zip codes within $range of $zip. Returns
	   // an array with keys as zip codes and values as the distance from 
	   // the zipcode defined in $zip.

	   $this->sd_providersearch_chronometer();                     // start the clock

	   $details = $this->sd_providersearch_get_zip_point($zip);  // base zip details
	   if (empty($details)) return;

	   $return = array();    // declared here for scope
      $countycoordsquery = "SELECT `latitude` `countylat`,`longitude` `countylong` from {ps_cities} where county_code = '$county' AND `county_seat` = 1";
       $countycoords = db_query($countycoordsquery)->fetchAll(PDO::FETCH_ASSOC);
      $countylat = $countycoords[0]['countylat'];
      $countylong = $countycoords[0]['countylong'];
 $r =  db_query("SELECT `id`, IF(`lat`,`lat`,'$countylat') `fixlat`,IF(`long`,`long`,'$countylong') `fixlong`  FROM `{ps_orgs_wa}` WHERE 1");


	   if (!$r) {    // sql error

	  
	      return;

	   } else {

	      while ($row = $r->fetch(PDO::FETCH_ASSOC)) {

	         // loop through all 40 some thousand zip codes and determine whether
	         // or not it's within the specified range.

	         $dist = $this->sd_providersearch_calculate_mileage($details['latitude'],$row['fixlat'],$details['longitude'],$row['fixlong']);
	         if ($this->units == 'k') $dist = $dist * 1.609344;
	         if ($dist <= $range) {
	            $return[str_pad($row['id'], 0, "0", STR_PAD_LEFT)] = round($dist, $this->decimals);
	         }
	      }
	   
	   }

	   $this->last_time = $this->sd_providersearch_chronometer();

	   return $return;
	}

	function sd_providersearch_calculate_mileageA($lat1, $lat2, $lon1, $lon2) 
	{

	   // This function is not used right now.  This is based on code found
	   // all over the internet such as 4guysfromrolla.com.  It's not clear
	   // who the original author was.

	   $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2));
	   $dist = $dist+cos(deg2rad($lat1))*cos(deg2rad($lat2))*cos(deg2rad($lon1 - $lon2)); 
	   $dist = acos($dist); 
	   $dist = rad2deg($dist); 
	   return $dist * 60 * 1.1515;
	}

	function sd_providersearch_calculate_mileage($lat1, $lat2, $lon1, $lon2) 
	{

	   // used internally, this function actually performs that calculation to
	   // determine the mileage between 2 points defined by latitude and
	   // longitude coordinates.  This calculation is based on the code found
	   // at http://www.cryptnet.net/fsp/zipdy/

	   // Convert latitude/longitude (degrees) to radians for calculations
	   $lat1 = deg2rad($lat1);
	   $lon1 = deg2rad($lon1);
	   $lat2 = deg2rad($lat2);
	   $lon2 = deg2rad($lon2);

	   // Find the deltas
	   $delta_lat = $lat2 - $lat1;
	   $delta_lon = $lon2 - $lon1;

	   // Find the Great Circle distance 
	   $temp = pow(sin($delta_lat/2.0),2) + cos($lat1) * cos($lat2) * pow(sin($delta_lon/2.0),2);
	   $distance = 3956 * 2 * atan2(sqrt($temp),sqrt(1-$temp));

	   return $distance;
	}

	function sd_providersearch_getGeocode($id,$address,$htmlMessage=null){
	 if (!is_string($address)){
		die("All Addresses must be passed as a string");
	  }
		$apiURL = "http://api.local.yahoo.com/MapsService/V1/geocode?appid=YahooDemo&location=";
		$addressData = file_get_contents($apiURL.urlencode($address));
		$results = $this->sd_providersearchxml2array($addressData);
		$return .= '<td>'.$id.'</td>';
		$return .= '<td>'.$results['ResultSet']['Result']['Latitude'].'</td>';
		$return .= '<td>'.$results['ResultSet']['Result']['Longitude'].'</td>';
		$return .= '<td>'.$address.'</td>';
		$return .= '<td>'.$htmlMessage.'</td>';

	return $return;


	}

	
###
}