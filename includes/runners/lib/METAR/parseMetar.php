<?php

  // $Id: parseMetar.php,v 1.6 2004/01/05 01:17:08 mysigp226 Exp $
  //
  // Copyright (C) 2003 // Tyler Allison <tyler@allisonhouse.com>
  //
  // Project  Developers
  //        Tyler Allison <tyler@allisonhouse.com>
  //        W.H.Welch <whw@whw3.com>
  //
  //
  // (see the file LICENSE in the NOAH Weather package for more details)
  //
  //  http://www.noahweather.org


  //


  /*
  * This code based on:
  * Martin Geisler <gimpster@gimpster.com>
  * phpweather.php,v 1.33 2003/06/14 23:34:59
  * of phpweather.sourceforge.net
  *  
  */

  /**
   * // <!-- phpDesigner :: Timestamp -->1/25/2013 8:42:04<!-- /Timestamp -->
   * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
   * @copyright 2012
   * @package WxWebApi
   * @name pareMetar.php
   * @version 2
   * @revision .04.1
   * @license http://creativecommons.org/licenses/by-sa/3.0/us/
   * RMK decoding/Weather Name/Cloud routines updated/added Copyright 2010 MichiganWxSystem
   * 
   */

  //error_reporting(0);
  class parseMetars
  {

  			/**
  			 * The decoded METAR is stored here.
  			 *
  			 * $decoded_metar is an array of arrays. Each sub-array corresponds
  			 * to a group of related weather-info. We have cloud-groups,
  			 * visibility-groups and so on.
  			 *
  			 * @var  array
  			 */
  			var $decoded_metar;
  			/**
  			 * parseMetars::__construct()
  			 * 
  			 * @return
  			 */
  			function __construct($debug, $form, $smarty, $conf)
  			{


  						$this->debug = $debug;
  						$this->form = $form;
  						$this->smarty = $smarty;
                        $this->conf = $conf;
                        
                        
  			}
  			/**
  			 * parseMetars::parseMetar()
  			 * 
  			 * @return
  			 */
  			function parseMetar($raw_metar)
  			{
  						$return = $this->decode_metar($raw_metar);
  			}
  			/**
  			 * Helper-function used to store temperatures.
  			 *
  			 * Given a numerical temperature $temp in Celsius, coded to tenth of
  			 * degree, store in $temp_c, convert to Fahrenheit and store in
  			 * $temp_f.
  			 *
  			 * @param string   Temperature to convert, coded to tenth of
  			 *                 degree, like 1015
  			 * @param   integer   Temperature measured in degrees Celsius
  			 * @param   integer   Temperature measured in degrees Fahrenheit
  			 * @access  private
  			 */
  			/**
  			 * parseMetars::store_temp()
  			 * 
  			 * @return
  			 */
  			function store_temp($temp, &$temp_c, &$temp_f)
  			{
  						/*
  						* Note: $temp is converted to negative if $temp > 100.0 (See
  						* Federal Meteorological Handbook for groups T, 1, 2 and 4). 
  						* For example, a temperature of 2.6°C and dew point of -1.5°C 
  						* would be reported in the body of the report as "03/M01" and the
  						* TsnT'T'T'snT'dT'dT'd group as "T00261015").  
  						*/

  						if ($temp[0] == 1)
  						{
  									$temp[0] = '-';
  						}
  						$temp_c = round($temp, 0);
  						/* The temperature in Fahrenheit. */
  						$temp_f = round($temp * (9 / 5) + 32, 0);
  			}


  			/**
  			 * Helper-function used to store speeds.
  			 *
  			 * $value is converted and stored based on $windunit.
  			 *
  			 * @param  float   The value one seeks to convert.
  			 * @param  string  The unit of $value.
  			 * @param  float &$knots   After $value has been converted into knots,
  			 *                         it will be stored in this variable.
  			 * @param  float &$meterspersec   After $value has been converted into
  			 *                                meters per second, it will be stored 
  			 *                                in this variable.
  			 * @param  float &$milesperhour   After $value has been converted into
  			 *                                miles per hour, it will be stored 
  			 *                                in this variable.
  			 * @access  private
  			 */
  			/**
  			 * parseMetars::store_speed()
  			 * 
  			 * @return
  			 */
  			function store_speed($value, $windunit, &$knots, &$meterspersec, &$milesperhour)
  			{
  						if ($value == 0)
  						{
  									$knots = 0;
  									$meterspersec = 0;
  									$milesperhour = 0;
  									return;
  						}

  						if ($windunit == 'KT')
  						{
  									/* The windspeed measured in knots: */
  									$knots = number_format($value);
  									/* The windspeed measured in meters per second, rounded to one
  									decimal place  */
  									$meterspersec = number_format($value * 0.5144);
  									/* The windspeed measured in miles per hour, rounded to one
  									decimal place */
  									$milesperhour = number_format($value * 1.1508);
  						} elseif ($windunit == 'MPS')
  						{
  									/* The windspeed measured in meters per second */
  									$meterspersec = number_format($value);
  									/* The windspeed measured in knots, rounded to one decimal
  									place */
  									$knots = number_format($value / 0.5144);
  									/* The windspeed measured in miles per hour, rounded to one
  									decimal place */
  									$milesperhour = number_format($value / 0.5144 * 1.1508);
  						} elseif ($windunit == 'KMH')
  						{
  									/* The windspeed measured in kilometers per hour */
  									$meterspersec = number_format($value * 1000 / 3600);
  									$knots = number_format($value * 1000 / 3600 / 0.5144);
  									/* The windspeed measured in miles per hour, rounded to one
  									decimal place */
  									$milesperhour = number_format($knots * 1.1508);
  						}
  			}


  			/**
  			 * Decodes a raw METAR.
  			 *
  			 * This function loops over the various parts of the raw METAR, and
  			 * stores the different bits in $decoded_metar. It uses get_metar() to
  			 * retrieve the METAR, so it is not necessary to connect to the database
  			 * before you call this function.
  			 *
  			 * @return  array   The decoded METAR.
  			 * @see     $decoded_metar
  			 * @access  public
  			 */
  			/**
  			 * parseMetars::decode_metar()
  			 * 
  			 * @return
  			 */
  			function decode_metar($raw_metar)
  			{
  						/* initialization */

  						$temp_visibility_miles = '';

  						$decoded_metar['remarks'] = '';
  						$decoded_metar['temp_c'] = 'N/A';
  						$decoded_metar['temp_f'] = 'N/A';
  						$decoded_metar['weather_conditionb'] = '';
  						$decoded_metar['weather_conditionc'] = '';
  						$decoded_metar['weather_conditiond'] = '';
  						$decoded_metar['weather_conditione'] = '';
  						$decoded_metar['weather_condition'] = '';


  						$decoded_metar['metar'] = $raw_metar;
  						$decoded_metar = $this->get_remarks($raw_metar);
  						$decoded_metar = $this->get_cloud_cover_full($raw_metar, $decoded_metar);
  						$parts = explode(' ', $raw_metar);
  						$num_parts = count($parts);
  						for ($i = 0; $i < $num_parts; $i++)
  						{
  									$part = $parts[$i];
  									//     print "debug $raw_metar<br/>";
  									if (preg_match('/RMK|TEMPO|BECMG|INTER/', $part))
  									{
  												/* The rest of the METAR is either a remark or temporary
  												* information. We skip the rest of the METAR. 
  												*/
  												//$decoded_metar['remarks'] .= ' ' . $part;
  												break;
  									} elseif ($part == 'METAR')
  									{
  												/*
  												* Type of Report: METAR
  												*/
  												$decoded_metar['type'] = 'METAR';
  									} elseif ($part == 'SPECI')
  									{
  												/*
  												* Type of Report: SPECI
  												*/
  												$decoded_metar['type'] = 'SPECI';
  									} elseif (preg_match('/^[\d\/\s\:]+([A-Z 0-9]{4})$/', $part, $regs) && empty($decoded_metar['icao']))
  									{
  												/*
  												* Station Identifier
  												*/
  												$decoded_metar['icao'] = $regs[1];
  									} elseif (preg_match('/(\d\d)(\d\d)(\d\d)Z/i', $part, $regs))
  									{
  												/*
  												* Date and Time of Report.
  												*
  												* We return a standard Unix UTC/GMT timestamp suitable for
  												* gmdate().
  												*/
  												if ($regs[1] > gmdate('j'))
  												{
  															/* The day is greather that the current day of month => the
  															* report is from last month. 
  															*/
  															$month = gmdate('n') - 1;
  												} else
  												{
  															$month = gmdate('n');
  												}
  												$decoded_metar['created'] = gmmktime($regs[2], $regs[3], 0, $month, $regs[1], gmdate('Y'));
  									} elseif (preg_match('/(AUTO|COR|RTD|CC[A-Z]|RR[A-Z])/', $part, $regs))
  									{

  												/*
  												* Report Modifier: AUTO, COR, CCx or RRx
  												*/
  												$decoded_metar['report_mod'] = $regs[1];
  									} elseif (preg_match('/([0-9]{3}|VRB)([0-9]{2,3})G?([0-9]{2,3})?(KT|MPS|KMH)/', $part, $regs))
  									{

  												/* Wind Group */

  												if ($regs[1] == 'VRB')
  												{
  															$decoded_metar['wind_deg'] = 'VRB';
  															$decoded_metar['wind_eng'] = 'VRB';
  												} else
  												{
  															$decoded_metar['wind_deg'] = $regs[1];
  															$compass = array(
  																		'N',
  																		'NNE',
  																		'NE',
  																		'ENE',
  																		'E',
  																		'ESE',
  																		'SE',
  																		'SSE',
  																		'S',
  																		'SSW',
  																		'SW',
  																		'WSW',
  																		'W',
  																		'WNW',
  																		'NW',
  																		'NNW');
  															$decoded_metar['wind_eng'] = $compass[round($regs[1] / 22.5) % 16];
  												}

  												$wind_speed = $this->store_speed($regs[2], $regs[4], $decoded_metar['wind_knots'], $decoded_metar['wind_mps'], $decoded_metar['wind_mph']);

  												if (!empty($regs[3]))
  												{

  															/* We have a report with information about the gust.
  															* First we have the gust measured in knots.
  															*/
  															$gust_speed = $this->store_speed($regs[3], $regs[4], $decoded_metar['wind_gust_knots'], $decoded_metar['wind_gust_mps'], $decoded_metar['wind_gust_mph']);
  												} else
  												{
  															$decoded_metar['wind_gust_mph'] = $decoded_metar['wind_gust_knots'] = $decoded_metar['wind_gust_mps'] = '';
  												}
  									} elseif (preg_match('/^([0-9]{3})V([0-9]{3})$/', $part, $regs) && !empty($decoded_metar['wind']))
  									{

  												/*
  												* Variable wind-direction
  												*/
  												$decoded_metar['wind_var_beg'] = $regs[1];
  												$decoded_metar['wind_var_end'] = $regs[2];
  									} elseif (preg_match('/^([0-9]{4})([NS]?[EW]?)$/', $part, $regs))
  									{
  												/*
  												* Visibility in meters (4 digits only)
  												*/

  												if ($regs[1] == '0000')
  												{
  															/* Special low value */
  															$decoded_metar['visibility_prefix'] = -1;
  															/* Less than */
  															$decoded_metar['visibility_meter'] = 50;
  															$decoded_metar['visibility_km'] = 0.05;
  															$decoded_metar['visibility_ft'] = 164;
  															$decoded_metar['visibility_miles'] = 0.031;
  												} elseif ($regs[1] == 'N/A')
  												{
  															/* Special high value */
  															$decoded_metar['visibility_prefix'] = 1;
  															$decoded_metar['visibility_meter'] = 10000;
  															$decoded_metar['visibility_km'] = 10;
  															$decoded_metar['visibility_ft'] = 32800;
  															$decoded_metar['visibility_miles'] = 6.2;
  												} else
  												{
  															/* Normal visibility, returned in both small and large units. */
  															$decoded_metar['visibility_prefix'] = 0;
  															$decoded_metar['visibility_km'] = number_format($regs[1] / 1000, 1);
  															$decoded_metar['visibility_miles'] = round($regs[1] / 1609.344, 2);
  															$decoded_metar['visibility_meter'] = $regs[1] * 1;
  															$decoded_metar['visibility_ft'] = round($regs[1] * 3.28084);
  												}
  												if (!empty($regs[2]))
  												{
  															$decoded_metar['visibility_dir'] = $regs[2];
  												}

  									} elseif (preg_match('/^[0-9]$/', $part))
  									{
  												/*
  												* Temp Visibility Group, single digit followed by space.
  												*/
  												$temp_visibility_miles = $part;
  									} elseif (preg_match('/M?(([0-9]?)[ ]?([0-9])(\/?)([0-9]*))SM$/', $temp_visibility_miles . ' ' . $part, $regs))
  									{
  												/*
  												* Visibility Group
  												*/

  												if ($regs[4] == '/')
  												{
  															$vis_miles = $regs[2] + $regs[3] / $regs[5];
  												} else
  												{
  															$vis_miles = $regs[1];
  												}
  												if ($regs[0][0] == 'M')
  												{
  															/* Prefix - less than */
  															$decoded_metar['visibility_prefix'] = -1;
  												} else
  												{
  															$decoded_metar['visibility_prefix'] = 0;
  												}

  												/* The visibility measured in miles */
  												$decoded_metar['visibility_miles'] = round($vis_miles, 2);

  												/* The visibility measured in feet */
  												$decoded_metar['visibility_ft'] = round($vis_miles * 5280, 1);

  												/* The visibility measured in kilometers */
  												$decoded_metar['visibility_km'] = number_format($vis_miles * 1.6093, 1);

  												/* The visibility measured in meters */
  												$decoded_metar['visibility_meter'] = round($vis_miles * 1609.3);

  									} elseif ($part == 'CAVOK')
  									{
  												/* CAVOK is used when the visibility is greater than 10
  												* kilometers, the lowest cloud-base is at 5000 feet or more
  												* and there is no significant weather.
  												*/
  												$decoded_metar['visibility_prefix'] = 1;
  												$decoded_metar['visibility_km'] = 10;
  												$decoded_metar['visibility_meter'] = 10000;
  												$decoded_metar['visibility_miles'] = 6.2;
  												$decoded_metar['visibility_ft'] = 32800;
  												$decoded_metar['clouds_condition'] = 'Clear';

  									} elseif (preg_match('/^R([0-9]{2})([RLC]?)([MP]?)([0-9]{4})([DNU]?)V?(P?)([0-9]{4})?([DNU]?)$/', $part, $regs))
  									{
  												/* Runway-group */
  												unset($group);
  												$group['nr'] = $regs[1];
  												if (!empty($regs[2]))
  												{
  															$group['approach'] = $regs[2];
  												}

  												if (!empty($regs[7]))
  												{
  															/* We have both min and max visibility since $regs[7] holds
  															* the max visibility.
  															*/
  															if (!empty($regs[5]))
  															{
  																		/* $regs[5] is tendency for min visibility. */
  																		$group['min_tendency'] = $regs[5];
  															}

  															if (!empty($regs[8]))
  															{
  																		/* $regs[8] is tendency for max visibility. */
  																		$group['max_tendency'] = $regs[8];
  															}

  															if ($regs[3] == 'M')
  															{
  																		/* Less than. */
  																		$group['min_prefix'] = -1;
  															}
  															$group['min_meter'] = $regs[4] * 1;
  															$group['min_ft'] = round($regs[4] * 3.2808);

  															if ($regs[6] == 'P')
  															{
  																		/* Greater than. */
  																		$group['max_prefix'] = 1;
  															}
  															$group['max_meter'] = $regs[7] * 1;
  															$group['max_ft'] = round($regs[7] * 3.2808);

  												} else
  												{
  															/* We only have a single visibility. */

  															if (!empty($regs[5]))
  															{
  																		/* $regs[5] holds the tendency for visibility. */
  																		$group['tendency'] = $regs[5];
  															}

  															if ($regs[3] == 'M')
  															{
  																		/* Less than. */
  																		$group['prefix'] = -1;
  															} elseif ($regs[3] == 'P')
  															{
  																		/* Greater than. */
  																		$group['prefix'] = 1;
  															}
  															$group['meter'] = $regs[4] * 1;
  															$group['ft'] = round($regs[4] * 3.2808);
  												}
  												$decoded_metar['runway'][] = $group;

  									} elseif (preg_match('/^(-|\+)?' . /* Intensity */ '(VC)?' . '(MI|PR|BC|DR|BL|SH|TS|FZ)?' . /* Descriptor */
  									'((DZ|RA|SN|SG|IC|PL|GR|GS|UP)+)?' . /* Precipitation */ '(BR|FG|FU|VA|DU|SA|HZ|PY)?' . /* Obscuration */ '(PO|SQ|FC|SS)?$/',
  												/* Other */ $part, $regs))
  									{

  												$wxCode = array(
  															'VC' => 'nearby',
  															'MI' => 'shallow',
  															'PR' => 'partial',
  															'BC' => 'patches of',
  															'DR' => 'low drifting',
  															'BL' => 'blowing',
  															'SH' => 'showers',
  															'TS' => 'thunderstorm',
  															'FZ' => 'freezing',
  															'DZ' => 'drizzle',
  															'RA' => 'rain',
  															'SN' => 'snow',
  															'SG' => 'snow grains',
  															'IC' => 'ice crystals',
  															'PE' => 'ice pellets',
  															'GR' => 'hail',
  															'GS' => 'small hail', // and/or snow pellets
  															'UP' => 'unknown',
  															'BR' => 'mist',
  															'FG' => 'fog',
  															'FU' => 'smoke',
  															'VA' => 'volcanic ash',
  															'DU' => 'widespread dust',
  															'SA' => 'sand',
  															'HZ' => 'haze',
  															'PY' => 'spray',
  															'PO' => 'well-developed dust/sand whirls',
  															'SQ' => 'squalls',
  															'FC' => 'funnel cloud, tornado, or waterspout',
  															'SS' => 'sandstorm/duststorm');
  												$cond = '';
  												if ($regs[1] == '-')
  															$cond = 'light';
  												if ($regs[1] == '+')
  															$cond = 'heavy';
  												if ($regs[2])
  															$cond .= " " . $wxCode[$regs[2]];
  												if ($regs[3])
  															$cond .= " " . $wxCode[$regs[3]];
  												if ($regs[4])
  															$cond .= " " . $wxCode[$regs[4]];
  												//	if ($regs[6])$cond .= " ".$wxCode[$regs[6]];

  												$decoded_metar['weather']['proximity'] = $regs[2];

  												$decoded_metar['weather_condition'] = trim($cond);


  									} elseif ($part == 'SKC')
  									{
  												/* Cloud-group */
  												$decoded_metar['clouds_condition'] = 'Clear';
  									} elseif ($part == 'CLR')
  									{
  												/* Cloud-group */
  												$decoded_metar['clouds_condition'] = 'Clear';
  									} elseif (preg_match('/^(VV|FEW|SCT|BKN|OVC)([0-9]{3}|)' . '(CB|TCU)?$/', $part, $regs))
  									{
  												/* We have found (another) a cloud-layer-group. */

  												if (@!$decoded_metar['clouds_conditions'])
  												{
  															if ($regs[1] == 'VV')
  															{
  																		$decoded_metar['clouds_condition'] = 'Obscured';
  															} elseif ($regs[1] == 'FEW')
  															{
  																		$decoded_metar['clouds_condition'] = 'Partly Cloudy';
  															} elseif ($regs[1] == 'SCT')
  															{
  																		$decoded_metar['clouds_condition'] = 'Scattered Clouds';
  															} elseif ($regs[1] == 'BKN')
  															{
  																		$decoded_metar['clouds_condition'] = 'Mostly Cloudy';
  															} elseif ($regs[1] == 'OVC')
  															{
  																		$decoded_metar['clouds_condition'] = 'Overcast';
  															}

  															if (!empty($regs[3]))
  															{
  																		if ($regs[3] == 'CB')
  																		{
  																					$decoded_metar['clouds_condition'] = 'Towering Cumulus';
  																		} elseif ($regs[3] == 'TCU')
  																		{
  																					$decoded_metar['clouds_condition'] = 'Cumulonimbus';
  																		}
  															}

  															if ($regs[2] == '000')
  															{
  																		/* '000' is a special height. */
  																		$decoded_metar['clouds_ft'] = 100;
  																		$decoded_metar['clouds_meter'] = 30;
  																		$decoded_metar['clouds_prefix'] = -1;
  																		/* Less than */
  															} elseif ($regs[2] == '///')
  															{
  																		/* '///' means height nil */
  																		$decoded_metar['clouds_ft'] = 'nil';
  																		$decoded_metar['clouds_meter'] = 'nil';
  															} else
  															{
  																		$decoded_metar['clouds_ft'] = $regs[2] * 100;
  																		$decoded_metar['clouds_meter'] = round($regs[2] * 30.48);
  															}
  												}

  									} elseif (preg_match('/^(M?[0-9]{2})\/(M?[0-9]{2}|\/\/\/)?$/', $part, $regs))
  									{
  												/*
  												* Temperature/Dew Point Group.
  												*/
  												$decoded_metar['temp_c'] = (integer)strtr($regs[1], 'M', '-');
  												$decoded_metar['temp_f'] = round(strtr($regs[1], 'M', '-') * (9 / 5) + 32);

  												/* The dewpoint could be missing, this is indicated by the
  												* second group being empty at most places, but in the UK they
  												* use '//' instead of the missing temperature... */
  												if (!empty($regs[2]) && $regs[2] != '//')
  												{
  															$decoded_metar['dew_c'] = (integer)strtr($regs[2], 'M', '-');
  															$decoded_metar['dew_f'] = round(strtr($regs[2], 'M', '-') * (9 / 5) + 32);
  												}

  												if (!empty($regs[1]) && !$regs[1] == '00')
  												{
  															$decoded_metar['temp_c'] = 'N/A';
  															$decoded_metar['temp_f'] = 'N/A';
  												}
  												if (!empty($regs[2]) && !$regs[2] == '00')
  												{
  															$decoded_metar['dew_c'] = 'N/A';
  															$decoded_metar['dew_f'] = 'N/A';
  												}


  									} elseif (preg_match('/A([0-9]{4})/', $part, $regs))
  									{
  												/*
  												* Altimeter.
  												* The pressure measured in inHg.
  												*/
  												$decoded_metar['inhg'] = number_format($regs[1] / 100, 2);

  												/* The pressure measured in mmHg, hPa and atm */
  												$decoded_metar['mmhg'] = number_format($regs[1] * 0.254, 1, '.', '');
  												$decoded_metar['hpa'] = round($regs[1] * 0.33864);
  												$decoded_metar['atm'] = number_format($regs[1] * 3.3421e-4, 3, '.', '');
  									} elseif (preg_match('/Q([0-9]{4})/', $part, $regs))
  									{
  												/*
  												* Altimeter.
  												* The specification doesn't say anything about
  												* the Qxxxx-form, but it's in the METARs.
  												*/

  												/* The pressure measured in hPa */
  												$decoded_metar['hpa'] = round($regs[1]);

  												/* The pressure measured in mmHg, inHg and atm */
  												$decoded_metar['mmhg'] = number_format($regs[1] * 0.75006, 1, '.', '');
  												$decoded_metar['inhg'] = number_format($regs[1] * 0.02953, 2);
  												$decoded_metar['atm'] = number_format($regs[1] * 9.8692e-4, 3, '.', '');
  									} else
  									{

  												/*
  												* If we couldn't match the group, we assume that it was a
  												* remark.
  												*/
  												$decoded_metar['remarks'] .= ' ' . $part;
  									}
  						}

  						/*
  						* Relative humidity
  						*/
  						if (!empty($decoded_metar['temp_f']) && !empty($decoded_metar['dew_f']))
  						{

  									$decoded_metar['rel_humidity'] = number_format(pow(10, (1779.75 * ($decoded_metar['dew_c'] - $decoded_metar['temp_c']) / ((237.3 +
  												$decoded_metar['dew_c']) * (237.3 + $decoded_metar['temp_c'])) + 2)));
  						}
  						/**
  						 * if (empty($decoded_metar['temp_c']) && empty($decoded_metar['dew_c']))
  						 * {
  						 * $decoded_metar['temp_c'] = $decoded_metar['dew_c'] = 'N/A';
  						 * $decoded_metar['temp_f'] = $decoded_metar['dew_f'] = 'N/A';
  						 * }
  						 * if ($decoded_metar['temp_c'] == 'N/A' && $decoded_metar['dew_c'] ==
  						 * 'N/A')
  						 * {
  						 * $decoded_metar['rel_humidity'] = 'N/A';
  						 * }
  						 ***/
  						/*
  						*  Compute windchill if windspeed > 3 mph
  						*/
  						if ($decoded_metar['wind_mph'] > 3 && $decoded_metar['temp_f'] < 40)
  						{
  									//$chillF = 35.74 + (.6215 * $tempF) - (35.75 * pow($windspeed,0.16)) + (0.4275 * $tempF * pow($windspeed,0.16));
  									$decoded_metar['windchill_f'] = number_format(35.74 + (0.6215 * $decoded_metar['temp_f']) - (35.75 * pow($decoded_metar['wind_mph'],
  												0.16)) + (0.4275 * $decoded_metar['temp_f']) * pow($decoded_metar['wind_mph'], 0.16));
  									$decoded_metar['windchill_c'] = number_format(13.112 + 0.6215 * $decoded_metar['temp_c'] - 13.37 * pow(($decoded_metar['wind_mph'] /
  												1.609), 0.16) + 0.3965 * $decoded_metar['temp_c'] * pow(($decoded_metar['wind_mph'] / 1.609), 0.16));
  						} else
  						{
  									$decoded_metar['windchill_f'] = $decoded_metar['temp_f'];
  									$decoded_metar['windchill_c'] = $decoded_metar['temp_c'];
  						}
  						if ($decoded_metar['temp_c'] == 'N/A' && $decoded_metar['dew_c'] == 'N/A')
  						{
  									$decoded_metar['windchill_f'] = $decoded_metar['temp_f'];
  									$decoded_metar['windchill_c'] = $decoded_metar['temp_c'];
  						}
  						/*
  						* Compute heat index if temp > 70F
  						*/
  						if (!empty($decoded_metar['temp_f']) && $decoded_metar['temp_f'] > 70 && !empty($decoded_metar['rel_humidity']))
  						{
  									$tempF = $decoded_metar['temp_f'];
  									$rh = $decoded_metar['rel_humidity'];

  									$hiF = -42.379 + 2.04901523 * $tempF + 10.14333127 * $rh - 0.22475541 * $tempF * $rh;
  									$hiF += -0.00683783 * pow($tempF, 2) - 0.05481717 * pow($rh, 2);
  									$hiF += 0.00122874 * pow($tempF, 2) * $rh + 0.00085282 * $tempF * pow($rh, 2);
  									$hiF += -0.00000199 * pow($tempF, 2) * pow($rh, 2);

  									$decoded_metar['heatindex_f'] = round($hiF);
  									$decoded_metar['heatindex_c'] = round(($hiF - 32) / 1.8);
  						} else
  						{
  									$decoded_metar['heatindex_f'] = $decoded_metar['temp_f'];
  									$decoded_metar['heatindex_c'] = $decoded_metar['temp_c'];
  						}
  						if ($decoded_metar['temp_c'] == 'N/A' && $decoded_metar['dew_c'] == 'N/A')
  						{
  									$decoded_metar['heatindex_f'] = $decoded_metar['temp_f'];
  									$decoded_metar['heatindex_c'] = $decoded_metar['temp_c'];
  						}

  						if (1)
  						{
  									$decoded_metar['feelslike_f'] = ($decoded_metar['heatindex_f'] > $decoded_metar['temp_f']) ? $decoded_metar['heatindex_f'] : $decoded_metar['windchill_f'];
  						}


  						/*
  						* Compute the humidity index
  						*/
  						if (!empty($decoded_metar['rel_humidity']))
  						{
  									$e = (6.112 * pow(10, 7.5 * $decoded_metar['temp_c'] / (237.7 + $decoded_metar['temp_c'])) * $decoded_metar['rel_humidity'] / 100) -
  												10;
  									$decoded_metar['humidex_c'] = number_format($decoded_metar['temp_c'] + 5 / 9 * $e, 1);
  									$decoded_metar['humidex_f'] = number_format($decoded_metar['humidex_c'] * 9 / 5 + 32, 1);
  						}
  						/**
  						 * 
  						 *  Icon  
  						 *
  						 * */
                         $this->metar_epoch = $decoded_metar['created'];

  						if (isset($decoded_metar['weather_condition']) && preg_match('/[\w\s]+/', $decoded_metar['weather_condition']))
  						{
  									$decoded_metar['wx_icon'] = $this->hicon($decoded_metar['weather_condition'], date('H', $decoded_metar['created']));
  						} elseif(isset($decoded_metar['clouds_condition']) && preg_match('/[\w\s]+/', $decoded_metar['clouds_condition']))
  						{
  									$decoded_metar['wx_icon'] = $this->hicon($decoded_metar['clouds_condition'], date('H', $decoded_metar['created']));
  									$decoded_metar['weather_condition'] = '';
  						}else
                        {
                                    $decoded_metar['wx_icon'] = $this->hicon('NA', date('H', $decoded_metar['created']));
  									$decoded_metar['weather_condition'] = '';
                        }
                        

  						$this->decoded_metar = $decoded_metar;
  						return $decoded_metar;
  			}

  			/*
  			RMK DECIPHER 
  			*/


  			/**
  			 * parseMetars::get_remarks()
  			 * 
  			 * @return
  			 */
  			function get_remarks($data)
  			{
  						$decoded_metar['remarks'] = '';
  						if (preg_match('/RMK([^<]+)$/', $data, $nn))
  						{
  									$remarks = $decoded_metar['remarks'] = $nn[1];
  						}

  						$remarks = preg_replace("/\s+/", "\n", $remarks);
  						//echo $remarks."\n";

  						//PRECIP RMKS
  						//Hourly
  						if (preg_match('/^P([0-9][0-9])([0-9][0-9])/m', $remarks, $m))
  						{
  									if ($m[1] == '00' && $m[2] == '00')
  									{
  												$decoded_metar['rmk_recip'] = 'trace';
  									} else
  									{
  												$combine = $m[1] . '' . $m[2];
  												$decoded_metar['rmk_precip'] = $combine / 100;
  									}
  						}

  						//3 or 6
  						if (preg_match('/^6(([0-9][0-9])([0-9][0-9]))/m', $remarks, $m))
  						{
  									if ($m[2] == '00' && $m[3] == '00')
  									{
  												$decoded_metar['rmk_6precip'] = 'trace';
  									} else
  									{
  												$decoded_metar['rmk_6precip'] = $m[1] / 100;
  									}
  						}

  						//24
  						if (preg_match('/^7([0-9][0-9][0-9][0-9])/m', $remarks, $m))
  						{
  									$decoded_metar['rmk_24precip'] = $m[1] / 100;
  						}


  						//Sea Level Pressure
  						if (preg_match('/^SLP([0-9]+)([0-9])/m', $remarks, $m))
  						{
  									$decoded_metar['rmk_slp'] = '9' . $m[1] . '.' . $m[2];
  						}


  						// Snow Amount
  						if (preg_match('/^4\/([0-9][0-9][0-9])/m', $remarks, $m))
  						{
  									$decoded_metar['rmk_snowamt'] = (integer)$m[1];
  						}


  						//24hr high low temp
  						if (preg_match('/^4([0-1])([0-9][0-9][0-9])([0-1])([0-9][0-9][0-9])/m', $remarks, $pieces))
  						{
  									if ($pieces[1] == '1')
  									{
  												$decoded_metar['rmk_max24c'] = '-' . (integer)$pieces[2] / 10;
  									} else
  									{
  												$decoded_metar['rmk_max24c'] = (integer)$pieces[2] / 10;
  									}
  									if ($pieces[3] == '1')
  									{
  												$decoded_metar['rmk_min24c'] = '-' . (integer)$pieces[4] / 10;
  									} else
  									{
  												$decoded_metar['rmk_min24c'] = (integer)$pieces[4] / 10;
  									}

  									$decoded_metar['rmk_max24f'] = round(1.8 * $decoded_metar['rmk_max24c'] + 32);
  									$decoded_metar['rmk_min24f'] = round(1.8 * $decoded_metar['rmk_min24c'] + 32);
  						}

  						// hourly temp dewpt
  						if (preg_match('/^T([0-1])([0-9][0-9][0-9])([0-1])([0-9][0-9][0-9])/m', $remarks, $pieces))
  						{
  									if ($pieces[1] == '1')
  									{
  												$decoded_metar['rmk_tmphrc'] = '-' . (integer)$pieces[2] / 10;
  									} else
  									{
  												$decoded_metar['rmk_tmphrc'] = (integer)$pieces[2] / 10;
  									}
  									if ($pieces[3] == '1')
  									{
  												$decoded_metar['rmk_dewhrc'] = '-' . (integer)$pieces[4] / 10;
  									} else
  									{
  												$decoded_metar['rmk_dewhrc'] = (integer)$pieces[4] / 10;
  									}
  									$decoded_metar['rmk_tmphrf'] = round(1.8 * $decoded_metar['rmk_tmphrc'] + 32);
  									$decoded_metar['rmk_dewhrf'] = round(1.8 * $decoded_metar['rmk_dewhrc'] + 32);
  						}
  						//echo "here ".$decoded_metar['rmk']['TMPHRF']."\n";

  						// 6hr low
  						if (preg_match('/^2([0-1])([0-9][0-9][0-9])/m', $remarks, $pieces))
  						{
  									if ($pieces[1] == '1')
  									{
  												$decoded_metar['rmk_low6c'] = '-' . (integer)$pieces[2] / 10;
  									} else
  									{
  												$decoded_metar['rmk_low6c'] = (integer)$pieces[2] / 10;
  									}

  									$decoded_metar['rmk_low6f'] = round(1.8 * $decoded_metar['rmk_low6c'] + 32);
  						}

  						// 6hr high
  						if (preg_match('/^1([0-1])([0-9][0-9][0-9])/m', $remarks, $pieces))
  						{
  									if ($pieces[1] == '1')
  									{
  												$decoded_metar['rmk_high6c'] = '-' . (integer)$pieces[2] / 10;
  									} else
  									{
  												$decoded_metar['rmk_high6c'] = (integer)$pieces[2] / 10;
  									}
  									$decoded_metar['rmk_high6f'] = round(1.8 * $decoded_metar['rmk_high6c'] + 32);
  						}


  						// weather observations

  						$OBCode = array(
  									'SNB' => 'snow began',
  									'SNE' => 'snow ended',
  									'RAB' => 'rain began',
  									'RAE' => 'rain ended',
  									'UPB' => 'unknown began',
  									'UPE' => 'unknown ended',
  									'SGB' => 'snow began',
  									'SGE' => 'snow ended',
  									'ICB' => 'ice began',
  									'ICE' => 'ice ended',
  									'GRB' => 'hail began',
  									'GRE' => 'hail ended',
  									'TSB' => 'thunderstorm began',
  									'TSE' => 'thunderstorm ended',
  									);


  						if (preg_match('/^(TSB|TSE|SNB|SNE|RAB|RAE|UPB|UPE)([0-9]+)(TSB|TSE|SNB|SNE|RAB|RAE|UPB|UPE)?([0-9]+)?(TSB|TSE|SNB|SNE|RAB|RAE|UPB|UPE)?([0-9]+)?(TSB|TSE|SNB|SNE|RAB|RAE|UPB|UPE)?([0-9]+)?(TSB|TSE|SNB|SNE|RAB|RAE|UPB|UPE)?([0-9]+)?/m',
  									$remarks, $pieces))
  						{
  									$decoded_metar['rmk_wxobs'] = $OBCode[$pieces[1]] . ' ' . $pieces[2];
  									if ($pieces[3])
  									{
  												$decoded_metar['rmk_wxobs'] .= ' ' . $OBCode[$pieces[3]] . ' ' . $pieces[4];
  									}
  									if ($pieces[5])
  									{
  												$decoded_metar['rmk_wxobs'] .= ' ' . $OBCode[$pieces[5]] . ' ' . $pieces[6];
  									}
  									if ($pieces[7])
  									{
  												$decoded_metar['rmk_wxobs'] .= ' ' . $OBCode[$pieces[7]] . ' ' . $pieces[8];
  									}

  						}

  						// Peak Winds

  						if (preg_match('/^PK\nWND\n(\d\d\d)(\d\d)\/(\d+)/m', $remarks, $pieces))
  						{
  									$angle = (integer)$pieces[1];
  									$compass = array(
  												'N',
  												'NNE',
  												'NE',
  												'ENE',
  												'E',
  												'ESE',
  												'SE',
  												'SSE',
  												'S',
  												'SSW',
  												'SW',
  												'WSW',
  												'W',
  												'WNW',
  												'NW',
  												'NNW');
  									$decoded_metar['rmk_pwindeng'] = $compass[round($angle / 22.5) % 16];
  									$decoded_metar['rmk_pwind'] = $pieces[2];
  									if (preg_match('/(\d\d)(\d\d)/', $pieces[3], $rr))
  									{
  												$decoded_metar['rmk_pwimdtime'] = $rr[1] . ":" . $rr[2];
  									} else
  									{
  												$decoded_metar['rmk_pwindtime'] = ":" . $pieces[3];
  									}
  						}

  						// Pressure

  						if (preg_match('/^PRES(\w\w)/m', $remarks, $uu))
  						{
  									if ($uu[1] == 'RR')
  									{
  												$decoded_metar['rmk_prtrend'] = 'pressure rapidly rising';
  									}
  									if ($uu[1] == 'FR')
  									{
  												$decoded_metar['rmk_prtrend'] = 'pressure rapidly falling';
  									}
  						}


  						$this->decoded_metar = $decoded_metar;
  						return $decoded_metar;
  			}

  			/**
  			 * parseMetars::get_cloud_cover_full()
  			 * 
  			 * @return
  			 */
  			function get_cloud_cover_full($data, $decoded_metar)
  			{
  						$decoded_metar['cldfull'] = '';
  						//$conditionsf='';
  						//$wxInfo['CLOUDS']='';
  						// Decodes cloud cover information. This function maybe called several times
  						// to decode all cloud layer observations. Only the last layer is saved.
  						// Format is SKC or CLR for clear skies, or cccnnn where ccc = 3-letter code and
  						// nnn = altitude of cloud layer in hundreds of feet. 'VV' seems to be used for
  						// very low cloud layers. (Other conversion factor: 1 m = 3.28084 ft)
  						$cloudCodeF = array(
  									'SKC' => 'Unlimited',
  									'CLR' => 'unlimited',
  									'NSC' => 'No significant clouds are observed below 5000 feet or below the minimum sector altitude',
  									'FEW' => 'partly cloudy',
  									'SCT' => 'scattered clouds',
  									'BKN' => 'mostly cloudy',
  									'OVC' => 'overcast',
  									'VV' => 'vertical visibility');
  						//echo $data."\n";
  						if (preg_match_all('/(NSC|SKC|CLR|FEW|SCT|BKN|OVC|VV)(\d\d\d)?(TCU|CB)?/s', $data, $pieces))
  						{
  									for ($cc = 0; $cc < count($pieces[0]); $cc++)
  									{
  												if (!$pieces[3][$cc])
  												{
  															$decoded_metar['cldfull'] .= $cloudCodeF[$pieces[1][$cc]];
  												}
  												//echo "hello ".$pieces[1][$cc]." ".$pieces[2][$cc]." ".$pieces[3][$cc]."\n";
  												if ($pieces[3][$cc] == 'TCU')
  												{
  															$decoded_metar['cldfull'] .= 'towering cumulus clouds';
  												}
  												if ($pieces[3][$cc] == 'CB')
  												{
  															$decoded_metar['cldfull'] .= 'cumulonimbus clouds';
  												}
  												if (!$pieces[2][$cc])
  												{
  															$decoded_metar['cldfull'] .= ', ';
  												}
  												if ($pieces[2][$cc])
  												{
  															$altitude = (integer)100 * $pieces[2][$cc]; // units are feet
  															$decoded_metar['cldfull'] .= " ~ $altitude ft, ";
  												}


  									}
  						}
  						$this->decoded_metar = $decoded_metar;
  						return $decoded_metar;
  			}

  			/**
  			 * parseMetars::get_wx_item()
  			 * 
  			 * @return
  			 */
  			function get_wx_item($wx)
  			{
  						$wxinfo = '';

  						$wx = preg_replace("/\//", " or ", $wx);
  						//echo "$wx<br/>";

  						$wxparms = file_get_contents(CONFIGS . "/metaricon.ini.php");
  						$wxparms = preg_replace("/<\?/", "", $wxparms);
  						$wxparms = preg_replace("/\/\*/", "", $wxparms);
  						$wxparms = preg_replace("/\[.+?\]/", "", $wxparms);
  						$lines = preg_split('/[\r\n]/', $wxparms);
  						foreach ($lines as $line)
  						{
  									if (!$line)
  												continue;

  									list($key, $wxitems) = preg_split("/\=/", $line);
  									$key = str_replace('/', ' or ', $key);

  									if (preg_match("/" . $wx . "/i", $key))
  									{
  												$wxinfo = $wxitems;
  												break;
  									}
  						}
  						//echo "$wxinfo ... $wx ... $key<br>";
  						return $wxinfo;
  			}

  			/**
  			 * parseMetars::hicon()
  			 * 
  			 * @return
  			 */
  			function hicon($wx, $hr)
    		{
    		      $epoch = $this->metar_epoch;

    				$wxinfo = $this->get_wx_item($wx);

    				$wxdata = explode('|', $wxinfo);
                    
                    if (isset($this->conf['Day Light']['use_astro']))
                    {
                        $sunrise = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 90, $this->conf['tzoff']);
  						$sunset = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $this->conf['lat'], $this->conf['lon'], 90, $this->conf['tzoff']);
  					//	echo "epoch $epoch .. sunrise $sunrise sunset $sunset";
                          
                          if ($epoch >= $sunrise && $epoch < $sunset)
                        {
                        //    echo "DAY\n";
                            return $wxdata[1];
                            
    				}
    				else
    				{
    				   // echo "NITE\n";
    				    return $wxdata[2];
    				}
                        
                    }
                    else
                    {
    				if ($hr >= $this->conf['Day Light']['day_start'] && $hr < $this->conf['Day Light']['day_end'])
    				{
    				    
    					return $wxdata[1];
    				}
    				else
    				{
    				    return $wxdata[2];
    				}
                    }
    		}


  } // class parseMetar


?>
