<?php

/**
 * // <!-- phpDesigner :: Timestamp -->8/2/2012 17:41:47<!-- /Timestamp -->
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWebApi
 * @name pass.php
 * @version 1
 * @revision .00
 * @license http://creativecommons.org/licenses/by-sa/3.0/us/
 * 
 * 
 */
    
   
   foreach ($form as $key => $value)
   {
    
    
    
    $smarty->assign($key,$value);
   }
   
   $temp = (!empty($form['temp'])) ? $form['temp'] : 'notemp.tpl';
   
   
   $smarty->display($temp.'.tpl');
    
    
    
?>
