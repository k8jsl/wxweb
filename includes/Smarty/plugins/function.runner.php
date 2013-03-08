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

function smarty_function_runner($params, $template)
{
    
    global $debug, $form, $conf, $mysql, $smarty;

    $smarty = '';
    
    $info = @parse_ini_file(CONFIGS . '/' . $params['run'] . '.conf.php', 1);
    
    $params['internal'] = '1';
    

   
   
    $api = new WxWebAPI($debug,$params,$conf,$mysql,$template);
    
    $api->runner($params,$info); 
    
    
}

?>