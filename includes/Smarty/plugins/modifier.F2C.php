<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_F2C($string)
{
    $c = $string * 9/5 - 32;
    
    return round($c);
} 

?>