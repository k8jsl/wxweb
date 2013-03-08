<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_MPH2KPH($string)
{
    $c = $string * 1.61;
    
    return round($c);
} 

?>