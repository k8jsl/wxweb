<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->1/5/2013 16:30:49<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name DayCast.php
   * @version 2
   * @revision .00
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  require (LIBPATH . "/DWML/NoaaParseDwml.php");


  class DayCast extends WxWebAPI
  {


  			protected $keyMap = array(
  						'temperature-maximum' => 'temperature_maximum',
  						'temperature-minimum' => 'temperature_minimum',
  						'start-valid-time' => 'start_valid_time',
  						'start-valid-time-calculated' => 'start_valid_time_calculated',
  						'probability-of-precipitation-12 hour' => 'probability_of_precipitation_12_hour',
  						'weather' => 'weather',
  						'conditions-icon-forecast-NWS' => 'conditions_icon_forecast_NWS',
  						'probability-of-precipitation-calculated' => 'probability_of_precipitation_calculated',
  						'wordedForecast' => 'worded_forecast',
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
                        

  			
  						/**
  						 * need to set day replacements
  						 * 
  						 * */
  						$this->replacedays = $this->replacetitles = array();
  						foreach ($this->conf['DayTitles'] as $key => $value)
  						{
  									array_push($this->replacetitles, "/" . $key . "/");
  									array_push($this->replacedays, $value);
  						}

  			}

  			function fetch_daycast()
  			{
  						$run = 'daycast';
                    
                        if (strtoupper($this->conf['country']) == 'CA')
                        {
                            if ($this->debug) echo "We have a Canadian Locale\n";
                           require(RUNNERS . '/International.php');
                           $runconf = parse_ini_file(CONFIGS .'/international.conf.php', TRUE);
                           $inter = new International($runconf, $this->form, $this->database, $this->fetch, $this->conf, $this->debug, $this->mysql, $this->smarty);
                           $inter->get_forecast();
                           exit;
                        }
                    
                    

  						list($temp, $cachetime, $runner) = explode("|", $this->runconf[$run . '_settings']);


  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						$lat = (!empty($this->form['lat'])) ? $this->form['lat'] : $this->conf['lat'];
  						$lon = (!empty($this->form['lon'])) ? $this->form['lon'] : $this->conf['lon'];;

  						$turl = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cachepath = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);

  						$this->get_data($turl, $cachetime, $cachepath);


  						$this->smarty->assign('localheader', 'Local NDFD Forecast');

  						if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $temp;
                            
  							$this->smarty->display($temp);
  						}
  						WxWebAPI::__destruct();
  			}

  			function get_data($url, $cachet, $cache_file)
  			{


  						//	$fetch = new FetchData($this->debug, $this->form, $this->conf, $this->smarty, $this->database);
  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);

  						$parser = new NoaaParseDwml($this->keyMap);
  						$parsedDWML = $parser->parseDwml($rawdata);
  						
                        
                        
                        if (is_array($parsedDWML))
                        {
                            $this->parse_xml($parsedDWML, $rawdata);
                        }         
                        else
                        {
                            require_once(LIBPATH .'/Zone/NWSZfp.php');
                            $runconf = parse_ini_file(CONFIGS .'/zone.conf.php', TRUE);
                            $zone = new NWSZfp($runconf, $this->form, $this->fetch, $this->conf, $this->debug, $this->smarty);
                            $zone->get_zone();
                            exit;
                            
                            
                            
                            
                            
                        }

  			}


  			function parse_xml($parsed, $raw)
  			{


  						if (preg_match('/<creation-date.+?>(\d\d\d\d)\-(\d\d)\-(\d\d)T(\d\d)\:(\d\d)\:\d\d\-(\d\d)\:\d\d</', $raw, $tt))
  						{
  									$epoch = gmmktime($tt[4] + $tt[6], $tt[5], 0, $tt[2], $tt[3], $tt[1]);
  									$this->smarty->assign('for_date', gmdate('l M d g:i A', $epoch - 3600 * $tt[6]));
  						}

  						if (preg_match('/<layout\-key>k\-p12h\-n\d\d?\-\d(.+?)<layout-key>k-p24h/s', $raw, $dd))
  						{
  									$layout = $dd[1];
  						}
  						if (preg_match_all('/period\-name\=\"(.+?)\"/', $layout, $es))
  						{
  									for ($y = 0; $y < count($es[0]); $y++)
  									{

  												$daynames[$y] = preg_replace($this->replacetitles, $this->replacedays, strtolower($es[1][$y]));
  												$daynames[$y] = preg_replace("/\s/", "<br/>", $daynames[$y]);
  									}
  						}


  						$i = 0;
  						$this->smarty->assign('nightflag', '0');
  						$NWSicon = $Dayicon = $DayNames = $Dayhi = $Daylo = $Daytime = $Daypop = $Daywx = $Daycast = $DayNameFormal = $DayDateFormal =
  									array();

  						if ($this->debug)
  									print_r($parsed);

  						foreach ($parsed as $day)
  						{

  									array_push($DayNames, ucwords($daynames[$i]));
  									array_push($Dayhi, $day['temperature_maximum']);
  									array_push($Daylo, $day['temperature_minimum']);
  									array_push($Daytime, $day['start_valid_time_calculated']);
  									array_push($Daypop, $day['probability_of_precipitation_12_hour']);
  									array_push($Daywx, $day['weather']);
  									array_push($Daycast, $day['worded_forecast']);
  									array_push($NWSicon, $day['conditions_icon_forecast_NWS']);

  									array_push($Dayicon, $this->hicon($day['weather'], $daynames[$i]));

  									if (date('H', strtotime($day['start_valid_time'])) >= '16')
  									{
  												$daynight = " Night";
  									} elseif (date('H', strtotime($day['start_valid_time'])) >= '00' && date('H', strtotime($day['start_valid_time'])) <= '05')
  									{
  												$daynight = " Morning";
  									} else
  									{
  												$daynight = '';
  									}

  									array_push($DayNameFormal, date('l', strtotime($day['start_valid_time'])) . $daynight);
  									array_push($DayDateFormal, date('F j', strtotime($day['start_valid_time'])));

  									if (preg_match('/(night|morning)/i', $daynames[0]))
  									{
  												$this->smarty->assign('nightflag', '1');
  									}
  									$i++;
  						}


  						$this->smarty->assign('DayNames', $DayNames);
  						$this->smarty->assign('Dayhi', $Dayhi);
  						$this->smarty->assign('Daylo', $Daylo);
  						$this->smarty->assign('Daypop', $Daypop);
  						$this->smarty->assign('Daywx', $Daywx);
  						$this->smarty->assign('Daycast', $Daycast);
  						$this->smarty->assign('Dayicon', $Dayicon);
  						$this->smarty->assign('DayNameFormal', $DayNameFormal);
  						$this->smarty->assign('DayDateFormal', $DayDateFormal);
  						$this->smarty->assign('DayCount', $i);
  						$this->smarty->assign('NWSicon', $NWSicon);


  						//$this->smarty->caching = true;
  						//$this->smarty->cache_lifetime = 120;


  			}


  			function get_wx_item($wx)
  			{

  						error_reporting(0);
  						$wxinfo = '';

  						$wx = preg_replace("/\//", " or ", $wx);
  						//echo "$wx<br/>";

  						$wxparms = file_get_contents(CONFIGS . "/ndfd.ini.php");
  						$wxparms = preg_replace("/<\?/", "", $wxparms);
  						$wxparms = preg_replace("/\/\*/", "", $wxparms);
  						$wxparms = preg_replace("/\[.+?\]/", "", $wxparms);
  						$lines = preg_split('/[\r\n]/', $wxparms);
  						foreach ($lines as $line)
  						{
  									if (!$line)
  												continue;

  									list($key, $wxitems) = @preg_split("/\=/", $line);
  									$key = str_replace('/', ' or ', $key);

  									if (preg_match("/" . $wx . "/i", $key))
  									{
  												$wxinfo = $wxitems;
  												break;
  									}
  						}
  						//echo "$wxinfo ... $wx ... $key<br>";
  						return $wxinfo;
  			}

  			function hicon($wx, $day)
  			{

  						$wxinfo = $this->get_wx_item($wx);

  						$wxdata = explode('|', $wxinfo);

  						if (preg_match('/night/i', $day, $rr))
  						{
  									return $wxdata[2];
  						} else
  						{

  									return $wxdata[1];
  						}
  			}


  }

?>
