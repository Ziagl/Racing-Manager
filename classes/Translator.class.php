<?php
	class Translator {
	    private static $translations = array();
	
	    public static function init($language) 
	    {
	        $temp_content = simplexml_load_file('./content/xml/' . $language . '/content.xml');
	        foreach ($temp_content as $key => $value)
	        {
	            self::$translations[(string)$value['id']] = (string)$value;
	        }
	    }

        //as smarty plugin
	    public static function translate($params, $name, $smarty)
	    {
	         $translation = '';
	         if( ! is_null($name) && array_key_exists($name, self::$translations))
	         {
	            // get variables in translation text
	            $translation = self::$translations[$name];
	            preg_match_all('/##([^#]+)##/i', $translation, $vars, PREG_SET_ORDER);
	
	            // replace with assigned smarty values
	            foreach($vars as $var) {
	                $translation = str_replace($var[0], $smarty->getTemplateVars($var[1]), $translation);
	            }
	        }
	        return $translation;
	    }

        //as php
        public static function _translate($name)
        {
            $translation = '';
            if( ! is_null($name) && array_key_exists($name, self::$translations))
            {
                // get variables in translation text
                $translation = self::$translations[$name];
            }
            return $translation;
        }
	}