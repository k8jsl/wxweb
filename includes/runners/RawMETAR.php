<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->2/3/2013 12:37:06<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name RawMETAR.php
   * @version 1
   * @revision .04
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  require (LIBPATH . "/METAR/parseMetar.php");

  class RawMETAR extends WxWebAPI
  {
  			var $decoded_metar = array();

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

  			function fetch_metar()
  			{
  						

  						list($temp, $cachetime, $runner) = explode("|", $this->runconf['metar_settings']);


  						$url = $this->runconf['metar_url'] . $this->runconf['metar_url_tail'];

  						$icao = (isset($this->form['icao'])) ? strtoupper($this->form['icao']) : strtoupper($this->conf['icao1x']);

  						$turl = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cachepath = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf['metar_cache']);


  						$metardate = RawMETAR::get_metar($turl, $cachetime, $cachepath);
                        
                        $metarage = (isset($this->conf['metar_age']) ? $this->conf['metar_age'] : '90');
                        
                        $metarage = $metarage * 60;
                        $max = time();
                        $max -= $metarage;
                        
                        if ($max > $metardate)
                        {
                        
                        $url = $this->runconf['metar_url'] . $this->runconf['metar_url_tail'];

  						$icao = strtoupper($this->conf['icao2x']);

  						$turl = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cachepath = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf['metar_cache']);


  						$metardate = RawMETAR::get_metar($turl, $cachetime, $cachepath);
                           }
                           
                           
  						$mtime = gmdate('l M d g:i A', $metardate + $this->conf['tzoff'] * 3600) . " " . $this->conf['tzname'];

  						$this->smarty->assign('metarupdate', $mtime);


  						if (!isset($this->form['internal']))
  						{
  						    $temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $temp;
                            
  							$this->smarty->display($temp);
  						} else
  						{
  									$this->database->get_icao($icao);
  						}
  			}

  			function get_metar($url, $cachet, $cache_file)
  			{

  						if ($this->debug)
  						{
  									echo "METAR url $url\n";
  									echo "METAR cache $cache_file\n";
  						}


  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);

  						if ($this->debug)
  						{
  									echo "here $rawdata\n";
  						}

  						$parser = new parseMetars($this->debug, $this->form, $this->smarty, $this->conf);
  						$this->decodedMetar = $parser->decode_metar($rawdata);

  						$metardate = $this->parse_data($rawdata);
  						if ($this->debug)
  									echo "metar epoch $metardate<br>";
  						return $metardate;
  			}


  			function parse_data($rawmetar)
  			{


  						foreach ($this->decodedMetar as $key => $value)
  						{

  									$this->smarty->assign('metar' . $key, $value);
  									if ($key == 'created')
  									{
  												$metarforedate = $value;
  									}

  						}

  						return $metarforedate;


  						WxWebAPI::__destruct();

  			}


  }

?>
