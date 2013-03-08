<?php

/**
 * 
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWebAPI
 * 
 */

Class CookieHandler{
    
    var $site;
    var $cookiename;
    
    function __construct(&$debug,$form,$conf)
    {
        $this->debug = &$debug;
        $this->form = $form;
        $this->conf = $conf;
        $this->cookiename = (isset($this->conf['Cookie Settings']['cookie_name'])) ? $this->conf['Cookie Settings']['cookie_name'] : 'WxWeb';
        $this->site = $_SERVER['HTTP_HOST'];
    }
    
    
    function ReadCookie()
    {
        
        
       
        list($loc,$st,$cty,$run) = explode("|",$_COOKIE[$this->cookiename]);
       
        
        return array($loc,$st,$cty,$run);
        
       
    }
    
    function SetCookie()
    {
        $value = "";
        $form = $this->form;
        
        if (isset($form['location']))
        {
            $forms = explode("," , $form['location']);
            
            if (count($forms) == '3')
            {
                list($form['locname'],$form['state'],$form['country']) = $forms;
            }
            else
            {
                list($form['locname'],$form['state']) = $forms;
            }
        }
        
        $location = (isset($form['locname'])) ? trim($form['locname']) : $this->conf['default Settings']['location'];
        $state = (isset($form['state'])) ? trim($form['state']) : $this->conf['default Settings']['state'];
        $country = (isset($form['country'])) ? trim($form['country']) : $this->conf['default Settings']['country'];
        $runner = (isset($form['run'])) ? $form['run'] : $this->conf['default Settings']['run'];
        
    
        
        $value = $location."|".$state."|".$country."|".$runner;
        
        
        
        setcookie($this->cookiename, $value,time()+60*60*24*30, './', $this->site,false,false);
        
        
    }
    
    function DeleteCookie()
    {
        $cookiename = $this->conf['Cookie Settings']['cookie_name'];
        
       
       setcookie($this->cookiename, '',time() - 3600, './', $this->site,false,false);
        
       
        
        return array($loc,$st,$cty);
        
       
    }
    
}

?>