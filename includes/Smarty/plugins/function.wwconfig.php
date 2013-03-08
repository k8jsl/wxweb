<?php

/**
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package DevWxWeb
 * @name function.runner.php
 * @version 1
 * @usage Ties WxWebAPI with Smarty
 * Allows WxWeb to add items in Smarty Templates
 * {runner run=....}
 */

function smarty_function_wwconfig($params, $template)
{
    
    global $debug,$conf,$mysql,$smarty,$api;
    
    $newconf = parse_ini_file(CONFIGS . '/' . $params['config'] . '.conf.php', 1);
    
    foreach ($newconf as $key => $value)
    {
        $template->assign('wwconfig_' . $key , $value);
    } 
    
    
}

?>