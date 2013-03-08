<?php

		/**
		 * // <!-- phpDesigner :: Timestamp -->3/1/2013 14:05:57<!-- /Timestamp -->
		 * @author MichiganWxSystem/ByTheLakeWebDevelopment sales@michiganwxsystem.com
		 * @copyright 2012
		 * @package WxWebApi
		 * @name FetchData.inc.php
		 * @version 4
		 * @revision .04
		 * @license http://creativecommons.org/licenses/by-sa/3.0/us/
		 * 
		 * 
		 */

		class FetchData
		{

            var $VERSION = "4.04";
		   function __construct($debug, $form)
		   {

		      $this->debug = $debug;
		      $this->form = $form;
              if ($this->debug) print "FetchData " . $this->VERSION ."\n";

		   }


		   function fetch_URL()
		   {

		      if (func_num_args() == '3')
		      {
		         list($url, $cache_file, $cachet) = func_get_args();
		         return FetchData::old_fetch($url, $cache_file, $cachet);
		      } elseif (func_num_args() == '4')
		      {
		         list($url, $post, $cache_file, $cachet) = func_get_args();
		         return FetchData::new_fetch($url, $post, $cache_file, $cachet);
		      }


		   }
		   function old_fetch($url, $cache_file, $cachet)
		   {


		      $now = time();
		      $now -= $cachet * 60;
		      if ($this->debug)
		         print "cache time " . gmdate('H:i:s', $now) . "\n";


		      if (file_exists(CACHE . '/' . $cache_file) && @filemtime(CACHE . '/' . $cache_file) > $now)
		      {
		         $html = file_get_contents(CACHE . '/' . $cache_file);
		         if ($this->debug)
		            print "Using Cache: Age " . gmdate('H:i:s', filemtime(CACHE . '/' . $cache_file)) . "\n";

		         return $html;
		      } else
		      {


		         $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		         $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		         $header[] = "Cache-Control: max-age=0";
		         $header[] = "Connection: keep-alive";
		         $header[] = "Keep-Alive: 300";
		         $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		         $header[] = "Accept-Language: en-us,en;q=0.5";
		         $header[] = "Pragma: "; // browsers keep this blank.


		         $curl = curl_init();

		         $fp = CACHE . '/' . $cache_file;

		         curl_setopt($curl, CURLOPT_URL, $url);
		         curl_setopt($curl, CURLOPT_USERAGENT, 'MichiganWxSystem MiWxWeb V1');
		         curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		         curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
		         curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		         curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		         curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		         //		curl_setopt($curl, CURLOPT_FILE, $fp);


		         $html = curl_exec($curl);
		         curl_close($curl);

		         if ($this->debug)
		            print "cURL Results\n" . $html;

		         $savefile = CACHE . '/' . $cache_file;

		         $handle = fopen($savefile, 'w');
		         fwrite($handle, $html);
		         fclose($handle);


		         return $html;

		      }
		   }


		   function new_fetch($url, $post, $cache_file, $cachet)
		   {


		      $urlarr = explode("|", $url);
		      $domainarr = explode("|", $url);
		      $postarr = explode("|", $post);
		      $cachearr = explode("|", $cache_file);

		      if ($this->debug)
		      {
		         print "FetchData::fetch_URL $url ... $post\n";
		      }

		      $continue = true;
		      for ($i = 0; $i < sizeof($urlarr); $i++)
		      {
		         if ($continue)
		         {

		            $domain = FetchData::getKeyVal($urlarr, $i, '');
		            $postfix = FetchData::getKeyVal($postarr, $i, '');
		            $cache = FetchData::getKeyVal($cachearr, $i, $cache_file);


		            $data = FetchData::_fetch_data($cachet, $cache, $domain, $postfix);
		            $html = $data[0];
		            $error = $data[1];

		            if (!$error && $html != '')
		            {
		               $continue = false;
		            }

		         }
		      }
		      return $html;

		   } // end function


		   function _fetch_data($cachet, $cache, &$domain, &$postfix)
		   {


		      if (!FetchData::check_cache($cachet, $cache))
		      {
		         if ($this->debug)
		         {
		            print "...Cache File exists and not expired.\n";
		         }
		         $html = file_get_contents(CACHE . '/' . $cache);
		      } else
		      {

		         $html = FetchData::cURL($domain, $postfix);

		         if ($html != '' && !preg_match('/Page Not Found|WxWeb Error|404.+Not Found|[^\*]error\s+?\d+\b/is', $html))
		         {
		            if (file_exists(CACHE . '/' . $cache))
		               unlink(CACHE . '/' . $cache);

		            $savefile = CACHE . '/' . $cache;

		            $handle = fopen($savefile, 'w');
		            fwrite($handle, $html);
		            fclose($handle);
		         } else
		         {


		            if ($nope == '')
		            {
		               $nope = 'WxWeb Error';
		            }


		            return array($nope, 1);

		         }


		      }

		      return array($html, 0);
		   }


		   function check_cache($cachet, $cache_file)
		   {

		      $expired = false;


		      if (file_exists(CACHE . '/' . $cache_file) == false)
		      {
		         if ($this->debug)
		            echo "Cache File doesnt exist\n";
		         return true;
		      }

		      $age = (time() - filemtime(CACHE . '/' . $cache_file)) / 60;

		      if ($age >= $cachet)
		      {
		         $expired = true;
		      }

		      if ($expired == true)
		      {
		         if ($this->debug)
		         {
		            echo "...Cache file expired<br>\n";
		         }
		         return $expired;
		      } else
		      {
		         return false;
		      }

		   }


		   function cURL($prefix, $postfix)
		   {

		      $url = $prefix . $postfix;


		      $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		      $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		      $header[] = "Cache-Control: max-age=0";
		      $header[] = "Connection: keep-alive";
		      $header[] = "Keep-Alive: 300";
		      $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		      $header[] = "Accept-Language: en-us,en;q=0.5";
		      $header[] = "Pragma: "; // browsers keep this blank.


		      $curl = curl_init();


		      curl_setopt($curl, CURLOPT_URL, $url);
		      curl_setopt($curl, CURLOPT_USERAGENT, 'MichiganWxSystem MiWxWeb V1');
		      curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		      curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
		      curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		      curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

		      $html = curl_exec($curl);
		      curl_close($curl);

		      return $html;


		   }


		   function getKeyVal(&$hash, $key, $default)
		   {
		      if (isset($hash[$key]))
		      {
		         return $hash[$key];
		      } else
		      {
		         return $default;
		      }
		   }


		}

?>
