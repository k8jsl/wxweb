<?php

/**
 * 
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package Dev.net
 * 
 */

Class FullState extends WxWebAPI
{
    
    function __construct($runconf,$var,$database,$fetch,$conf,$debug,$mysql,$smarty)
  			{
  			          
			
  						
  						$this->fetch = $fetch;
                        $this->var = $var;
                        $this->runconf = $runconf;
                        
                        $this->debug = $debug;
                        $this->conf = $conf;
                        $this->mysql = $mysql;
                        $this->smarty = $smarty;
                        $this->database = $database;
                        

  			}
    
    
    public function full_states()
  		{


  				$us_state_full = array(
  						'al' => 'alabama',
  						'ak' => 'alaska',
  						'az' => 'arizona',
  						'ar' => 'arkansas',
  						'ca' => 'california',
  						'co' => 'colorado',
  						'ct' => 'connecticut',
  						'de' => 'delaware',
  						'fl' => 'florida',
  						'ga' => 'georgia',
  						'hi' => 'hawaii',
  						'id' => 'idaho',
  						'il' => 'illinois',
  						'in' => 'indiana',
  						'ia' => 'iowa',
  						'ks' => 'kansas',
  						'ky' => 'kentucky',
  						'la' => 'louisiana',
  						'me' => 'maine',
  						'md' => 'maryland',
  						'ma' => 'massachusetts',
  						'mi' => 'michigan',
  						'mn' => 'minnesota',
  						'ms' => 'mississippi',
  						'mo' => 'missouri',
  						'mt' => 'montana',
  						'ne' => 'nebraska',
  						'nv' => 'nevada',
  						'nh' => 'new hampshire',
  						'nj' => 'new jersey',
  						'nm' => 'new mexico',
  						'ny' => 'new york',
  						'nc' => 'north carolina',
  						'nd' => 'north dakota',
  						'oh' => 'ohio',
  						'ok' => 'oklahoma',
  						'or' => 'oregon',
  						'pa' => 'pennsylvania',
  						'ri' => 'rhode island',
  						'sc' => 'south carolina',
  						'sd' => 'south dakota',
  						'tn' => 'tennessee',
  						'tx' => 'texas',
  						'ut' => 'utah',
  						'vt' => 'vermont',
  						'va' => 'virginia',
  						'wa' => 'washington',
  						'wv' => 'west virginia',
  						'wi' => 'wisconsin',
  						'wy' => 'wyoming',
  						'us' => 'united states',
  						'pr' => 'puerto rico',
  						'vi' => 'virgin islands',
  						'gu' => 'guam',
  						'northeast' => 'North East',
  						'northcentral' => 'North Central',
  						'northwest' => 'North West',
  						'westcentral' => 'West Coast',
  						'central' => 'Central',
  						'eastcentral' => 'East Coast',
  						'southeast' => 'South East',
  						'southcentral' => 'South',
  						'southwest' => 'South West',
  						'us' => 'United States');
                        
                        

  				  $statename = ucwords($us_state_full[strtolower($this->var['state'])]);
                  
                  $this->smarty->assign('fullstate', $statename);
                


  		}
}

?>
