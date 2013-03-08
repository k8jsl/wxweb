<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->8/1/2012 14:27:28<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name rawtext.php
   * @version 1
   * @revision .01
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  class RawText extends WxWebAPI
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


  			function fetch_rawtext()
  			{


  						$cwa = (!empty($this->form['cwa'])) ? $this->form['cwa'] : $this->conf['cwa'];
                        
                        $cwa = strtoupper($cwa);

  						$run = $this->form['run'];

  						list($this->temp, $cachet, $runner) = explode("|", $this->runconf[$run . '_settings']);

  						$url = $this->runconf[$run . '_url'] . $this->runconf[$run . '_url_tail'];


  						$url = preg_replace("/\{(\w+)\}/e", '$$1', $url);
  						$cache_file = preg_replace("/\{(\w+)\}/e", '$$1', $this->runconf[$run . '_cache']);


  						$rawdata = $this->fetch->fetch_URL($url, $cache_file, $cachet);

  						if (preg_match('/Not Found/', $rawdata))
  						{
  									$rawdata = 'Not Available';
  						}
  						$rawdata = preg_replace('/(\d\d\d\s+?\w\w\w\w\d\d\s\w\w\w\w\s\d\d\d\d\d\d\s+?\w\w\w\w\w\w)/s', "", $rawdata);

  						if (preg_match('/\n([\w\s]+)\nNATIONAL WEATHER/s', $rawdata, $t))
  						{
  									$rawtitle = strtolower($t[1]);
  						}
  						$this->smarty->assign('rawtitle', $rawtitle);
  						
  						$this->smarty->assign('rawdata', $rawdata);

  						if (!isset($this->form['internal']))
  						{
  						    $this->temp = (!empty($this->form['temp'])) ? $this->form['temp'] : $this->temp;
  									$this->smarty->display($this->temp);
  						}

  			}

  }

?>
