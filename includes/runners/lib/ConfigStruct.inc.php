<?php

/**
 * 
 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
 * @copyright 2012
 * @package WxWebAPI
 * 
 */

Class ConfigStruct{
    
    
    function _arrayMergeRecursive($a, $b)
    {
        
        // merge arrays if both variables are arrays
        if (is_array($a) && is_array($b)) {
            // loop through each right array's entry and merge it into $a
            foreach ($b as $key => $value) {
                if (isset($a[$key])) {
                    $a[$key] = $this->_arrayMergeRecursive($a[$key], $value);
                } else {
                    if($key === 0) {
                        $a= array(0 => $this->_arrayMergeRecursive($a, $value));
                    } else {
                        $a[$key] = $value;
                    }
                }
            }
        } else {
            // one of values is not an array
            $a = $b;
        }
 
        return $a;
    }
}

?>
