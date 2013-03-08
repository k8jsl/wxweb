<?php

  /**
 * // <!-- phpDesigner :: Timestamp -->8/1/2012 14:17:52<!-- /Timestamp -->
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWebApi
 * @name Hourly.php
 * @version 1
 * @revision .01
 * @license http://creativecommons.org/licenses/by-sa/3.0/us/
 * 
 * 
 */

  
  require_once (LIBPATH . "/DWML/NoaaParseDwml.php");
  


  class Hourly extends WxWebAPI
  {
  			protected $keyMap = array(
  						'temperature-hourly' => 'temperature_hourly',
  						'temperature-dew point' => 'temperature_dew_point',
  						'temperature-apparent' => 'temperature_apparent',
  						'wind-speed-sustained' => 'wind_speed_sustained',
  						'wind-speed-gust' => 'wind_speed_gust',
  						'direction-wind' => 'direction_wind',
  						'cloud-amount-total' => 'cloud_amount_total',
  						'humidity-relative' => 'humidity_relative',
  						'precipitation-snow' => 'precipitation_snow',
  						'precipitation-liquid' => 'precipitation_liquid',
  						'conditions-icon-forecast-NWS' => 'conditions_icon_forecast_NWS',
  						'probability-of-precipitation-calculated' => 'probability_of_precipitation_calculated',
  						'waves-significant' => 'waves',
  						);
  			function __construct($runconf,$form,$database,$fetch,$conf,$debug,$mysql,$smarty)
  			{
  			          
			
  						
  						$this->fetch = $fetch;
                        
                        $this->runconf = $runconf;
                        $this->form = $form;
                        $this->debug = $debug;
                        $this->conf = $conf;
                        $this->mysql = $mysql;
                        $this->smarty = $smarty;
                        $this->database = $database;
  						

  			}

  			function fetch_hourly()
  			{

  						$run = 'tabular';

  						list($this->temp, $cachet, $runner) = explode("|", $this->runconf[$run . '_settings']);

  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						$lat = (!empty($this->form['lat'])) ? $this->form['lat'] : $this->conf['lat'];
  						$lon = (!empty($this->form['lon'])) ? $this->form['lon'] : $this->conf['lon'];;

  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);

  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);

  						$parser = new NoaaParseDwml($this->keyMap);
  						$parsedDWML = $parser->parseDwml($rawdata);

  						$this->parse_xml($parsedDWML, $rawdata);


  			}
  			function parse_xml($parsed, $raw)
  			{

  						//error_reporting(E_ALL);
                        
                        

  						$i = $d = 0;
  						$Tabdate = $DayTimeFormal = $Tabtemp = $Tabdew = $Tabpop = $Tabapt = $Tabicon = $Tabtime = $Tabwx = array();
  						$Tabwsp = $DayNameFormal = $Tabwdeg = $Tabweng = $Tabgust = $Tabrh = $Tabclouds = $Tabsnow = $Tabqpf = array();

  						if ($this->debug)
  									print "<pre>" . print_r($parsed) . "</pre>";

  						foreach ($parsed as $day)
  						{
  									if ($d > 0)
  									{
  												array_push($Tabtemp, $day['temperature_hourly']);
  												array_push($Tabdew, $day['temperature_dew_point']);
  												array_push($Tabpop, $day['probability_of_precipitation_calculated']);
  												array_push($Tabapt, $day['temperature_apparent']);
  												array_push($Tabwsp, $day['wind_speed_sustained']);
  												array_push($Tabgust, $day['wind_speed_gust']);
  												array_push($Tabwdeg, $day['direction_wind']);
  												array_push($Tabweng, $this->wind_dir($day['direction_wind']));

  												array_push($Tabclouds, $this->clouds($day['cloud_amount_total']));
  												array_push($Tabrh, $day['humidity_relative']);
  												array_push($Tabsnow, $day['precipitation_snow']);
  												array_push($Tabqpf, $day['precipitation_liquid']);


  												array_push($DayNameFormal, date('D M j', strtotime($day['start_valid_time'])));
  												array_push($DayTimeFormal, date('g:i A', strtotime($day['start_valid_time'])));

  												$this->hour[$i] = date('H', strtotime($day['start_valid_time']));
  									}
  									$i++;
  									$d++;
  						}


  						if (preg_match_all('/weather-conditions(\/>?|>.+?<\/weather?)/s', $raw, $m))
  						{
  									for ($i = 0; $i < count($m[0]); $i++)
  									{
  												if ($m[1][$i] == '/>')
  												{
  															array_push($Tabwx, '');
  															array_push($Tabicon, $this->tab_icon($Tabclouds[$i], $i));
  												} else
  												{
  															if (preg_match('/<value coverage=\"([\w\s]+)\" intensity=\"([\w\s]+)\" weather-type=\"([\w\s]+)\"/', $m[1][$i], $aa))
  															{
  																		if (strtoupper($aa[2]) == 'NONE')
  																		{
  																					$wxw[$i] = ucwords(strtolower($aa[1])) . "<br/>" . ucwords(strtolower($aa[3]));
  																					$wxc[$i] = ucwords(strtolower($aa[1])) . " " . ucwords(strtolower($aa[3]));
  																		} else
  																		{
  																					if (strtoupper($aa[1]) == 'DEFINITELY')
  																					{
  																								$aa[1] == '';
  																					} else
  																					{
  																								$cover = ucwords(strtolower($aa[1])) . "<br/>";
  																								$coverc = $aa[1];
  																					}
  																					$wxw[$i] = $cover . ucwords(strtolower($aa[2])) . " " . ucwords(strtolower($aa[3]));
  																					$wxc[$i] = $coverc . ucwords(strtolower($aa[2])) . " " . ucwords(strtolower($aa[3]));
  																		}
  																		//array_push($Tabicon ,$this->tab_icon($wxc[$i], $i));
  															}
  															if (preg_match('/<value coverage=\"([\w\s]+)\" intensity=\"([\w\s]+)\" additive=\"([\w\s]+)\" weather-type=\"([\w\s]+)\" qualifier=\".+?\">/',
  																		$m[1][$i], $bb))
  															{
  																		$wxw[$i] .= "<br/>" . ucwords(strtolower($bb[3])) . "<br/>" . ucwords(strtolower($bb[1])) . "<br/>" . ucwords(strtolower($bb[4]));
  																		$wxc[$i] .= ucwords(strtolower($bb[3])) . " " . ucwords(strtolower($bb[1])) . " " . ucwords(strtolower($bb[4]));
  															}
  															array_push($Tabwx, $wxw[$i]);
  															array_push($Tabicon, $this->tab_icon($wxc[$i], $i));
  												}

  									}
  						}


  						$this->smarty->assign('Tabdate', $DayNameFormal);
  						$this->smarty->assign('Tabtime', $DayTimeFormal);
  						$this->smarty->assign('Tabtemp', $Tabtemp);
  						$this->smarty->assign('Tabdew', $Tabdew);
  						$this->smarty->assign('Tabpop', $Tabpop);
  						$this->smarty->assign('Tabapt', $Tabapt);
  						$this->smarty->assign('Tabicon', $Tabicon);
  						$this->smarty->assign('Tabwsp', $Tabwsp);
  						$this->smarty->assign('Tabwdeg', $Tabwdeg);
  						$this->smarty->assign('Tabweng', $Tabweng);
  						$this->smarty->assign('Tabgust', $Tabgust);
  						$this->smarty->assign('Tabrh', $Tabrh);
  						$this->smarty->assign('Tabclouds', $Tabclouds);
  						$this->smarty->assign('Tabsnow', $Tabsnow);
  						$this->smarty->assign('Tabqpf', $Tabqpf);
  						$this->smarty->assign('Tabwx', $Tabwx);
  						$this->smarty->assign('Tabcount', $i);


  						$this->smarty->assign('localheader', 'Digital Hourly Forecast');

  						if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->var['temp'])) ? $this->var['temp'] : $this->temp;
                            
  							$this->smarty->display($temp);
  						}


  			}


  			function tab_wx_item($wx)
  			{
  						$wxinfo = '';

  						$wx = preg_replace("/\//", " or ", $wx);
  						$wx = preg_replace("/<br.+?>/", " ", $wx);
  						if ($this->debug)
  									print "[$wx] <br>";
  						$wxparms = file_get_contents(CONFIGS . "/ndfd.ini.php");
  						$wxparms = preg_replace("/<\?/", "", $wxparms);
  						$wxparms = preg_replace("/\/\*/", "", $wxparms);
  						$wxparms = preg_replace("/\[.+?\]/", "", $wxparms);
  						$lines = preg_split('/[\r\n]/', $wxparms);
  						foreach ($lines as $line)
  						{
  									if (!$line)
  												continue;

  									@list($key, $wxitems) = preg_split("/\=/", $line);
  									$key = str_replace('/', ' or ', $key);

  									if (preg_match("/" . $key . "/i", $wx))
  									{
  												$wxinfo = $wxitems;
  												break;
  									}
  						}

  						return $wxinfo;
  			}

  			function tab_icon($wx, $hour_id)
  			{

  						$wxinfo = $this->tab_wx_item($wx);


  						$wxdata = explode('|', $wxinfo);

  						$hour = $this->hour[$hour_id];
  						//	echo " hour $hour <br> $wxinfo";
  						if ($hour < 0)
  									$hour += 24;
  						if ($hour > 23)
  									$hour -= 24;
  						$bday = '8';
  						$eday = '21';

  						if ($bday < $eday && $hour >= $bday && $hour < $eday)
  						{
  									return $wxdata[1];
  						} else
  						{
  									return $wxdata[2];
  						}
  			}


  			function clouds($perc)
  			{

  						if ($perc <= '10')
  						{
  									$cld = 'Clear';
  						} elseif ($perc <= '35')
  						{
  									$cld = 'Scattered Clouds';
  						} elseif ($perc <= '50')
  						{
  									$cld = 'Partly Cloudy';
  						} elseif ($perc <= '69')
  						{
  									$cld = 'Mostly Cloudy';
  						} elseif ($perc >= '70')
  						{
  									$cld = 'Cloudy';
  						}


  						return $cld;


  			}

  			function f2c($tempf)
  			{
  						if ($tempf == 'N/A' || $tempf == '')
  									return $tempf;

  						$tempc = ($tempf - 32) * (5 / 9);

  						$tempc = round($tempc);


  						return $tempc;
  			}

  			function wind_dir($deg)
  			{


  						$compass = array(
  									'N',
  									'NNE',
  									'NE',
  									'ENE',
  									'E',
  									'ESE',
  									'SE',
  									'SSE',
  									'S',
  									'SSW',
  									'SW',
  									'WSW',
  									'W',
  									'WNW',
  									'NW',
  									'NNW');
  						$eng = $compass[round($deg / 22.5) % 16];

  						return $eng;
  			}

  }

?>
