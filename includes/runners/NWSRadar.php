<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->4/22/2013 16:20:12<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name NWSRadar.php
   * @version 2
   * @revision .0
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  class NWSRadar extends WxWebAPI
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

  			function fetch_radar()
  			{
  						$run = $this->form['run'];

  						list($this->temp, $cachet, $runner) = explode("|", $this->conf[$run . '_settings']);

  						$radar = (isset($this->conf['radar_icao'])) ? strtoupper($this->conf['radar_icao']) : $this->form['radar_icao'];
  						$radtype = (isset($this->form['radtype'])) ? strtoupper($this->form['radtype']) : 'N0R';

  						$url = $this->conf[$run . '_url'] . $this->conf[$run . '_url_tail'];

  						$this->urlhttp = $this->conf[$run . '_url'];


  						$radar = preg_replace('/[KPT](\w\w\w)/', "$1", $radar);

  						$this->ridge_url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$this->cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->conf[$run . '_cache']);

  						$this->radar_icao = $radar;
  						$this->radtype = $radtype;

  						$this->smarty->assign('radtype', $radtype);
  						$this->smarty->assign('radar', $radar);

  						$this->smarty->display($this->temp);

  			}
            function fetch_radarlite()
  			{
  						$run = $this->form['run'];

  						list($this->temp, $cachet, $runner) = explode("|", $this->conf[$run . '_settings']);

  						$radar = (isset($this->conf['radar_icao'])) ? strtoupper($this->conf['radar_icao']) : $this->form['radar_icao'];
  						$radtype = (isset($this->form['radtype'])) ? strtoupper($this->form['radtype']) : 'N0R';

  						$url = $this->conf[$run . '_url'] . $this->conf[$run . '_url_tail'];

  						$this->urlhttp = $this->conf[$run . '_url'];


  						$radar = preg_replace('/[KPT](\w\w\w)/', "$1", $radar);

  						$this->ridge_url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$this->cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->conf[$run . '_cache']);

  						$this->radar_icao = $radar;
  						$this->radtype = $radtype;

  						$this->smarty->assign('radtype', $radtype);
  						$this->smarty->assign('radar', $radar);

  						$this->smarty->display($this->temp);

  			}
            
            
            
            function fetch_radar_loop()
  			{
  						$run = 'nwsradarloop';

  						list($this->looptemp, $cachet, $runner) = explode("|", $this->conf[$run . '_settings']);

  						$radar = (isset($this->conf['radar_icao'])) ? strtoupper($this->conf['radar_icao']) : $this->form['radar_icao'];
  						$radtype = (isset($this->form['radtype'])) ? strtoupper($this->form['radtype']) : 'N0R';

  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];

  						
  						$radar = preg_replace('/[KPT](\w\w\w)/', "$1", $radar);

  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);

  						                       
                        $this->rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);

  						$this->smarty->assign('radtype', $radtype);
  						$this->smarty->assign('radar', $radar);
                        
                        NWSRadar::assemble_loop();

        }
        
        
        
        function assemble_loop()
        {
            $rawdata = $this->rawdata;
            
            
            if (preg_match('/<PARAM NAME=\"FlashVars\" value=\"(.+?)\">/is', $rawdata,$t))
            {
                $flasharray = $t[1] . "&image_base = http://radar.weather.gov/ridge";
            }
            
            $this->smarty->assign('flashvars',$flasharray);
            
            $this->smarty->display($this->looptemp);
        }


  }

?>
