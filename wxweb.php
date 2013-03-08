<?php

  /**
   * // <!-- phpDesigner :: Timestamp -->3/1/2013 14:23:17<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package DevWxWeb
   * @name wxweb.php
   * @version 2
   * 
   * this script requires a minimum php 5.3 and mysql 5.0.77
   */

  $wxwebversion = "3.04.3";
  $wxwebversiondate = "<!-- phpDesigner :: Timestamp -->3/1/2013 14:23:17<!-- /Timestamp -->";
  error_reporting( ~ E_NOTICE);
  $mysql = $conf = $default = $form = array();
  /**
   * 
   * DST Auto Set
   * DONT TOUCH !!!
   * 
   * */
  ini_set('date.timezone', 'America/Detroit');
  $server = date_default_timezone_get();
  date_default_timezone_set('US/Michigan');
  define('DST', date('I'));
  date_default_timezone_set($server);

  /**
   * 
   * set your FULL relative path to the wxweb.php script 
   * 
   * */

  $fullpath = './';

  /**
   * 
   * Full URL to the wxweb.php
   * 
   * */

  $fullurl = '';

  /**
   * 
   * you should not need to edit anything below here
   * 
   * */
  define("WXSITE", $fullpath);
  define("WXURL", $fullurl);

  define("INCLU", WXSITE . "/includes");
  define("SMARTY_DIR", INCLU . "/Smarty/");
  define("CONFIGS", INCLU . "/configs/");
  define("CACHE", INCLU . "/cache/");
  define("RUNNERS", INCLU . "/runners/");
  define("LIBPATH", RUNNERS . "lib/");
  define("CACHE_URL", WXURL . "/includes/cache/");
  $conf = parse_ini_file(CONFIGS . "/wxweb.conf.php", true);

  define('GOOGLEAPI', $conf['wxweb Settings']['googleapi']);
  define("SCRIPTNAME", $conf['wxweb Settings']['scriptname']);

  define("SITENAME", $conf['wxweb Settings']['sitetitle']);

  if (!empty($conf['Database settings']['sqlext']))
  {
  			define("SQLEXT", $conf['Database settings']['sqlext']);
  } else
  {
  			define("SQLEXT", "mysql");
  }


  $mysql['loc_database'] = '';
  $mysql['loc_dbuser'] = '';
  $mysql['loc_password'] = '';
  $mysql['loc_host'] = '';

  require (LIBPATH . "/ProcessInput.inc.php");

  $default['run'] = $conf['default Settings']['run'];
  require (LIBPATH . "/CookieHandler.inc.php");


  $cookie = new CookieHandler($debug, $form, $conf);

  if (isset($form['setcookie']) && $form['setcookie'] == '1')
  {
  			$cookie->SetCookie();
  }

  $cookieisset = '0';


  if (!isset($form['passcookie']))
  {

  			if ($_COOKIE[$conf['Cookie Settings']['cookie_name']])
  			{

  						list($form['locname'], $form['state'], $form['country'], $form['run']) = $cookie->ReadCookie();
  						$cookieisset = '1';
  			}
  } else
  {

  			$form['locname'] = (isset($form['locname'])) ? $form['locname'] : '';
  			$form['state'] = (isset($form['state'])) ? $form['state'] : '';


  }
  if (isset($form['setcookie']) && $form['setcookie'] == '3')
  {
  			$cookie->DeleteCookie();
  }

  require (SMARTY_DIR . "/Smarty.class.php");


  require (RUNNERS . "/WxWebAPI.php");

  $smarty = new Smarty;
  $smarty->assign('run', $run);
  $smarty->assign('wxwebversion', $wxwebversion);
  $smarty->assign('wxwebversiondate', $wxwebversiondate);
  $smarty->assign('CACHE_URL', CACHE_URL);
  $smarty->assign('WXURL', WXURL);
  $smarty->assign('FILEPATH', WXSITE);
  $smarty->assign('cookie', $cookieisset);

  $conf['run'] = (!empty($form['run'])) ? $form['run'] : $default['run'];


  $api = new WxWebAPI($debug, $form, $conf, $mysql, $smarty);


  if (!empty($form['run']) && $form['run'] != 'pass')
  {


  			$api->runner($form, $runconf);
  } elseif (!empty($form['run']) && $form['run'] == 'pass')
  {
  			include (RUNNERS . '/pass.php');
  } elseif (empty($form['run']))
  {

  			$runconf = parse_ini_file(CONFIGS . '/' . $default['run'] . '.conf.php', true);
  			$runconf['run'] = $default['run'];
  			$form['run'] = $default['run'];

  			$api->runner($form, $runconf);
  }

?>