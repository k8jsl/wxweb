<?php

  /**
 * // <!-- phpDesigner :: Timestamp -->12/9/2012 10:18:38<!-- /Timestamp -->
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWebApi
 * @name NWSWarnings.php
 * @version 1
 * @revision .04
 * @license http://creativecommons.org/licenses/by-sa/3.0/us/
 * 
 * 
 */


  class NWSWarnings extends WxWebAPI
  {


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

  			function fetch_warnings()
  			{
  						$run = $this->form['run'];

  						list($this->temp, $cachet, $runner) = explode("|", $this->runconf[$run . '_settings']);


  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						$warncounty = $this->warncounty = (!empty($this->form['warncounty'])) ? $this->form['warncounty'] : $this->conf['warncounty'];

  						if ($this->debug)
  									print "warncounty $warncounty\n";

  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);


  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);


  						$this->parse_data($rawdata);


  			}


  			function parse_data($raw)
  			{

  						/** set our counters to 0 **/
  						$i = $warntotal = 0;
  						$this->smarty->assign('warntotal', $warntotal);

  						/** set the array's **/
  						$warnbody = $warnname = $warnissue = $warnexpire = array();
                        $body = $type = $issue_time = $expire_time = '';

  						$tz = (DST == '1') ? preg_replace('/S/', "D", $this->conf['tzname']) : $this->conf['tzname'];

  						if (preg_match('/<title>There are no active watches, warnings or advisories/is', $raw)) 
                        {
                            
                        }
  						else
                        {
  									if (preg_match_all('/<entry>.+?<id>(http:\/\/.+?\/.+?php\?x=)([^<]+)<\/id>.+?<\/entry>/s', $raw, $m)) 
  									{
  												for ($i = 0; $i < sizeof($m[0]); $i++)
  												{

  															$data[$i] = $this->_fetch_atom($m[1][$i], $m[2][$i]);

  															if (preg_match('/<description>([^<]+)<\//s', $data[$i], $dd))
  															{
  																		$body = $dd[1];
  															}
  															if (preg_match('/<event>(.+?)<\//', $data[$i], $rr))
  															{
  																		$type = strtoupper($rr[1]);
  															}

  															if (preg_match('/<effective>(\d\d\d\d)-(\d\d)-(\d\d)T(\d\d):(\d\d):00-(\d\d):/', $data[$i], $ee))
  															{
  																		$epoch = gmmktime($ee[4] + $ee[6], $ee[5], '0', $ee[2], $ee[3], $ee[1]);
  																		$issue_time = gmdate('l F j g:i A', $epoch - $ee[6] * 3600) . " " . $tz;

  															}

  															if (preg_match('/<expires>(\d\d\d\d)-(\d\d)-(\d\d)T(\d\d):(\d\d):00-(\d\d):/', $data[$i], $ee))
  															{
  																		$eepoch = gmmktime($ee[4] + $ee[6], $ee[5], '0', $ee[2], $ee[3], $ee[1]);
  																		$expire_time = gmdate('l F j g:i A', $eepoch - $ee[6] * 3600) . " " . $tz;
  															}


  															array_push($warnbody, $body);
  															array_push($warnname, $type);
  															array_push($warnissue, $issue_time);
  															array_push($warnexpire, $expire_time);

  												}
  												$warntotal = $i;
  									}


  									$this->smarty->assign('warnbody', $warnbody);
  									$this->smarty->assign('warnissue', $warnissue);
  									$this->smarty->assign('warnexpire', $warnexpire);
  									$this->smarty->assign('warnname', $warnname);
  									$this->smarty->assign('warntotal', $warntotal);
  						}

  						$this->smarty->assign('localheader', 'Local Advisories');
  						if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $this->temp;
                            
  							$this->smarty->display($temp);
  						}


  			}


  			function _fetch_atom($turl, $file)
  			{

  						$url = $turl . $file;
  						$cache_file = $file . ".xml";

  						//$fetch = new FetchData($this->debug, $this->form, $this->conf, $this->smarty,$this->database);
  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, '15');

  						return $rawdata;

  			}
            
            
            	function fetch_special()
  			{
  						
  						list($this->temp, $cachet, $runner) = explode("|", $this->runconf['special_settings']);


  						$url = $this->runconf['special_url'] . $this->runconf['special_url_tail'];

  						$warncounty = $this->warncounty = (!empty($this->form['warncounty'])) ? $this->form['warncounty'] : $this->conf['warncounty'];
                        $zone = $this->zone = (!empty($this->form['zone'])) ? $this->form['zone'] : $this->conf['zone'];

  						if ($this->debug)
  									print "warncounty $warncounty\n";

  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf['special_cache']);


  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);


  						NWSWarnings::parse_special($rawdata);


  			}
            
            function parse_special($rawdata)
            {
                $debug = $this->debug;
                
                $i =0;
                $this->smarty->assign('specialtotal' , '0');
                $body = $name = $issue = $expire = array();
                if (preg_match_all('/<pre>(.+?)<\/pre>/is' , $rawdata, $m))
                {
                    for($f = 0; $f < count($m[0]); $f++)
                    {
                        if (preg_match('/(SPECIAL WEATHER STATEMENT|HAZARDOUS WEATHER OUTLOOK)(.+?)$/s' , $m[1][$f], $mm))
                        {
                            array_push($name,$mm[1]);
                            array_push($body, rtrim(trim($mm[2])));
                            //                 400    AM      AKST   SUN     DEC 9 2012
                            if (preg_match('/([\d]+\s[A|P]M\s[\w]+\s\w\w\w\s\w\w\w\s[\d]+\s\d\d\d\d)/', $mm[2], $id))
                            {
                                array_push($issue,$id[1]);
                            }
                           
                            
                            $i++;
                        }
                    }
                }
                
                $this->smarty->assign('specialtotal', $i);
                $this->smarty->assign('specialbody', $body);
                $this->smarty->assign('specialname', $name);
                $this->smarty->assign('specialissue', $issue);
               
            }
            
            
            function _edate($date)
  			{
  						if (preg_match('/(\d\d)(\d\d)(\d\d)/', $date, $m))
  						{
  									$mm = gmdate('m');
  									$d = gmdate('d');
  									$y = gmdate('y');
  									$vd = $m[1];
  									$vh = $m[2];
  									$vm = $m[3];
  									if ($vd < $d)
  									{
  												$mm++;
  												if ($mm > 12)
  												{
  															$mm = 1;
  															$y++;
  												}
  									}
  									//$type = $m[4];
  									$epoch = gmmktime($vh, $vm, 0, $mm, $vd, $y);
  									return $epoch;
  						}
  			}


  }

?>
