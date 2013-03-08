<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_MPH2MPS($string)
{
    $c = $string / 2.237;
    
    return round($c);
} 

?>