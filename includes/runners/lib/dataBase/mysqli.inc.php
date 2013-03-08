<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->10/28/2012 12:06:34<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name MySQL.php
   * @version 4
   * @revision .06
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */
  class MySQL
  {


  			/**
  			 * MySQL::__construct()
  			 * 
  			 * @return
  			 */
  			function __construct($debug, $form, $mysql, $smarty)
  			{

  						$this->debug = $debug;
  						$this->form = $form;
  						$this->mysql = $mysql;
  						$this->smarty = $smarty;
  						$this->state_full = array(
  									'al' => 'alabama',
  									'ak' => 'alaska',
  									'az' => 'arizona',
  									'ar' => 'arkansas',
  									'ca' => 'california',
  									'co' => 'colorado',
  									'ct' => 'connecticut',
  									'de' => 'delaware',
  									'fl' => 'florida',
  									'ga' => 'georgia',
  									'hi' => 'hawaii',
  									'id' => 'idaho',
  									'il' => 'illinois',
  									'in' => 'indiana',
  									'ia' => 'iowa',
  									'ks' => 'kansas',
  									'ky' => 'kentucky',
  									'la' => 'louisiana',
  									'me' => 'maine',
  									'md' => 'maryland',
  									'ma' => 'massachusetts',
  									'mi' => 'michigan',
  									'mn' => 'minnesota',
  									'ms' => 'mississippi',
  									'mo' => 'missouri',
  									'mt' => 'montana',
  									'ne' => 'nebraska',
  									'nv' => 'nevada',
  									'nh' => 'new hampshire',
  									'nj' => 'new jersey',
  									'nm' => 'new mexico',
  									'ny' => 'new york',
  									'nc' => 'north carolina',
  									'nd' => 'north dakota',
  									'oh' => 'ohio',
  									'ok' => 'oklahoma',
  									'or' => 'oregon',
  									'pa' => 'pennsylvania',
  									'ri' => 'rhode island',
  									'sc' => 'south carolina',
  									'sd' => 'south dakota',
  									'tn' => 'tennessee',
  									'tx' => 'texas',
  									'ut' => 'utah',
  									'vt' => 'vermont',
  									'va' => 'virginia',
  									'wa' => 'washington',
  									'wv' => 'west virginia',
  									'wi' => 'wisconsin',
  									'wy' => 'wyoming',
  									'us' => 'united states',
  									'pr' => 'puerto rico',
  									'vi' => 'virgin islands',
  									'gu' => 'guam',
  									'on' => 'ontario',
                                    'ab' => 'alberta',
                                    'qe' => 'quebec',
                                    'bc' => 'british columbia',
                                    'mb' => 'manitoba',
                                    'nb' => 'new brunswick',
                                    'ns' => 'nova scotia',
                                    'pe' => 'prince edward island',
                                    'sk' => 'saskatchewan',
                                    'yk' => 'yukon',
                                    'nf' => 'new foundland and labrador',
                                    'nt' => 'northwest territories',
                                    'nu' => 'nunavut',
                                    );

  			}


  			/**
  			 * MySQL::db_establish()
  			 * 
  			 * @return
  			 */
  			public function db_establish($database, $dbhostname, $dbusername, $dbpassword)
  			{

  						$dbh = mysqli_connect($dbhostname, $dbusername, $dbpassword) or die(mysqli_error($dbh));

  						mysqli_select_db($dbh, $database) or die(mysqli_error($dbh));

  						return $dbh;
  			}


  			/**
  			 * MySQL::get_location()
  			 * 
  			 * @return
  			 */
  			public function get_location($lat, $lon)
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);

  						$sql = "SELECT  a.name, a.state,a.country, " . "(@distance:=(3963*ACOS(SIN(a.lat/57.3)*SIN($lat/57.3)+COS(a.lat/57.3)*COS($lat/57.3)*COS($lon/57.3 - a.lon/57.3)))) AS distance FROM newplaces  as a " .
  									" ORDER BY distance limit 0,1";
  						$res = mysqli_query($dbh, $sql) or die(mysqli_error($dbh));
  						$row = mysqli_fetch_row($res) or die(mysqli_error($dbh));
  						mysqli_close($dbh);
  						$this->smarty->assign('distance', round($row[2], 1));
  						if ($this->debug)
  									echo "\n$sql\ndistance ?? " . $row[2] . "\n";

  						$this->find_closest_metar($lat, $lon);

  						$config = $this->get_global($row[0], $row[1], $row[2]);
  						return $config;

  			}


  			/**
  			 * MySQL::find_closest_metar()
  			 * 
  			 * @return
  			 */
  			public function find_closest_metar($lat, $lon)
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);

  						$sql = "SELECT a.icao, a.name, a.state, a.country, a.lon, a.lat, " . "(@distance:=(3963*ACOS(SIN(a.lat/57.3)*SIN($lat/57.3)+COS(a.lat/57.3)*COS($lat/57.3)*COS($lon/57.3 - a.lon/57.3)))) AS distance FROM icaos  as a " .
  									" ORDER BY distance limit 0,2";

  						//if ($this->debug) print "MySQL metar:\n$sql\n";

  						$res = mysqli_query($dbh, $sql);
  						$x = '1';
  						while (list($icao, $name, $state, $country, $lon, $lat) = mysqli_fetch_row($res))
  						{

  									$this->smarty->assign('icao' . $x . 'x', trim($icao));
  									$this->smarty->assign('mname' . $x . 'x', trim($name));
  									$this->smarty->assign('mstate' . $x . 'x', $state);
  									$this->smarty->assign('mcountry' . $x . 'x', $country);
  									$this->smarty->assign('mlon' . $x . 'x', $lon);
  									$this->smarty->assign('mlat' . $x . 'x', $lat);

  									$this->conf['icao' . $x . 'x'] = trim($icao);
  									$this->conf['mname' . $x . 'x'] = trim($name);
  									$this->conf['mstate' . $x . 'x'] = $state;
  									$this->conf['mcountry' . $x . 'x'] = $country;
  									$this->conf['mlon' . $x . 'x'] = $lon;
  									$this->conf['mlat' . $x . 'x'] = $lat;
  									$x++;
  						}
  						mysqli_close($dbh);
  						return $this->conf;
  			}

  			/**
  			 * MySQL::get_county()
  			 * 
  			 * @return
  			 */
  			function get_county($zone)
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);
  						$zone = strtoupper($zone);
  						if (preg_match('/(\w\w)C(\d\d\d)/', $zone, $e))
  						{
  									$st = $e[1];
  									$fip = $e[2];
  						}

  						$sql = "SELECT CWA,COUNTYNAME,TIME_ZONE,TZ_OFF,LON,LAT,FIPS FROM counties WHERE FIPS LIKE '%" . $fip . "' AND STATE = '$st'";
  						$res = mysqli_query($dbh, $sql);
  						$row = mysqli_fetch_row($res);

  						if ($this->debug)
  									echo "get_county SQL ::<br/> $sql<br/>";


  						$this->conf['cwa'] = $row[0];
  						$this->conf['state'] = $st;
  						
                        $this->conf['county'] = $row[1];
  						$this->conf['clon'] = $row[4];
  						$this->conf['clat'] = $row[5];


  						$this->smarty->assign('cwa', $row[0]);
  						$this->smarty->assign('county', $row[1]);
  						
  						$this->smarty->assign('clon', $row[4]);
  						$this->smarty->assign('clat', $row[5]);
  						$this->smarty->assign('state', strtoupper($st));
  						if (strtoupper($st) == 'LA')
  						{
  									$addon = ' Parish';
  						} else
  						{
  									$addon = ' County';
  						}
  						$this->smarty->assign('location', $row[1] . $addon);
  						mysqli_close($dbh);

  						return $this->conf;

  			}

  			/**
  			 * MySQL::get_global()
  			 * 
  			 * @return
  			 */
  			public function get_global($city, $state, $country = "us")
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);
  						// 0      1        2      3    4    5   6   7       8
  						$sql = "SELECT fip,county_num,county,name,state,lon,lat,wxzone,firezone,radar_icao,country,tz_off,timezone FROM newplaces WHERE name LIKE '$city' AND  state LIKE '$state'";
  						if ($this->debug)
  									print "Global SQL: $sql\n";
  						$res = @mysqli_query($dbh, $sql); // or die(mysqli_error($dbh));
  						$row = @mysqli_fetch_row($res); // or die(mysqli_error($dbh));


  						if (empty($row[3]))
  						{
  									$this->conf['bad_place'] = '1';
  									return $this->conf;
  						}
                        
                        
                        $this->conf['tzname'] = (DST == '1') ? preg_replace("/S/", "D", $row[12]) : $row[12];
  						$this->conf['tzoff'] = $row[11] + DST;


  						$this->conf['fips'] = $row[0] . $row[1];
  						$this->conf['locname'] = $row[3];
  						$this->conf['state'] = $row[4];
  						$this->conf['lat'] = $row[6];
  						$this->conf['lon'] = $row[5];
  						$this->conf['warncounty'] = $row[4] . 'C' . $row[1];
  						$this->conf['zone'] = $row[7];
  						$this->conf['firezone'] = $row[8];
  						$this->conf['radar_icao'] = $row[9];
  						$this->conf = $this->find_closest_metar($row[6], $row[5]);
  						$this->conf['country'] = $row[10];

  						$this->smarty->assign('fips', $row[0] . $row[1]);

  						$this->smarty->assign('warncounty', $row[4] . 'C' . $row[1]);
  						$this->smarty->assign('locname', strtolower($row[3]));
  						$this->smarty->assign('state', $row[4]);
  						$this->smarty->assign('state_full', $this->state_full[strtolower($row[4])]);
  						$this->smarty->assign('lat', $row[6]);
  						$this->smarty->assign('lon', $row[5]);

  						if (preg_match('/-/', $row[6]))
  						{
  									$lat = preg_replace('/-([\d\.]+)/', "$1S", round($row[6], 2));
  						} else
  						{
  									$lat = round($row[6], 2) . "N";
  						}
  						if (preg_match('/-/', $row[5]))
  						{
  									$lon = preg_replace('/-([\d\.]+)/', "$1W", round($row[5], 2));
  						} else
  						{
  									$lon = round($row[5], 2) . "E";
  						}

  						$this->smarty->assign('dlat', $lat);
  						$this->smarty->assign('dlon', $lon);
  						$this->smarty->assign("country", $row[10]);
       	                $this->smarty->assign('tzname', $this->conf['tzname']);
  						$this->smarty->assign('tzoff', $this->conf['tzoff']);


  						$this->smarty->assign('zone', $row[7]);
  						$this->smarty->assign('firezone', $row[8]);
  						$this->smarty->assign('radar_icao', $row[9]);
  						$this->smarty->assign('radar_shrt', preg_replace('/[K|P|T](\w\w\w)/', "$1", $row['9']));
  						$this->smarty->assign('url_locname', urlencode(strtolower($row[3])));
  						//mysql_close($dbh);

  						$sql = "SELECT CWA,COUNTYNAME,LON,LAT FROM counties WHERE FIPS LIKE '" . $this->conf['fips'] . "'";
  						$res = mysqli_query($dbh, $sql);
  						$row = mysqli_fetch_row($res);

  						if (strtoupper($this->conf['state']) == 'AK' || strtoupper($this->conf['state']) == 'HI')
  						{
  									$this->conf['cwa_full'] = "P" . strtoupper($row[0]);
  						} elseif (strtoupper($this->conf['state']) == 'PR')
  						{
  									$this->conf['cwa_full'] = "T" . strtoupper($row[0]);
  						} else
  						{
  									$this->conf['cwa_full'] = "K" . strtoupper($row[0]);
  						}
  						$this->conf['cwa'] = $row[0];
  						$this->conf['countyname'] = $row[1];

  						$this->conf['clon'] = $row[2];
  						$this->conf['clat'] = $row[3];


  						


  						$this->smarty->assign('cwa', $row[0]);
  						$this->smarty->assign('county', $row[1]);
  					
  						$this->smarty->assign('clon', $row[2]);
  						$this->smarty->assign('clat', $row[3]);
  						$this->smarty->assign('country', $country);

  						$zone = $this->conf['zone'];
                        $state_zone ='';
  						if (preg_match('/(\w\w)Z(\d\d\d)/', $zone, $zz))
  						{
  									$state_zone = $zz[1] . $zz[2];
  						}
  						$sql = "SELECT shortname FROM zones WHERE state_zone LIKE '" . $state_zone . "'";
  						$res = mysqli_query($dbh, $sql);
  						$row = mysqli_fetch_row($res);


  						$this->smarty->assign('zone_short_name', $row[0]);


  						$this->conf['zone_short_name'] = $row[0];


  						$zone = $this->conf['firezone'];
  						if (preg_match('/(\w\w)Z(\d\d\d)/', $zone, $zz))
  						{
  									$state_zone = $zz[1] . $zz[2];
  						}
  						$sql = "SELECT name FROM firezones WHERE state_zone LIKE '" . $state_zone . "'";
  						$res = mysqli_query($dbh, $sql);
  						$row = mysqli_fetch_row($res);

  						$this->smarty->assign('firezone_name', $row[0]);

  						$this->conf['firezone_name'] = $row[0];
  						mysqli_close($dbh);

  						if (!empty($this->conf['zipcode']) && !preg_match('/\d+/', $this->conf['zipcode']))
  						{
  									$this->conf['zipcode'] = $this->global_zip($city, $state);
  						}
  						return $this->conf;
  			}

  			/**
  			 * MySQL::get_zip()
  			 * 
  			 * @return
  			 */
  			public function get_zip($zip)
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);

  						$sql = "SELECT Place,State,Lat,Lon FROM zipcodes WHERE Zipcode = '$zip'";
  						$res = mysqli_query($dbh, $sql);
  						list($place, $state, $lat, $lon) = mysqli_fetch_row($res);
  						mysqli_close($dbh);
  						$lat = preg_replace("/\+/", "", $lat);
  						$lon = preg_replace("/-0/", "-", $lon);

  						$this->find_closest_metar($lat, $lon);
  						$this->conf['zipcode'] = $zip;
  						$this->smarty->assign("zipcode", $zip);
  						$config = $this->get_global($place, $state, 'us');

  						return $config;

  			}

  			/**
  			 * MySQL::global_zip()
  			 * 
  			 * @return
  			 */
  			public function global_zip($city, $state, $country = "us")
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);

  						$sql = "SELECT Zipcode FROM zipcodes WHERE Place LIKE '" . urldecode($city) . "' AND State LIKE '$state'";
  						if ($this->debug)
  									echo "Global Zip $sql\n";
  						$res = mysqli_query($dbh, $sql);
  						list($zip) = mysqli_fetch_row($res);
  						mysqli_close($dbh);

  						$this->smarty->assign("zipcode", $zip);


  						return $zip;

  			}


  			/**
  			 * MySQL::get_zone()
  			 * 
  			 * @return
  			 */
  			function get_zone($zone)
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);
  						$zone = strtoupper($zone);
  						if (preg_match('/(\w\w)Z(\d\d\d)/', $zone, $zz))
  						{
  									$state_zone = $zz[1] . $zz[2];
  									$st = $zz[1];
  						}

  						$sql = "SELECT tzname,tzoff,shortname FROM zones WHERE state_zone LIKE '" . $state_zone . "'";
  						$res = mysqli_query($dbh, $sql);
  						$row = mysqli_fetch_row($res);

  						$this->smarty->assign('location', 'Weather Zone ' . $row[2]);
  						$this->smarty->assign('tzname', $row[0]);
  						$this->smarty->assign('tzoff', $row[1]);
  						$this->smarty->assign('state', strtoupper($st));

  						$this->conf['state'] = $st;
  						$this->conf['tzname'] = $row[0];
  						$this->conf['location'] = $row[2];
  						$this->conf['tzoff'] = $row[1];

  						if ($this->debug)
  									print " hhere we ar get zone\n";


  						return $this->conf;


  			}

  			/**
  			 * MySQL::Marine()
  			 * 
  			 * @return
  			 */
  			function Marine($zone)
  			{

  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);

  						$this->conf = array();

  						$sql = "SELECT  name, wxzone, tz, tzname FROM marine_zones WHERE wxzone = '$zone'";
  						if ($this->debug)
  									print $sql;
  						$res = mysqli_query($dbh, $sql);

  						$row = mysqli_fetch_row($res);
  						mysqli_close($dbh);


  						$this->conf['lat'] = round($lat, 3);
  						$this->conf['lon'] = round($lon, 3);

  						$this->conf['mzone'] = $row[1];
  						$this->conf['mname'] = $row[0];
  						$this->conf['mtzname'] = (DST == '1') ? preg_replace("/S/", "D", $row[2]) : $row[2];
  						$this->conf['mtzoff'] = $row[3] + DST;

  						$this->smarty->assign('zonename', $this->conf['mname']);
  						$this->smarty->assign('mstate', '');
  						$this->smarty->assign('mzone', $this->conf['mzone']);


  						return $this->conf;
  			}


  			/**
  			 * MySQL::get_icao()
  			 * 
  			 * @return
  			 */
  			function get_icao($icao)
  			{
  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);

  						$sql = "SELECT icao, name, state, country, lon, lat FROM icaos WHERE icao = '$icao'";

  						if ($this->debug)
  									print "MySQL metar:\n$sql\n";

  						$res = mysqli_query($dbh, $sql);
  						$x = '1';
  						list($icao, $name, $state, $country, $lon, $lat) = mysqli_fetch_row($res);

  						$this->smarty->assign('icao' . $x . 'x', trim($icao));
  						$this->smarty->assign('mname' . $x . 'x', trim($name));
  						$this->smarty->assign('mstate' . $x . 'x', $state);
  						$this->smarty->assign('mcountry' . $x . 'x', $country);
  						$this->smarty->assign('mlon' . $x . 'x', $lon);
  						$this->smarty->assign('mlat' . $x . 'x', $lat);


  			}


  			/**
  			 * MySQL::Get_multiple()
  			 * 
  			 * @return
  			 */
  			function Get_multiple($loc)
  			{
  						$dbh = $this->db_establish($this->mysql['loc_database'], $this->mysql['loc_host'], $this->mysql['loc_dbuser'], $this->mysql['loc_password']);


  						$multiple = array();
  						$urlmultiple = array();
  						$lats = $lons = array();
  						$sql = "SELECT name,state,lat,lon FROM `newplaces` WHERE name LIKE '" . $loc . "%'";
  						$res = mysqli_query($dbh, $sql);
  						if ($this->debug)
  									print "sql $sql\n";
  						while (list($name, $state, $lat, $lon) = mysqli_fetch_row($res))
  						{
  									array_push($multiple, array(
  												$name,
  												$state,
  												$lat,
  												$lon));
  									array_push($lats, $lat);
  									array_push($lons, $lon);
  									array_push($urlmultiple, array(urlencode(strtolower($name)), strtolower($state)));
  						}


  						$this->smarty->assign('multiple_locs', $multiple);
  						$this->smarty->assign('multiple_urllocs', $urlmultiple);
  						$this->smarty->assign('multiple_count', count($multiple));


  						$this->smarty->assign('mult_locs', '1');
  						if ($this->debug)
  									echo count($multiple) . " <<";

  						$this->smarty->display('multiple_locs.tpl');

  			}

  }

?>
