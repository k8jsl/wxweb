<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->1/10/2013 10:37:55<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name ProcessInput.php
   * @version 1
   * @revision .04
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * 
   * 
   */


  if (isset($_SERVER['argv']))
  {

  			foreach ($_SERVER['argv'] as $key => $value)
  			{


  						list($pref, $data) = explode("=", $value);

  						$form[$pref] = $data;

  			}
  }

  if (isset($_GET))
  {
  			foreach ($_GET as $key => $value)
  			{
  						$value = preg_replace('/[^A-Za-z0-9\+\.,\_\- ]/', "", $value);

  						$form[$key] = $value;
  			}
  }

  $debug = (!empty($form['debug'])) ? $form['debug'] : '';


  /** Config sections **/

  require_once (LIBPATH . "/ConfigStruct.inc.php");
  $combine = new ConfigStruct();

  $runconf = array();
  $runconf = (!empty($form['run'])) ? parse_ini_file(CONFIGS . "/" . strtolower($form['run']) . ".conf.php", true) : parse_ini_file(CONFIGS .
  			"/" . strtolower($conf['default Settings']['run']) . ".conf.php", true);


  $conf = $combine->_arrayMergeRecursive($conf, $runconf);

  $newconf = array();
  $newconf = (isset($conf['NEWCONFIG'])) ? parse_ini_file(CONFIGS . "/" . $conf['NEWCONFIG'] . ".conf.php", true) : '';

  if (isset($conf['NEWCONFIG']))
  {
  			$conf = $combine->_arrayMergeRecursive($conf, $newconf);
  }

  if (!empty($form['conf']))
  {

  			$confs = explode(",", $form['conf']);

  			if (count($confs))
  			{
  						foreach ($confs as $cfg)
  						{

  									$new = parse_ini_file(CONFIGS . '/' . $cfg . '.conf.php', true);
  									$conf = $combine->_arrayMergeRecursive($conf, $new);
  						}
  			} else
  			{
  						$new = parse_ini_file(CONFIGS . '/' . $form['conf'] . '.conf.php', true);
  						$conf = $combine->_arrayMergeRecursive($conf, $new);
  			}
  }




?>
