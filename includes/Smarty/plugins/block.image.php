<?php

/**
 * 
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWeb-Image
 * 
 *
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.image.php
 * Type:     block
 * Name:     image
 * Purpose:  create an image
 * -------------------------------------------------------------
 */
 
 require_once(LIBPATH . "/image/ImageTemplate.inc.php");
 
function smarty_block_image($params, $content, Smarty_Internal_Template $template, &$repeat)
{
    
    global $runconf,$form,$database,$fetch,$conf,$debug,$mysql;
    
    $TemplateRun = new ImageTemplate($runconf,$form,$database,$fetch,$conf,$debug,$mysql,$template);
    
    // only output on the closing tag
    if(!$repeat){
        if (isset($content)) {
            
            
            $image = $TemplateRun->loadtemplate($params,$content);
            
            
            //return $image;
        }
    }
}


?>