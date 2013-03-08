<?php

  /**
   * 
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebAPI
   * 
   */

  class AstroInfo
  {
  			


  			function __construct($form,$conf,$smarty)
  			{
  			          
			
  						
  						
                        $this->form = $form;
                        
                        $this->conf = $conf;
                        
                        $this->smarty = $smarty;
            }


  			function Astro()
  			{

  						


  						/**
  						 * New sunrise
  						 * */
  						$now = time();
  						$sunrise = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 90, $this->conf['tzoff']);
  						if ($now > $sunrise)
  						{
  									$this->conf['sunrise'] = date("D M d g:i A", $sunrise + 86400);
  						} else
  						{
  									$this->conf['sunrise'] = date("D M d g:i A", $sunrise);
  						}

  						/**
  						 * sunset
  						 * */

  						$sunset = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 90, $this->conf['tzoff']);
  						if ($now > $sunset)
  						{
  									$this->conf['sunset'] = date("D M d g:i A", $sunset + 86400);
  						} else
  						{
  									$this->conf['sunset'] = date("D M d g:i A", $sunset);
  						}


  						/**
  						 * civil twilite
  						 * */

  						$ctstart = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 96, $this->conf['tzoff']);
  						if ($now > $ctstart)
  						{
  									$this->conf['civil_twilite_start'] = date("D M d g:i A", $ctstart + 86400);
  						} else
  						{
  									$this->conf['civil_twilite_start'] = date("D M d g:i A", $ctstart);
  						}

  						$ctend = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 96, $this->conf['tzoff']);
  						if ($now > $ctend)
  						{
  									$this->conf['civil_twilite_end'] = date("D M d g:i A", $ctend + 86400);
  						} else
  						{
  									$this->conf['civil_twilite_end'] = date("D M d g:i A", $ctend);
  						}

  						/**
  						 * nautical
  						 * */
  						$naustart = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 102, $this->conf['tzoff']);
  						if ($now > $naustart)
  						{
  									$this->conf['nautical_twilite_start'] = date("D M d g:i A", $naustart + 86400);
  						} else
  						{
  									$this->conf['nautical_twilite_start'] = date("D M d g:i A", $naustart);
  						}

  						$nauend = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 102, $this->conf['tzoff']);
  						if ($now > $nauend)
  						{
  									$this->conf['nautical_twilite_end'] = date("D M d g:i A", $nauend + 86400);
  						} else
  						{
  									$this->conf['nautical_twilite_end'] = date("D M d g:i A", $nauend);
  						}

  						/**
  						 * astro
  						 * */
  						$aststart = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 108, $this->conf['tzoff']);
  						if ($now > $naustart)
  						{
  									$this->conf['astro_twilite_start'] = date("D M d g:i A", $aststart + 86400);
  						} else
  						{
  									$this->conf['astro_twilite_start'] = date("D M d g:i A", $aststart);
  						}

  						$astend = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 108, $this->conf['tzoff']);
  						if ($now > $nauend)
  						{
  									$this->conf['astro_twilite_end'] = date("D M d g:i A", $astend + 86400);
  						} else
  						{
  									$this->conf['astro_twilite_end'] = date("D M d g:i A", $astend);
  						}

  						/**
  						 * moon phase
  						 * */


  						require_once (LIBPATH . '/MoonPhase/moon-phase.inc.php');


  						list($phase, $age) = moon_phases_shortcode_handler();


  						$moonagedays = round($age, 0);
  						if ($moonagedays > 29)
  						{
  									$moonagedays = 29;
  						}


  						$this->conf['moon_phase'] = $phase;

  						$this->conf['moon_image'] = "moon" . $moonagedays . ".gif";


  						$this->smarty->assign('sunset', $this->conf['sunset']);
  						$this->smarty->assign('sunrise', $this->conf['sunrise']);
  						$this->smarty->assign('civil_twilite_start', $this->conf['civil_twilite_start']);
  						$this->smarty->assign('civil_twilite_end', $this->conf['civil_twilite_end']);
  						$this->smarty->assign('nautical_twilite_start', $this->conf['nautical_twilite_start']);
  						$this->smarty->assign('nautical_twilite_end', $this->conf['nautical_twilite_end']);
  						$this->smarty->assign('astro_twilite_start', $this->conf['astro_twilite_start']);
  						$this->smarty->assign('astro_twilite_end', $this->conf['astro_twilite_end']);

  						$this->smarty->assign('moon_phase', $this->conf['moon_phase']);

  						$this->smarty->assign('moon_image', $this->conf['moon_image']);

  			}


  }

?>
