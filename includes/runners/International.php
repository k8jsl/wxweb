<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->10/5/2012 11:54:38<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name International.php
   * @version 2
   * @revision .00
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  
  class International extends WxWebAPI
  {
  			var $hour = '';
            var $fetch = '';
            var $form = array();
            
            

  			protected $replacetitles = array(
  						'/monday/',
  						'/monday night/',
  						'/tuesday/',
  						'/tuesday night/',
  						'/wednesday/',
  						'/wednesday night/',
  						'/thursday/',
  						'/thursday night/',
  						'/friday/',
  						'/friday night/',
  						'/saturday/',
  						'/saturday night/',
  						'/sunday/',
  						'/sunday night/');
  			protected $replacedays = array(
  						'Mon',
  						'Mon Night',
  						'Tue',
  						'Tue Night',
  						'Wed',
  						'Wed Night',
  						'Thur',
  						'Thur Night',
  						'Fri',
  						'Fri Night',
  						'Sat',
  						'Sat Night',
  						'Sun',
  						'Sun Night');
  			

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

  			function get_forecast()
  			{


  						$run = 'international';
                        
                        

  						list($this->temp, $cachet, $runner) = explode("|", $this->runconf[$run . '_settings']);

  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						$lat = (!empty($this->form['lat'])) ? $this->form['lat'] : $this->conf['lat'];
  						$lon = (!empty($this->form['lon'])) ? $this->form['lon'] : $this->conf['lon'];

  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);

  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);

  						


  						$this->parse_data($rawdata);
  						

  			}


  			function parse_data($raw)
  			{


  						$i = $d = 0;
  						$dayname_shrt =$MaxC = $MinC= $MaxF = $MinF = $pop = $wx = $icon = array();
  						$windmph = $windkph = $winddir = $winddireng = $precip = $newdates = array();

  						$lines = preg_split('/[\r\n]/' , $raw);
                        
                        foreach ($lines as $line)
                        {
                          //  if (preg_match('/^\#/' , $line)) continue;
                            if (!preg_match('/^\d\d\d\d-\d\d-\d\d.+?$/' , $line)) continue;
                          
                            
                            list($date,$tempMaxC,$tempMaxF,$tempMinC,$tempMinF,$windspeedMiles,$windspeedKmph,
                            $winddirDegree,$winddir16Point,$weatherCode,$weatherIconUrl,$weatherDesc,$precipMM) = explode(",", $line);
                        
                        array_push($MaxC,$tempMaxC);
                        array_push($MaxF,$tempMaxF);
                        array_push($MinC,$tempMinC);
                        array_push($MinF,$tempMinF);
                        list($yr,$mn,$day) = explode("-",$date);
                        $epoch = gmmktime(12,0,0,$mn,$day,$yr);
                        $datest = gmdate('D M jS', $epoch);
  						array_push($newdates, $datest);
                        
                        array_push($windmph,$windspeedMiles);
                        array_push($windkph,$windspeedKmph);
                        array_push($winddir,$winddirDegree);
                        array_push($winddireng,$winddir16Point);
                        
                        array_push($wx,$weatherDesc);
                        array_push($precip,$precipMM);
                        
                        list($wxicon,$cleanwx) = International::tab_icon($weatherDesc,'12');
                        
                        array_push($icon,$wxicon);
                        
                        }
                                    
                                   

                    

  						$this->smarty->assign('QCMaxF', $MaxF);
  						$this->smarty->assign('QCMinF', $MinF);
                        $this->smarty->assign('QCMaxC', $MaxC);
  						$this->smarty->assign('QCMinC', $MinC);
  						
  						$this->smarty->assign('QCwx', $wx);
  						$this->smarty->assign('QCicon', $icon);
  					
                        $this->smarty->assign('QCdays', $newdates);
                        $this->smarty->assign('QCcount' , count($wx));

  						if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $this->temp;
                            
  									$this->smarty->display($temp);
  						}

  						WxWebAPI::__destruct();

  						


  			}


  			function tab_wx_item($wx)
  			{
  						$wxinfo = '';
  						error_reporting(0);

  						$wx = preg_replace("/\//", " or ", $wx);
  						$wx = preg_replace("/<br.+?>/", " ", $wx);

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
  						if ($this->debug)
  									print "[$wx] $hour_id<br>";
  						$wxinfo = $this->tab_wx_item($wx);


  						$wxdata = explode('|', $wxinfo);


  						if ($hour_id == 'day')
  						{
  									return array($wxdata[1], $wxdata[0]);
  						} else
  						{
  									return array($wxdata[2], $wxdata[0]);
  						}


  			}


  }

?>
