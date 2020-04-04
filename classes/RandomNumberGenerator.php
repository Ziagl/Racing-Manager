<?php
/**
 * Created by JetBrains PhpStorm.
 * User: werner
 * Date: 25.07.13
 * Time: 16:52
 * To change this template use File | Settings | File Templates.
 */

class RandomNumberGenerator
{
    static function instance() {
        static $inst = null;
        if ($inst === null) { $inst = new self; }
        return $inst;
    }
    private function __construct() { }
    private function __clone() { }

    public static function init($min = 1, $max = 10000000)
    {
    	/*$min = 1;
    	$max = 10000000;
        // Validate parameters
        $max = ((int) $max >= 1) ? (int) $max : 100;
        $min = ((int) $min < $max) ? (int) $min : 1;
        // Curl options
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'PHP',
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_MAXREDIRS => 10,
        );
        // Curl init & run
        $ch = curl_init('http://www.random.org/integers/?num=1&min='
        . $min . '&max=' . $max . '&col=1&base=10&format=plain&rnd=new');
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        
        mt_srand(trim($content));*/
        list($usec, $sec) = explode(' ', microtime());
	$random = $sec + $usec * 1000000;
	mt_srand($random);
    }

    public static function get_random_float()
    {
        return mt_rand() / mt_getrandmax();
    }

    public static function get_random_int($start, $end)
    {
        return mt_rand($start, $end);
    }

    public static function get_random_boolean()
    {
        return mt_rand(0, 1);
    }
}