<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */


function smarty_modifier_IN2MM($string)
{
    $c = $string * 25.4;
    
    return round($c);
} 

?>