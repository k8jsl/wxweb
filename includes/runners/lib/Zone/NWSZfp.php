<?php

/**
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWeb
 * @name Untitled 2
 * @version
 */
 
Class NWSZfp{
    
    function __construct($runconf, &$form, $fetch, &$conf, &$debug, $smarty)
  			{

  						$this->debug = &$debug;
  						$this->form = &$form;
  						$this->conf = &$conf;
  						$this->smarty = $smarty;
  						$this->fetch = $fetch;
                        $this->runconf = $runconf;

  			}


  			function get_zone()
  			{
                        $run ='zone';
                        
                        list($this->temp, $cachet, $runner) = explode("|", $this->runconf[$run . '_settings']);


  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						$zone = (!empty($this->form['zone'])) ? $this->form['zone'] : $this->conf['zone'];
  						$state = (!empty($this->form['state'])) ? $this->form['state'] : $this->conf['state'];
                        $cwa = (!empty($this->form['cwa'])) ? $this->form['cwa'] : $this->conf['cwa'];
                        
                        
                        $lc_zone = strtolower($zone);
                        $lc_state = strtolower($state);
                        $lc_cwa = strtolower($cwa);

  						$turl = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);
                        
                        if($this->debug) echo "NWSzfp::turl $turl\n";

  						$rawdata = $this->fetch->fetch_URL($turl, $cache_file,$cachet);
                        if ($this->debug)
                        {
                            echo "In Zone: $rawdata\n";
                        }

  						$this->_parse_data($rawdata);

  			}
            
            Function _parse_data($data)
            {
                //1027 PM EDT THU JUL 12 2012
                if (preg_match('/([\d]+\sA[P|M]\s\w\w\w\s\w\w\w\s\w\w\w\s[\d]+\s[\d]+)/' , $data, $t))
                {
                    $this->smarty->assign('update', $t[1]);
                }
                
                $daycast = $days = $temps = $daypop = $dayfcast = $dayicon = array();
                
                //$data = preg_replace('/[\r\n]/', " ", $data);
                
                if (preg_match('/(\.[\w\s]+\.\.\..+?)\$\$/s' , $data, $t))
                {
                    $fsection = "\n".$t[1];
                }
                
                
                
                $periods = preg_split('/[\r\n]\.[A-Z\s]+\.\.\./', $fsection);
                
                
                
                
                if (preg_match_all('/[\r\n]\.([\sA-Z]+)\.\.\./s' , $fsection, $ff))
                {
                    for ($i=0; $i<count($ff[0]); $i++)
                    {
                        array_push($days,strtolower($ff[1][$i]));
                        array_push($dayfcast,strtolower($periods[$i+1]));
                        
                        
                        list($wx,$icon) = $this->get_wx_item($periods[$i+1],$ff[1][$i]);
                        
                        array_push($daycast,strtolower($wx));
                        array_push($dayicon,$icon);
                                               
                    }
                }
                
                    $this->smarty->assign('DayNames', $days);
    				$this->smarty->assign('Dayhi', '');
    				$this->smarty->assign('Daylo', '');
    				$this->smarty->assign('Daypop', '');
    				$this->smarty->assign('Daywx', $daycast);
    				$this->smarty->assign('Daycast', $dayfcast);
    				$this->smarty->assign('Dayicon', $icon);
                    $this->smarty->assign('DayNameFormal', '');
                    $this->smarty->assign('DayDateFormal', '');
                    $this->smarty->assign('DayCount' , $i);
                    $this->smarty->assign('NWSicon', '');
                
                if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $this->temp;
                            
  							$this->smarty->display($temp);
  						}
            }
            
            
            
            function get_wx_item($wx,$day)
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
    						if (!$line) continue;

    						list($key, $wxitems) = @preg_split("/\=/", $line);
    						$key = str_replace('/', ' or ', $key);
                            
    						if (preg_match("/" . $key . "/i", $wx))
    						{
    								$wxinfo = $wxitems;
    								break;
    						}
    				}

    				list($daywx,$icon) = $this->wx_icon($wxinfo,$day,$key);
                    return array($daywx,$icon);
    		}

    		function wx_icon($wxinfo,$day,$wx)
    		{

    				
        

    				$wxdata = explode('|', $wxinfo);

    				if (preg_match('/night/i', $day, $rr))
    				{
    						return array($wx,$wxdata[2]);
    				}
    				else
    				{

    						return array($wx,$wxdata[1]);
    				}
    		}

}

?>
