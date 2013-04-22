<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->4/22/2013 16:47:20<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name WxWebAPI.php
   * @version 3
   * @revision .03CA
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */
  require_once (LIBPATH . "/FetchData.inc.php");
  require_once (LIBPATH . "/Astro.inc.php");
  require_once (LIBPATH . "/ConfigStruct.inc.php");

    
  require (LIBPATH . "/dataBase/". SQLEXT . ".inc.php");


  class WxWebAPI
  {

  			var $smarty = '';
  			var $database = '';
  			var $fetch = '';
  			var $version = '3.04.4';
            

  			function __construct($debug, $form, $conf, $mysql, $smarty)
  			{
  						$this->debug = $debug;
  						$this->form = $form;
  						$this->conf = $conf;
  						$this->mysql = $mysql;
  						$this->smarty = $smarty;

  						$this->database = new MySQL($this->debug,$this->conf, $this->mysql, $this->smarty);
  						$this->fetch = new FetchData($this->debug, $this->form, $this->conf, $this->smarty, $this->database);
                        $this->combine = new ConfigStruct();
                        

  						$this->smarty->caching = false;
  						$this->smarty->setTemplateDir(INCLU . '/templates');
  						$this->smarty->setCompileDir(SMARTY_DIR . '/templates_c');
  						$this->smarty->setCacheDir(SMARTY_DIR . '/cache');
  						$this->smarty->setConfigDir(INCLU . '/configs/');

  						$this->smarty->assign('name', SITENAME);
  						$this->smarty->assign('csspath', WXURL . '/includes/css/');
  						$this->smarty->assign('jspath', WXURL . '/includes/js/');
  						$this->smarty->assign('imgpath', WXURL . '/images');
  						$this->smarty->assign('iconspath', WXURL . '/images/wxicons/');
  						$this->smarty->assign('googleapi', GOOGLEAPI);
  						$this->smarty->assign('wxurl', WXURL);
  						$this->smarty->assign('scriptname', SCRIPTNAME);
  						$this->smarty->assign('run', $this->form['run']);
                        $this->smarty->assign('wxwebapiversion' , $this->version);
                        
                        
                        
                
  			           
                        
  						WxWebAPI::_debug();
  						WxWebAPI::_cleancache();
                        WxWebAPI::_wwvars($this->form);

  			}

  			function runner($form,$runconf)
  			{
  						$run = (!empty($form['run'])) ? $form['run'] : $this->conf['run'];
                        $dpp = '0';
                        
                        if (strtoupper($run) == 'ASTRO')
                        {
                            $var = WxWebAPI::_GETDb_Object($runconf);
                            $astro = new AstroInfo($form,$var,$this->smarty);
                            $astro->Astro();
                            
                        }
                                             
                        else
                        {
                        
                        
                        $rundata = explode("|", $runconf[$run . '_settings']);
                        
                        
                        if ($this->debug)
                        {
                            echo "API::runner " . var_dump($form);
                        }
                        
                        

                        list($temp, $cachetime, $runner, $function, $dpp) = explode("|", $runconf[$run . '_settings']);
  
                        
                       
  						if ($this->debug)
  						{
  									echo "$temp,$cachetime,$runner,$function ,$dpp\n";

  						}
                        
                        $fdpp = (!empty($form['dpp']) && $form['dpp'] == '0') ? '0' : $dpp;
                        $fdpp = (!empty($form['dpp']) && $form['dpp'] == '1') ? '1' : $fdpp;
                       
                       
                       
                       
                        if ($fdpp == '1')
                        {
                            $var = WxWebAPI::_GETDb_Object($runconf);
                            $this->conf = $this->combine->_arrayMergeRecursive($this->conf, $var);
                            
                        }
                      //  else
                      //  {
                      //      $this->conf = $this->conf;
                      //  }
                       
  						$this->__autoload($runner);
  						$run = new $runner($runconf,$form,$this->database, $this->fetch,$this->conf,$this->debug,$this->mysql,$this->smarty);
  						$run->{$function}();
                        
                        } // end else Astro


  			}


  			function __autoload($class)
  			{
  						require_once (RUNNERS . "/" . $class . ".php");
  			}

  			function main()
            {
                
  						
  			}

  			function _debug()
  			{

  						if ($this->debug == '1')
  						{
  									error_reporting(E_ALL);
  									$this->smarty->debugging = true;
  						}
  						if ($this->debug)
  						{
  									print "<p align=\"left\">
        ######################################################<br>
        #<br>
        #   WxWebAPI " . $this->version . "<br>
        #   Copyright 2010 - " . gmdate('Y') . "<br/>
        #<br>
        #   Date/Time: Local " . date('r') . " " . gmdate('r') . "<br>
        #   Common Paths:<br>
        #   Includes : " . INCLU . "<br>
        #   Smarty   : " . SMARTY_DIR . "<br>
        #   Libraries: " . LIBPATH . "<br />
        #   Core     : " . WXSITE . "<br />
        #   DST      : " . DST . " <br/>
        ######################################################<br>
        <hr>
        Global conf array after MySQL/ProcessInput<br/>
        <pre> ";
  									print_r($this->conf);
                                    
  									echo "<pre></p>";

  						}


  			}

  			function _cleancache()
  			{
  						$now = time();
  						$now -= 60 * 60;

  						$handle = opendir(CACHE);
  						while (false !== ($file = readdir($handle)))
  						{
  									if ($file != "." && $file != ".." && filectime(CACHE . '/' . $file) < $now)
  									{

  												unlink(CACHE . "/" . $file);
  									}
  						}

  			}

  			function __destruct()
  			{

  			}
            
            function _wwvars($parms)
            {
                
                foreach($parms as $key => $value)
                {
                    if (preg_match('/ww\w+/' , $key))
                    {
                        $this->smarty->assign($key , $value);
                    }
                }
                
            }
            
function _GETDb_Object($conf)
  			{
  						$form = $this->form;


  						$var = array();

  						if (!empty($form['locname']) && !empty($form['state']))
  						{
  									$fcity = $form['locname'];
  									$fstate = $form['state'];
  									$fcountry = (!empty($form['country'])) ? $form['country'] : 'US';


  									if ($this->debug)
  												echo "form $fcity .. $fstate " . $fcountry . "<br>";
  									$var = $this->database->get_global($fcity, $fstate, $fcountry);

  						} elseif (!(empty($form['lat'])) && preg_match('/\d+\.\d+/', $form['lat']) && !(empty($form['lon'])) && preg_match('/-\d+\.\d+/', $form['lon']))
  						{
  									if ($this->debug)
  												echo "lat lon";

  									$var = $this->database->get_location($form['lat'], $form['lon']);
  						} elseif (!(empty($form['location'])) && preg_match('/\d\d\d\d\d/', $form['location']))
  						{
  									if ($this->debug)
  												echo "location zip run";


  									$var = $this->database->get_zip($form['location']);
  						} elseif (!(empty($form['location'])) && preg_match('/,/', $form['location']))
  						{
  									if ($this->debug)
  												echo "location\n";

  									$ids = explode(",", $form['location']);

  									$idtotal = count($ids);

  									if ($this->debug)
  												echo "Form total $idtotal\n";

  									if ($idtotal == '2')
  									{
  												$fstate = trim($ids[1]);
  												$fcity = trim($ids[0]);
  												$fcountry = 'US';
  									} elseif ($idtotal == '3')
  									{
  												$fstate = trim($ids[1]);
  												$fcity = trim($ids[0]);
  												$fcountry = 'CA';
  									}

  									if ($this->debug)
  												print "Fstate $fstate, $fcity, $fcountry\n";

  									$var = $this->database->get_global($fcity, $fstate, $fcountry);
  						} elseif (!(empty($form['location'])) && !preg_match('/,/', $form['location']))
  						{
  									if ($this->debug)
  												echo "multiple location";


  									$fcity = trim($form['location']);

  									$this->database->Get_multiple($fcity);
  						} elseif (!(empty($form['zone'])) && preg_match('/\w\wC\d\d\d/i', $form['zone']))
  						{

  									$var = $this->database->get_county($form['zone']);

  						} elseif (!(empty($form['zone'])) && preg_match('/\w\wZ\d\d\d/i', $form['zone']))
  						{

  									$var = $this->database->get_zone($form['zone']);

  						} elseif (!isset($form['location']) || !isset($form['lat']) || !isset($form['locname']))
  						{

  									$var = $this->database->get_global($this->conf['default Settings']['location'], $this->conf['default Settings']['state'], 'us');


  						}
  						if ($this->debug)
  						{
  									echo "Process Database:: " . var_dump($var);
  						}
  						return $var;

  			}
 

  } //end class


?>
