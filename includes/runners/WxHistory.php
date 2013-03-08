<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->9/15/2012 18:17:36<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name WxHistory.php
   * @version 2
   * @revision .01
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  class WxHistory extends WxWebAPI
  {

  			function __construct($runconf, $form, $database, $fetch, $conf, $debug, $mysql, $smarty)
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
  			function fetch_wxhistory()
  			{
  						$run = 'wxhistory';

  						list($this->temp, $cachet, $runner) = explode("|", $this->runconf[$run . '_settings']);


  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						$icao = (isset($this->form['icao'])) ? $this->form['icao'] : $this->conf['icao1x'];
  						$icao = strtoupper($icao);
                        
                        $this->icao = $icao;

  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);

  						$rawdata = $this->fetch->fetch_URL($url, $cache, $cachet);

  						if ($this->debug)
  									print $url;


  						$this->parse_data($rawdata);


  			}

  			function parse_data($raw)
  			{
  						$wxhistory_date = array();
  						$wxhistory_time = array();
  						$wxhistory_wind = array();
  						$wxhistory_vis = array();
  						$wxhistory_wx = array();
  						$wxhistory_skycond = array();
  						$wxhistory_temp = array();
  						$wxhistory_dwpt = array();
  						$wxhistory_rh = array();
  						$wxhistory_wc = array();
  						$wxhistory_hi = array();
  						$wxhistory_maxtemp = array();
  						$wxhistory_mintemp = array();
  						$wxhistory_pressalt = array();
  						$wxhistory_pressmb = array();
  						$wxhistory_precipone = array();
  						$wxhistory_precipthree = array();
  						$wxhistory_precipsix = array();
                        $wxhistory_today = array();
                        $wxhistory_yesterday = array();
                        $wxhistory_icon = array();

  						if (preg_match_all('/<td>(\d+)<\/td><td.+?>([\d\:]+)<\/td><td>([\w\d\s]+)<\/td><td>([\d\.]+)<\/td><td.+?>([^,\n]+)<\/td>' .
  									'<td>([^,\n]+)<\/td><td>(-?\d+)<\/td><td>(-?\d+)<\/td>' . '\s+?<td>(?:(-?\d+)|)<\/td><td>(?:(-?\d+)|)<\/td>' . '<td>([\d]+\%)<\/td><td>(NA|[\d\.]+)<\/td><td>(NA|[\d\.]+)<\/td><td>([\d\.]+)<\/td>' .
  									'<td>(NA|[\d\.]+)<\/td><td>(|\d+\.\d+)<\/td><td>(|\d+\.\d+)<\/td><td>(|\d+\.\d+)<\//s', $raw, $m))
  						{

  									if ($this->debug)
  												echo "size  of " . sizeof($m[0]);
  									for ($i = 0; $i < sizeof($m[0]); $i++)
  									{
  									 
                                     if ($i == '0')
                                     {
                                        $today = $m[1][0];
                                        
                                        $today_precip = $m[16][0];
                                     }
                                     if ($today == $m[1][$i])
                                     {
                                        array_push($wxhistory_today,$m[7][$i]);
                                        
                                        $today_precip += $m[16][$i];
                                     }
                                     


  												array_push($wxhistory_date, $m[1][$i]);
  												array_push($wxhistory_time, $m[2][$i]);
  												array_push($wxhistory_wind, $m[3][$i]);
  												array_push($wxhistory_vis, $m[4][$i]);
  												array_push($wxhistory_wx, $m[5][$i]);
  												array_push($wxhistory_skycond, $m[6][$i]);
  												array_push($wxhistory_temp, $m[7][$i]);
  												array_push($wxhistory_dwpt, $m[8][$i]);
  												array_push($wxhistory_maxtemp, $m[9][$i]);
  												array_push($wxhistory_mintemp, $m[10][$i]);
  												array_push($wxhistory_rh, $m[11][$i]);
  												array_push($wxhistory_wc, $m[12][$i]);
  												array_push($wxhistory_hi, $m[13][$i]);
  												array_push($wxhistory_pressalt, $m[14][$i]);
  												array_push($wxhistory_pressmb, $m[15][$i]);
  												array_push($wxhistory_precipone, $m[16][$i]);
  												array_push($wxhistory_precipthree, $m[17][$i]);
  												array_push($wxhistory_precipsix, $m[18][$i]);
                                                
                                                
                                                list($hr,$min) = explode(":" , $m[2][$i]);
                                                                         
                                               
                                                $wxicon = $this->hicon($m[5][$i], $hr);
                                                array_push($wxhistory_icon, $wxicon);
                                               
                                                
                                                

  									}
                                    $today_mintemp = min($wxhistory_today);
                                    $today_maxtemp = max($wxhistory_today);
                                    $this->smarty->assign('wxhistory_icon', $wxhistory_icon);
                                    $this->smarty->assign('wxhistory_maxt', $today_maxtemp);
                                    $this->smarty->assign('wxhistory_mint', $today_mintemp);
                                    $this->smarty->assign('wxhistory_maxpre', $today_precip);
  									$this->smarty->assign('wxhistory_date', $wxhistory_date);
  									$this->smarty->assign('wxhistory_time', $wxhistory_time);
  									$this->smarty->assign('wxhistory_wind', $wxhistory_wind);
  									$this->smarty->assign('wxhistory_vis', $wxhistory_vis);
  									$this->smarty->assign('wxhistory_wx', $wxhistory_wx);
  									$this->smarty->assign('wxhistory_skycond', $wxhistory_skycond);
  									$this->smarty->assign('wxhistory_temp', $wxhistory_temp);
  									$this->smarty->assign('wxhistory_dwpt', $wxhistory_dwpt);
  									$this->smarty->assign('wxhistory_maxtemp', $wxhistory_maxtemp);
  									$this->smarty->assign('wxhistory_mintemp', $wxhistory_mintemp);
  									$this->smarty->assign('wxhistory_rh', $wxhistory_rh);
  									$this->smarty->assign('wxhistory_wc', $wxhistory_wc);
  									$this->smarty->assign('wxhistory_hi', $wxhistory_hi);
  									$this->smarty->assign('wxhistory_pressalt', $wxhistory_pressalt);
  									$this->smarty->assign('wxhistory_pressmb', $wxhistory_pressmb);
  									$this->smarty->assign('wxhistory_precipone', $wxhistory_precipone);
  									$this->smarty->assign('wxhistory_precipthree', $wxhistory_precipthree);
  									$this->smarty->assign('wxhistory_precipsix', $wxhistory_precipsix);
  									$this->smarty->assign('wxhistory_icao', $this->icao);
  									$this->smarty->assign('wxhistory_place', $this->var['mname1x']);
  									$this->smarty->assign('wxhistory_total', $i);


  						}

  						if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $this->temp;
                            
  							$this->smarty->display($temp);
  						}

  						WxWebAPI::__destruct();
  			}
            
            
            function get_wx_item($wx)
  			{
  						$wxinfo = '';

  						$wx = preg_replace("/\//", " or ", $wx);
  						//echo "$wx<br/>";

  						$wxparms = file_get_contents(CONFIGS . "/metaricon.ini.php");
  						$wxparms = preg_replace("/<\?/", "", $wxparms);
  						$wxparms = preg_replace("/\/\*/", "", $wxparms);
  						$wxparms = preg_replace("/\[.+?\]/", "", $wxparms);
  						$lines = preg_split('/[\r\n]/', $wxparms);
  						foreach ($lines as $line)
  						{
  									if (!$line)
  												continue;

  									list($key, $wxitems) = preg_split("/\=/", $line);
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

  			function hicon($wx, $hr)
  			{

  						$wxinfo = $this->get_wx_item($wx);

  						$wxdata = explode('|', $wxinfo);

  						if ($hr >= $this->conf['Day Light']['day_start'] && $hr < $this->conf['Day Light']['day_end'])
  						{
  									return $wxdata[1];
  						} else
  						{

  									return $wxdata[2];
  						}
  			}


  }

?>
